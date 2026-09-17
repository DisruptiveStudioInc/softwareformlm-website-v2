// PLAYWRIGHT_PATH=/path/to/playwright CHROME_PATH=/path/to/chrome node tests/browser-performance.cjs
// Run separately from benchmarks so browser test CPU does not skew their results.
const { chromium } = require(process.env.PLAYWRIGHT_PATH || 'playwright');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const { execFileSync } = require('node:child_process');
const base = process.env.TEST_URL || 'http://127.0.0.1:8085';
const output = 'performance/runs/browser';
fs.mkdirSync(output, { recursive: true });

(async () => {
  const browser = await chromium.launch({ executablePath: process.env.CHROME_PATH, headless: true });
  const results = [];
  try {
    for (const spec of [
      { width: 412, height: 823, dpr: 1.75, lang: 'en' },
      { width: 360, height: 640, dpr: 3, lang: 'es' },
      { width: 1440, height: 900, dpr: 1, lang: 'en' },
      { width: 1920, height: 1080, dpr: 2, lang: 'es', reduced: true },
      { width: 412, height: 823, dpr: 1.75, lang: 'en', noJS: true },
    ]) {
      const context = await browser.newContext({ viewport: { width: spec.width, height: spec.height },
        deviceScaleFactor: spec.dpr, locale: spec.lang, javaScriptEnabled: !spec.noJS,
        reducedMotion: spec.reduced ? 'reduce' : 'no-preference' });
      await context.addCookies([{ name: 'site_language', value: spec.lang, url: base }]);
      // Test application behavior deterministically without sending form data or analytics.
      await context.route('**/*', route => route.request().url().startsWith(base)
        ? route.continue() : route.fulfill({ status: 200, contentType: 'application/javascript', body: '' }));
      const page = await context.newPage();
      const requests = [], errors = [];
      page.on('request', request => requests.push(request.url()));
      page.on('pageerror', error => errors.push(error.message));
      const path = spec.lang === 'en' ? '/en' : '/';
      assert.equal((await page.goto(base + path)).status(), 200);
      await page.waitForTimeout(800);
      assert.equal(await page.locator('html').getAttribute('lang'), spec.lang);
      assert.equal(await page.locator('h1').isVisible(), true);
      const hero = await page.locator('img[src*="bo-computer"]').first().evaluate(image => ({
        src: image.currentSrc, width: image.getBoundingClientRect().width,
        height: image.getBoundingClientRect().height, naturalWidth: image.naturalWidth,
      }));
      assert.ok(hero.width > 0 && hero.naturalWidth > 0);
      const heroRequests = requests.filter(url => /bo-computer.*\.(avif|webp)/.test(url));
      assert.equal(heroRequests.length, 1, `duplicate hero download: ${heroRequests}`);
      const fonts = requests.filter(url => /\/fonts\//.test(url)).map(url => new URL(url).pathname);
      assert.equal(fonts.length, new Set(fonts).size, 'duplicate fonts');
      assert.ok(requests.some(url => url.includes('/icons-ui.svg')));
      assert.equal(requests.some(url => /\/icons\.svg(?:\?|$)/.test(url)), false, 'homepage fetched service sprite');
      assert.equal(await page.locator('link[rel="preload"][as="font"]').count(), 0);
      const background = await page.locator('img.background').first().evaluate(image => {
        if (!image.naturalWidth) throw new Error('Background SVG failed to decode');
        return image.currentSrc;
      });
      assert.equal(background.includes('-still.svg'), spec.width < 1088 || !!spec.reduced);
      if (!spec.noJS) {
        for (const url of requests.filter(url => url.includes('/public/assets/js/'))) {
          assert.ok(new URL(url).searchParams.has('v'), `unversioned module: ${url}`);
        }
        if (spec.width < 1088) {
          await page.locator('#mobile-menu-button').click();
          assert.equal(await page.locator('#mobile-menu').evaluate(el => el.classList.contains('-translate-y-full')), false);
          await page.locator('#close-mobile-button').click();
          assert.equal(await page.locator('#mobile-menu').evaluate(el => el.classList.contains('-translate-y-full')), true);
        }
      }
      await page.waitForTimeout(600);
      await page.screenshot({ path: `${output}/home-${spec.lang}-${spec.width}${spec.noJS ? '-nojs' : ''}.png` });
      assert.deepEqual(errors, []);
      results.push({ ...spec, hero, heroRequests, background, errors });
      await context.close();
    }

    const context = await browser.newContext({ locale: 'en-US' });
    await context.addCookies([{ name: 'site_language', value: 'en', url: base }]);
    await context.route('**/*', route => route.request().url().startsWith(base)
      ? route.continue() : route.fulfill({ status: 200, contentType: 'application/javascript', body: '' }));
    const page = await context.newPage();
    const sprite = fs.readFileSync('public/assets/icons.svg', 'utf8');
    const symbols = new Set([...sprite.matchAll(/\bid="([^"]+)"/g)].map(match => match[1]));
    const uiSymbols = new Set([...fs.readFileSync('public/assets/icons-ui.svg', 'utf8').matchAll(/\bid="([^"]+)"/g)].map(match => match[1]));
    const services = JSON.parse(execFileSync('php', ['-r', 'require "vendor/autoload.php"; require "src/helpers.php"; $s=require "config/services.php"; echo json_encode(array_values(array_map(fn($x)=>["en"=>$x["en"]["slug"],"es"=>$x["es"]["slug"]],array_filter($s,fn($x)=>($x["isActive"]??false)))));'], { encoding: 'utf8' }));
    for (const language of ['en', 'es']) {
      await context.addCookies([{ name: 'site_language', value: language, url: base }]);
      const prefix = language === 'en' ? '/en' : '';
      for (const slug of ['', 'alter', 'blog', ...services.map(service => service[language])]) {
      const response = await context.request.get(base + prefix + (slug ? '/' + slug : '/'));
      assert.equal(response.status(), 200, slug);
      const html = await response.text();
      for (const match of html.matchAll(/<use[^>]*href="([^"]*)#([^"]+)"/g)) {
        const available = match[1].includes('icons-ui.svg') ? uiSymbols : symbols;
        assert.ok(available.has(match[2]), `${slug}: missing symbol ${match[2]}`);
      }
      if (!['', 'alter'].includes(slug)) assert.ok(!html.includes('imagesrcset='), `${slug}: unexpected hero preload`);
      }
    }
    await context.addCookies([{ name: 'site_language', value: 'en', url: base }]);
    for (const path of ['/en/mlm-software', '/en/blockchain', '/en/blog', '/en/alter']) {
      assert.equal((await page.goto(base + path)).status(), 200);
      await page.waitForTimeout(500);
      if (path.endsWith('mlm-software')) {
        const next = page.locator('#serv-next');
        await next.click();
        assert.equal(await page.locator('#serv-prev').isDisabled(), false);
      }
      if (path.endsWith('/blog')) {
        const article = await page.locator('a[href*="/en/blog/"]').first().getAttribute('href');
        assert.ok(article);
        assert.equal((await page.goto(new URL(article, base).href)).status(), 200);
        assert.equal(await page.locator('h1').isVisible(), true);
      }
      if (path.endsWith('/alter')) {
        await page.locator('[data-target="demo-popup"].open-popup').first().click();
        assert.equal(await page.locator('#demo-popup').evaluate(el => el.open), true);
        await page.locator('#demo-popup .close-popup').click();
        assert.equal(await page.locator('#demo-popup').evaluate(el => el.open), false);
      }
    }
    await context.close();
    const staticContext = await browser.newContext({ javaScriptEnabled: false, locale: 'en-US' });
    await staticContext.addCookies([{ name: 'site_language', value: 'en', url: base }]);
    const staticPage = await staticContext.newPage();
    await staticPage.goto(base + '/en/blockchain');
    for (const selector of ['h1', '.ip-benefit']) {
      assert.equal(await staticPage.locator(selector).first().evaluate(el => getComputedStyle(el).opacity), '1');
    }
    await staticContext.close();
    for (const [locale, path, expected] of [
      ['es-CO', '/', 'es'], ['en-US', '/', 'en'], ['fr-FR', '/mlm-software', 'en'],
    ]) {
      const languageContext = await browser.newContext({ locale, javaScriptEnabled: false });
      const languagePage = await languageContext.newPage();
      await languagePage.goto(base + path);
      assert.equal(await languagePage.locator('html').getAttribute('lang'), expected);
      await languageContext.close();
    }
    fs.writeFileSync(`${output}/results.json`, JSON.stringify({ results, servicesChecked: services.length }, null, 2));
    console.log(`Browser checks passed: ${results.length} hero configurations, ${services.length} service routes, blog and demo dialog.`);
  } finally {
    await browser.close();
  }
})().catch(error => { console.error(error); process.exitCode = 1; });
