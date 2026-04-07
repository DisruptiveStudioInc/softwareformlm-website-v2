  <script>
  (function(window, document) {
    const config = {
      gtagId: 'G-6K7G73DG2Y',
      gtmId: 'GTM-WNG6M4TX',
      metaPixelId: '2091918928324101'
    };

    let hasLoadedTracking = false;

    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function(){ window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', config.gtagId);

    if (!window.fbq) {
      const fbq = function() {
        fbq.callMethod ? fbq.callMethod.apply(fbq, arguments) : fbq.queue.push(arguments);
      };

      fbq.push = fbq;
      fbq.loaded = true;
      fbq.version = '2.0';
      fbq.queue = [];
      window.fbq = fbq;
      window._fbq = fbq;
    }

    window.fbq('init', config.metaPixelId);
    window.fbq('track', 'PageView');

    const loadScript = (src) => {
      if (document.querySelector(`script[src="${src}"]`)) {
        return;
      }

      const script = document.createElement('script');
      script.async = true;
      script.src = src;
      document.head.appendChild(script);
    };

    const loadTracking = () => {
      if (hasLoadedTracking) {
        return;
      }

      hasLoadedTracking = true;
      removeListeners();

      window.dataLayer.push({
        'gtm.start': Date.now(),
        event: 'gtm.js'
      });

      loadScript(`https://www.googletagmanager.com/gtag/js?id=${config.gtagId}`);
      loadScript(`https://www.googletagmanager.com/gtm.js?id=${config.gtmId}`);
      loadScript('https://connect.facebook.net/en_US/fbevents.js');

      window.setTimeout(() => {
        if (typeof window.clarity === 'function') {
          return;
        }

        window.clarity = function() {
          (window.clarity.q = window.clarity.q || []).push(arguments);
        };

        loadScript('https://www.clarity.ms/tag/w4g6vx93c3');
      }, 4000);
    };

    const events = ['pointerdown', 'touchstart', 'keydown', 'scroll'];

    const removeListeners = () => {
      events.forEach((eventName) => {
        window.removeEventListener(eventName, loadTracking, listenerOptions);
      });
    };

    const listenerOptions = { passive: true, once: true };

    events.forEach((eventName) => {
      window.addEventListener(eventName, loadTracking, listenerOptions);
    });

    if ('requestIdleCallback' in window) {
      window.requestIdleCallback(loadTracking, { timeout: 3000 });
    } else {
      window.setTimeout(loadTracking, 3000);
    }
  })(window, document);
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=2091918928324101&ev=PageView&noscript=1"
  /></noscript>
