const { test } = require('node:test');
const assert = require('node:assert/strict');
const vm = require('node:vm');
const fs = require('node:fs');

function harness(language = 'en', initialTime = 0) {
  let now = initialTime;
  let id = 0;
  const timers = new Map(), listeners = new Map(), scripts = [];
  const window = {
    sfmlmTracking: { gtmId: 'test', chatWidgetId: 'chat', metaPixelId: 'meta', metricoolId: 'metricool' },
    dataLayer: [{ event: 'queued-before-module' }],
    setTimeout(fn, delay) { timers.set(++id, { fn, at: now + delay }); return id; },
    clearTimeout(key) { timers.delete(key); },
    addEventListener(event, fn) { if (!listeners.has(event)) listeners.set(event, new Set()); listeners.get(event).add(fn); },
    removeEventListener(event, fn) { listeners.get(event)?.delete(fn); },
  };
  const document = {
    readyState: 'complete', documentElement: { lang: language },
    querySelector(selector) {
      const match = selector.match(/src(\*?)="([^"]+)"/);
      return scripts.find(s => match && (match[1] ? s.src.includes(match[2]) : s.src === match[2]));
    },
    createElement() { return { dataset: {} }; },
    head: { appendChild(script) { scripts.push(script); } },
  };
  vm.runInNewContext(fs.readFileSync('public/assets/js/third-parties.js', 'utf8'), { window, document, performance: { now: () => now } });
  return { window, scripts,
    event(name) { [...(listeners.get(name) || [])].forEach(fn => fn()); },
    advance(time) {
      while (true) {
        const next = [...timers].filter(([, t]) => t.at <= time).sort((a, b) => a[1].at - b[1].at)[0];
        if (!next) break;
        now = next[1].at; timers.delete(next[0]); next[1].fn();
      }
      now = time;
    },
  };
}

test('automatic English chat starts without waiting for GTM; GTM uses navigation deadline', () => {
  const h = harness('en', 800);
  h.advance(1800);
  assert.equal(h.scripts.length, 1);
  assert.match(h.scripts[0].src, /leadconnectorhq/);
  h.advance(4999);
  assert.equal(h.scripts.length, 1);
  h.advance(5000);
  assert.equal(h.scripts.filter(s => s.src.includes('gtm.js')).length, 1);
  assert.equal(h.window.dataLayer[0].event, 'queued-before-module');
});

test('intent and deadline cannot double-load GTM or marketing; Spanish has no chat', () => {
  const h = harness('es');
  h.event('pointerdown'); h.event('touchstart'); h.event('keydown');
  h.advance(31000);
  for (const pattern of ['gtm.js', 'fbevents.js', 'be.js']) {
    assert.equal(h.scripts.filter(s => s.src.includes(pattern)).length, 1);
  }
  assert.equal(h.scripts.some(s => s.src.includes('leadconnectorhq')), false);
  assert.equal(h.scripts.some(s => s.src.includes('clarity.ms')), false);
  assert.equal(h.window.dataLayer.filter(e => e.event === 'gtm.js').length, 1);
});

test('late module execution does not add another five-second wait', () => {
  const h = harness('en', 7000);
  h.advance(7000);
  assert.equal(h.scripts.filter(s => s.src.includes('gtm.js')).length, 1);
});
