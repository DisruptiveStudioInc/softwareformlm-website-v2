const config = window.sfmlmTracking;

if (config) {
  window.dataLayer = window.dataLayer || [];
  window.gtag = window.gtag || function gtag() {
    window.dataLayer.push(arguments);
  };

  const loaded = new Set();
  const loadScript = (src) => {
    if (loaded.has(src) || document.querySelector(`script[src="${src}"]`)) {
      return Promise.resolve();
    }
    loaded.add(src);
    return new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.async = true;
      script.src = src;
      script.onload = resolve;
      script.onerror = reject;
      document.head.appendChild(script);
    });
  };

  const loadGtm = () => {
    if (loaded.has('gtm')) return;
    loaded.add('gtm');
    window.dataLayer.push({ 'gtm.start': Date.now(), event: 'gtm.js' });
    loadScript(`https://www.googletagmanager.com/gtm.js?id=${encodeURIComponent(config.gtmId)}`);
  };

  const loadMarketing = () => {
    if (loaded.has('marketing')) return;
    loaded.add('marketing');

    const hasScriptFrom = (origin) =>
      Boolean(document.querySelector(`script[src*="${origin}"]`));

    if (!hasScriptFrom('connect.facebook.net')) {
      window.fbq = window.fbq || function fbq() {
        (window.fbq.queue = window.fbq.queue || []).push(arguments);
      };
      window.fbq('init', config.metaPixelId);
      window.fbq('track', 'PageView');
      loadScript('https://connect.facebook.net/en_US/fbevents.js');
    }

    if (!hasScriptFrom('clarity.ms')) {
      window.clarity = window.clarity || function clarity() {
        (window.clarity.q = window.clarity.q || []).push(arguments);
      };
      loadScript(`https://www.clarity.ms/tag/${config.clarityId}`);
    }

    if (!hasScriptFrom('tracker.metricool.com')) {
      loadScript('https://tracker.metricool.com/resources/be.js')
        .then(() => window.beTracker?.t({ hash: config.metricoolId }))
        .catch(() => {});
    }
  };

  const beginMarketingAfterIntent = () => {
    ['pointerdown', 'keydown', 'touchstart'].forEach((name) => {
      window.addEventListener(name, loadMarketing, { once: true, passive: true });
    });
    window.setTimeout(loadMarketing, 30000);
  };

  const loadChat = () => {
    const language = document.documentElement.lang.toLowerCase().split('-')[0];

    if (language !== 'en' || !config.chatWidgetId || loaded.has('chat')) {
      return Promise.resolve();
    }

    const existingScript = document.querySelector(
      'script[src="https://widgets.leadconnectorhq.com/loader.js"]',
    );

    if (existingScript) {
      loaded.add('chat');
      return Promise.resolve();
    }

    loaded.add('chat');

    return new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.async = true;
      script.src = 'https://widgets.leadconnectorhq.com/loader.js';
      script.dataset.resourcesUrl =
        'https://widgets.leadconnectorhq.com/chat-widget/loader.js';
      script.dataset.widgetId = config.chatWidgetId;
      script.onload = resolve;
      script.onerror = () => {
        loaded.delete('chat');
        reject(new Error('LeadConnector chat failed to load'));
      };
      document.head.appendChild(script);
    });
  };

  const scheduleChat = () => {
    let started = false;
    const initializeChat = () => {
      if (started) return;
      started = true;
      window.clearTimeout(hardDeadline);
      loadChat().catch(() => {});
    };

    // Chat is a sales-critical feature. Begin during the first idle slot, but
    // never postpone the request beyond one second after this module executes.
    const hardDeadline = window.setTimeout(initializeChat, 1000);
    if ('requestIdleCallback' in window) {
      window.requestIdleCallback(initializeChat, { timeout: 750 });
    }
  };

  const initializeAfterLoad = () => {
    if (loaded.has('post-load')) return;
    loaded.add('post-load');
    loadGtm();
    beginMarketingAfterIntent();
  };

  // Do not couple chat availability to the marketing timeout or window load.
  scheduleChat();

  if (document.readyState === 'complete') {
    initializeAfterLoad();
  } else {
    window.addEventListener('load', initializeAfterLoad, { once: true });
  }
}
