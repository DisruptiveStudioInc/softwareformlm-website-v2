// Optional live-provider check: opens chat but never submits messages or forms.
// Run separately from benchmarks; normal page-view analytics may be emitted.
const { chromium } = require(process.env.PLAYWRIGHT_PATH || 'playwright');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const base = process.env.TEST_URL || 'http://127.0.0.1:8085';
(async () => {
  const browser = await chromium.launch({ executablePath: process.env.CHROME_PATH });
  try {
    const page = await browser.newPage();
    await page.context().addCookies([{ name: 'site_language', value: 'en', url: base }]);
    await page.addInitScript(() => {
      window.chatSeen = null;
      const timer = setInterval(() => {
        const button = document.querySelector('chat-widget')?.shadowRoot?.querySelector('#lc_text-widget--btn');
        if (button?.getBoundingClientRect().width && getComputedStyle(button).visibility !== 'hidden') {
          window.chatSeen ??= performance.now();
        }
      }, 50);
      setTimeout(() => clearInterval(timer), 10000);
    });
    await page.goto(base + '/en', { waitUntil: 'domcontentloaded' });
    await page.waitForTimeout(7000);
    const result = await page.evaluate(() => ({
      chatVisibleMs: window.chatSeen,
      requests: performance.getEntriesByType('resource')
        .filter(r => /\/gtm\.js\?|leadconnectorhq.com\/loader.js|clarity.ms\/tag\//.test(r.name))
        .map(r => ({ url: r.name, startMs: r.startTime })),
      queuedGtmStarts: window.dataLayer.filter(e => e.event === 'gtm.js').length,
    }));
    assert.ok(result.chatVisibleMs !== null && result.chatVisibleMs <= 5000, 'chat visible within five seconds');
    const gtm = result.requests.filter(r => r.url.includes('/gtm.js?'));
    assert.equal(gtm.length, 1);
    assert.ok(gtm[0].startMs >= 4900 && gtm[0].startMs <= 5500, 'GTM navigation deadline');
    assert.equal(result.queuedGtmStarts, 1);
    assert.equal(result.requests.filter(r => r.url.includes('leadconnectorhq.com/loader.js')).length, 1);
    assert.equal(result.requests.filter(r => r.url.includes('clarity.ms/tag/')).length, 1);
    await page.locator('chat-widget #lc_text-widget--btn').click();
    await page.locator('chat-widget [data-active="true"]').waitFor({ state: 'attached' });
    await page.locator('chat-widget textarea[aria-label="Message"]').waitFor({ state: 'visible' });
    result.singleClickOpened = true;
    fs.mkdirSync('performance/runs/browser', { recursive: true });
    fs.writeFileSync('performance/runs/browser/live-tracking.json', JSON.stringify(result, null, 2));
    console.log(JSON.stringify(result, null, 2));
  } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exitCode = 1; });
