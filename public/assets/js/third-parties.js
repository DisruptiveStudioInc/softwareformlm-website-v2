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

    window.fbq = window.fbq || function fbq() {
      (window.fbq.queue = window.fbq.queue || []).push(arguments);
    };
    window.fbq('init', config.metaPixelId);
    window.fbq('track', 'PageView');
    loadScript('https://connect.facebook.net/en_US/fbevents.js');

    window.clarity = window.clarity || function clarity() {
      (window.clarity.q = window.clarity.q || []).push(arguments);
    };
    loadScript(`https://www.clarity.ms/tag/${config.clarityId}`);

    loadScript('https://tracker.metricool.com/resources/be.js')
      .then(() => window.beTracker?.t({ hash: config.metricoolId }))
      .catch(() => {});
  };

  const beginMarketingAfterIntent = () => {
    ['pointerdown', 'keydown', 'touchstart'].forEach((name) => {
      window.addEventListener(name, loadMarketing, { once: true, passive: true });
    });
    window.setTimeout(loadMarketing, 30000);
  };

  window.addEventListener('load', () => {
    loadGtm();
    beginMarketingAfterIntent();
  }, { once: true });

  document.querySelectorAll('[data-chat-launcher]').forEach((launcher) => {
    launcher.addEventListener('click', () => {
      if (loaded.has('chat')) return;
      loaded.add('chat');
      const script = document.createElement('script');
      script.async = true;
      script.src = 'https://widgets.leadconnectorhq.com/loader.js';
      script.dataset.resourcesUrl = 'https://widgets.leadconnectorhq.com/chat-widget/loader.js';
      script.dataset.widgetId = config.chatWidgetId;
      document.head.appendChild(script);
      launcher.setAttribute('aria-busy', 'true');
    });
  });
}
