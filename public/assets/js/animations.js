const { gsap, ScrollTrigger, SplitText } = window;

if (!gsap || !ScrollTrigger) {
  window.sfmlmAnimations = {};
} else {
  if (SplitText) {
    gsap.registerPlugin(ScrollTrigger, SplitText);
  } else {
    gsap.registerPlugin(ScrollTrigger);
  }

  const desktop = window.matchMedia('(min-width: 1088px)').matches;
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (desktop && !reducedMotion) {
    const playReverse = 'play none none reverse';

    const revealElements = (selector, getOptions = () => ({})) => {
      gsap.utils.toArray(selector).forEach((element) => {
        gsap.from(element, {
          scrollTrigger: {
            trigger: element,
            start: 'top 80%',
            toggleActions: playReverse,
          },
          autoAlpha: 0,
          y: 30,
          duration: 0.8,
          ease: 'power2.out',
          ...getOptions(element),
        });
      });
    };

    revealElements('.slide-up');
    revealElements('.slide-up-delay', (element) => ({
      delay: Number(element.dataset.delay || 0),
    }));

    gsap.utils.toArray('.stagger-parent').forEach((container) => {
      const slideElements = container.querySelectorAll('.slide-up-stagger');
      const opacityElements = container.querySelectorAll('.opacity-stagger');

      if (slideElements.length) {
        gsap.from(slideElements, {
          scrollTrigger: {
            trigger: container,
            start: 'top 80%',
            toggleActions: playReverse,
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
            trigger: container,
            start: 'top 80%',
            toggleActions: playReverse,
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
        wordsClass: '',
        stagger: 0.3,
      },
      {
        selector: '.slide-up-words-black',
        wordsClass: 'bg-clip-text bg-text-black pt-2',
        stagger: 0.2,
      },
      {
        selector: '.slide-up-words-white',
        wordsClass: 'bg-clip-text bg-text-white pt-2 word++',
        stagger: 0.2,
      },
      {
        selector: '.slide-up-words-white-scroll',
        wordsClass: 'bg-clip-text bg-text-white pt-2 word++',
        stagger: 0.3,
        scrub: true,
      },
    ];

    if (SplitText) {
      const fontsReady = document.fonts?.ready ?? Promise.resolve();
      fontsReady.then(() => {
        textAnimationConfigs.forEach((config) => {
          gsap.utils.toArray(config.selector).forEach((element) => {
            SplitText.create(element, {
              type: 'words',
              autoSplit: true,
              smartWrap: true,
              wordsClass: config.wordsClass,
              onSplit: (self) => gsap.from(self.words, {
                yPercent: 20,
                autoAlpha: 0,
                duration: 0.8,
                ease: 'power2.out',
                stagger: config.stagger,
                scrollTrigger: {
                  trigger: element,
                  start: 'top 80%',
                  ...(config.scrub ? { end: 'top 50%', scrub: true } : { toggleActions: playReverse }),
                },
              }),
            });
          });
        });
        ScrollTrigger.refresh();
      });
    } else {
      revealElements(textAnimationConfigs.map(({ selector }) => selector).join(', '));
    }

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
        },
      });
      techCards.forEach((card, index) => {
        const position = index * 0.8;
        timeline.to(card, { autoAlpha: 1, duration: 0.12 }, position)
          .to(card, { y: '-140vh', autoAlpha: 0, duration: 2.6, ease: 'none' }, position);
      });
    }

    revealElements('.ip-benefit');
  }

  window.sfmlmAnimations = {};
}
