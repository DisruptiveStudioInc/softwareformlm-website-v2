const { gsap, ScrollTrigger } = window;

const boot = window.sfmlmAnimationBoot;

if (!gsap || !ScrollTrigger || boot?.state === 'failed') {
  boot?.fail();
  window.sfmlmAnimations = {};
} else {
  // Reveal CSS defaults synchronously before from() captures its end values.
  // The same task installs hidden GSAP start states before the next paint.
  boot?.ready();
  gsap.registerPlugin(ScrollTrigger);

  const desktop = window.matchMedia('(min-width: 1088px)').matches;
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (desktop && !reducedMotion) {
    const playOnce = 'play none none none';

    const revealElements = (selector, getOptions = () => ({})) => {
      gsap.utils.toArray(selector).forEach((element) => {
        if (element.closest('[data-reveal-sequence]')) return;

        gsap.from(element, {
          scrollTrigger: {
            trigger: element,
            start: 'top 80%',
            toggleActions: playOnce,
            once: true,
          },
          autoAlpha: 0,
          y: 30,
          duration: 0.8,
          ease: 'power2.out',
          ...getOptions(element),
        });
      });
    };

    // Create the pin before any triggers below it so their start positions
    // include the extra scroll distance introduced by pinSpacing.
    const techSection = document.querySelector('.tech-section');
    const techCards = gsap.utils.toArray('.tech-card');
    if (techSection && techCards.length) {
      gsap.set(techCards, { y: '70vh', autoAlpha: 0 });
      const timeline = gsap.timeline({
        scrollTrigger: {
          trigger: techSection,
          start: 'top top',
          end: `+=${techCards.length * 90}%`,
          pin: true,
          scrub: 1,
          anticipatePin: true,
          invalidateOnRefresh: true,
        },
      });
      techCards.forEach((card, index) => {
        const position = index * 0.8;
        timeline
          .to(card, { autoAlpha: 1, duration: 0.12 }, position)
          .to(card, { y: '-115vh', duration: 2.2, ease: 'none' }, position)
          .to(card, { y: '-140vh', autoAlpha: 0, duration: 0.4, ease: 'none' }, position + 2.2);
      });
    }

    gsap.utils.toArray('[data-title-cta-sequence]').forEach((container) => {
      const words = container.querySelectorAll('.animated-word');
      const cta = container.querySelector('[data-title-cta-action]');
      if (!words.length || !cta) return;

      gsap.timeline({
        scrollTrigger: {
          trigger: container,
          start: 'top 80%',
          toggleActions: playOnce,
          once: true,
        },
      })
        .from(words, {
          yPercent: 20,
          autoAlpha: 0,
          duration: 0.8,
          ease: 'power2.out',
          stagger: 0.2,
        })
        .from(cta, {
          autoAlpha: 0,
          y: 30,
          duration: 0.8,
          ease: 'power2.out',
        });
    });

    gsap.utils.toArray('[data-reveal-sequence]').forEach((container) => {
      const words = container.querySelectorAll('.animated-word');
      const description = container.querySelector('[data-reveal-description]');
      const actions = container.querySelectorAll('[data-reveal-action]');
      const sequence = gsap.timeline({
        scrollTrigger: {
          trigger: container,
          start: 'top 80%',
          toggleActions: playOnce,
          once: true,
        },
      });

      if (words.length) {
        sequence.from(words, {
          yPercent: 20,
          autoAlpha: 0,
          duration: 0.65,
          ease: 'power2.out',
          stagger: 0.12,
        });
      }

      if (description) {
        sequence.from(description, {
          autoAlpha: 0,
          y: 30,
          duration: 0.65,
          ease: 'power2.out',
        });
      }

      if (actions.length) {
        sequence.from(actions, {
          autoAlpha: 0,
          y: 30,
          duration: 0.65,
          ease: 'power2.out',
          stagger: 0.15,
        });
      }
    });

    revealElements('.slide-up');
    revealElements('.slide-up-delay', (element) => ({
      delay: Number(element.dataset.delay || 0),
    }));

    gsap.utils.toArray('.stagger-parent').forEach((container) => {
      if (container.closest('[data-reveal-sequence]')) return;

      const slideElements = container.querySelectorAll('.slide-up-stagger');
      const opacityElements = container.querySelectorAll('.opacity-stagger');
      const trigger = container.dataset.revealTrigger === 'section'
        ? container.closest('.block-content') || container
        : container;

      if (slideElements.length) {
        gsap.from(slideElements, {
          scrollTrigger: {
            trigger,
            start: 'top 80%',
            toggleActions: playOnce,
            once: true,
          },
          autoAlpha: 0,
          y: 30,
          duration: 0.8,
          ease: 'power2.out',
          stagger: 0.2,
        });
      }

      if (opacityElements.length) {
        gsap.from(opacityElements, {
          scrollTrigger: {
            trigger,
            start: 'top 80%',
            toggleActions: playOnce,
            once: true,
          },
          autoAlpha: 0,
          duration: 0.8,
          ease: 'power2.out',
          stagger: 0.2,
        });
      }
    });

    const textAnimationConfigs = [
      {
        selector: '.slide-up-words',
        stagger: 0.3,
      },
      {
        selector: '.slide-up-words-black',
        stagger: 0.2,
      },
      {
        selector: '.slide-up-words-white',
        stagger: 0.2,
      },
      {
        selector: '.slide-up-words-white-scroll',
        stagger: 0.3,
        scrub: true,
      },
    ];

    textAnimationConfigs.forEach((config) => {
      gsap.utils.toArray(config.selector).forEach((element) => {
        if (element.closest('[data-reveal-sequence], [data-title-cta-sequence]')) return;

        const words = element.querySelectorAll('.animated-word');
        if (!words.length) return;

        gsap.from(words, {
          yPercent: 20,
          autoAlpha: 0,
          duration: 0.8,
          ease: 'power2.out',
          stagger: config.stagger,
          scrollTrigger: {
            trigger: element,
            start: 'top 80%',
            ...(config.scrub
              ? { end: 'top 50%', scrub: 1 }
              : { toggleActions: playOnce, once: true }),
          },
        });
      });
    });

    revealElements('.ip-benefit');

    document.fonts?.ready.then(() => ScrollTrigger.refresh());
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      gsap.globalTimeline.pause();
    } else {
      gsap.globalTimeline.resume();
    }
  });

  window.sfmlmAnimations = {};
}
