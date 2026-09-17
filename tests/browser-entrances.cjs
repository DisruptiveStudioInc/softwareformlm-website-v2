// Desktop entrance regression: no final-state frame before GSAP is ready.
const { chromium } = require(process.env.PLAYWRIGHT_PATH || 'playwright');
const assert = require('node:assert/strict');
const base = process.env.TEST_URL || 'http://localhost:8080';
const selectors = [
  '#inner-section-1 h2 .animated-word',
  '#inner-section-1 .slide-up-stagger',
  '#inner-section-2 article.slide-up-stagger',
  '#inner-section-2 .stagger-parent:last-child .slide-up-stagger',
  '#inner-section-3 h2 .animated-word',
  '#inner-section-7 h2 .animated-word',
  '#inner-section-8 h2 .animated-word',
  '#inner-section-10 .slide-up-stagger',
];
(async () => {
  const browser = await chromium.launch({ executablePath: process.env.CHROME_PATH });
  const open = async (options = {}, dependencyMode = 'normal') => {
    const context = await browser.newContext({ viewport: { width: 1307, height: 926 }, ...options });
    await context.addCookies([{ name: 'site_language', value: 'en', url: base }]);
    await context.route('**/*', async route => {
      const url = route.request().url();
      if (!url.startsWith(base)) return route.fulfill({ status: 200, body: '' });
      if (url.includes('/vendor/gsap/')) {
        if (dependencyMode === 'failed') return route.abort();
        if (dependencyMode === 'delayed' || dependencyMode === 'timeout') {
          await new Promise(resolve => setTimeout(resolve, dependencyMode === 'timeout' ? 4500 : 1000));
        }
      }
      await route.continue();
    });
    const page = await context.newPage();
    await page.goto(base + '/en', { waitUntil: 'domcontentloaded' });
    return { context, page };
  };
  try {
    const { context, page } = await open({}, 'delayed');
    assert.equal(await page.evaluate(() => window.sfmlmAnimationBoot.state), 'pending');
    // Raw markers cover every reported group, including before navigation IDs exist.
    const pending = await page.locator('.slide-up-stagger, .slide-up-words-black, [data-title-cta-action]').evaluateAll(els => els.map(e => getComputedStyle(e).visibility));
    assert.ok(pending.length > 10 && pending.every(value => value === 'hidden'), JSON.stringify(pending));
    assert.equal(await page.locator('h1').evaluate(e => getComputedStyle(e).visibility), 'visible');
    await page.waitForFunction(() => window.sfmlmAnimationBoot.state === 'ready');
    await page.evaluate(() => document.fonts.ready);
    await page.addStyleTag({ content: 'html{scroll-behavior:auto!important;scroll-snap-type:none!important}html,body{overflow-anchor:none!important}' });
    for (const selector of selectors) {
      const result = await page.evaluate(async selector => {
        const elements = [...document.querySelectorAll(selector)];
        if (!elements.length) throw new Error('Missing targets: ' + selector);
        const triggers = ScrollTrigger.getAll().filter(t => t.animation?.targets?.().some(e => elements.includes(e)));
        if (triggers.length !== 1) throw new Error('Expected one entrance trigger: ' + selector);
        const trigger = triggers[0];
        scrollTo(0, Math.max(0, trigger.start - 10));
        await new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve)));
        const initial = elements.map(e => Number(getComputedStyle(e).opacity));
        scrollTo(0, trigger.start + 30);
        const samples = [];
        const end = performance.now() + (trigger.animation.totalDuration() + 0.3) * 1000;
        while (performance.now() < end) {
          await new Promise(requestAnimationFrame);
          samples.push(elements.map(e => Number(getComputedStyle(e).opacity)));
        }
        return { initial, samples, start: trigger.start, scroll: scrollY, animationProgress: trigger.animation.progress() };
      }, selector);
      assert.ok(result.initial.every(value => value === 0), `${selector}: hidden before trigger`);
      let previous = result.initial;
      for (const sample of result.samples) {
        assert.ok(sample.every((value, i) => value + 0.005 >= previous[i]), `${selector}: opacity must not drop during entrance`);
        previous = sample;
      }
      assert.ok(previous.every(value => value > 0.99), `${selector}: fully revealed ${JSON.stringify({previous,start:result.start,scroll:result.scroll,progress:result.animationProgress})}`);
    }
    await context.close();
    for (const [options, mode] of [
      [{ javaScriptEnabled: false }, 'normal'],
      [{ reducedMotion: 'reduce' }, 'normal'],
      [{ viewport: { width: 412, height: 823 } }, 'normal'],
      [{}, 'failed'], [{}, 'timeout'],
    ]) {
      const { context, page } = await open(options, mode);
      if (mode === 'failed' || mode === 'timeout') {
        await page.waitForFunction(() => window.sfmlmAnimationBoot.state === 'failed');
        if (mode === 'timeout') await page.waitForTimeout(1200); // late dependencies must not re-hide content
      }
      const visible = await page.locator('.slide-up-stagger, .slide-up-words-black').evaluateAll(els => els.every(e => getComputedStyle(e).visibility === 'visible' && getComputedStyle(e).opacity === '1'));
      assert.ok(visible, `static fallback: ${JSON.stringify(options)} ${mode}`);
      assert.equal(await page.locator('html').evaluate(e => e.classList.contains('animations-pending')), false);
      await context.close();
    }
    console.log('Entrance checks passed: all eight reported groups, delayed/failed/timed-out dependencies, mobile, reduced motion and no JS.');
  } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exitCode = 1; });
