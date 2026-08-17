const { gsap, ScrollTrigger } = window;

if (!gsap || !ScrollTrigger) {
  window.sfmlmAnimations = {};
} else {
  gsap.registerPlugin(ScrollTrigger);
  const desktop = window.matchMedia('(min-width: 1088px)').matches;
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (desktop && !reducedMotion) {
    const reveal = (selector, vars = {}) => {
      const elements = gsap.utils.toArray(selector);
      if (!elements.length) return;
      gsap.set(elements, { willChange: 'transform,opacity' });
      ScrollTrigger.batch(elements, {
        start: 'top 82%',
        once: true,
        onEnter: (batch) => gsap.fromTo(batch,
          { autoAlpha: 0, y: 28 },
          { autoAlpha: 1, y: 0, duration: 0.55, ease: 'power2.out', stagger: 0.08, clearProps: 'willChange', ...vars },
        ),
      });
    };

    reveal('.slide-up, .slide-up-delay, .slide-up-words, .slide-up-words-black, .slide-up-words-white, .slide-up-words-white-scroll');

    gsap.utils.toArray('.stagger-parent').forEach((container) => {
      const elements = container.querySelectorAll('.slide-up-stagger, .opacity-stagger');
      if (!elements.length) return;
      gsap.set(elements, { willChange: 'transform,opacity' });
      ScrollTrigger.create({
        trigger: container,
        start: 'top 82%',
        once: true,
        onEnter: () => gsap.fromTo(elements,
          { autoAlpha: 0, y: 24 },
          { autoAlpha: 1, y: 0, duration: 0.5, ease: 'power2.out', stagger: 0.1, clearProps: 'willChange' },
        ),
      });
    });

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

    reveal('.ip-benefit');
  }

  window.sfmlmAnimations = {};
}
