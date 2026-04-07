const { gsap, ScrollTrigger, SplitText } = window;

if (!gsap || !ScrollTrigger) {
  window.sfmlmAnimations = {};
} else {
  const prefersReducedMotion = window.matchMedia(
    "(prefers-reduced-motion: reduce)",
  ).matches;
  const isDesktop = window.matchMedia("(min-width: 1088px)").matches;
  const canRunRevealAnimations = isDesktop && !prefersReducedMotion;

  if (SplitText) {
    gsap.registerPlugin(ScrollTrigger, SplitText);
  } else {
    gsap.registerPlugin(ScrollTrigger);
  }

  const playReverse = "play none none reverse";

  const revealElements = (selector, getOptions = () => ({})) => {
    if (!canRunRevealAnimations) {
      return;
    }

    gsap.utils.toArray(selector).forEach((element) => {
      gsap.from(element, {
        scrollTrigger: {
          trigger: element,
          start: "top 80%",
          toggleActions: playReverse,
        },
        opacity: 0,
        y: 30,
        ...getOptions(element),
      });
    });
  };

  revealElements(".slide-up");
  revealElements(".slide-up-delay", (element) => ({
    delay: Number(element.dataset.delay || 0),
  }));

  if (canRunRevealAnimations) {
    gsap.utils.toArray(".stagger-parent").forEach((container) => {
      const slideElements = container.querySelectorAll(".slide-up-stagger");
      if (slideElements.length > 0) {
        gsap.from(slideElements, {
          scrollTrigger: {
            trigger: container,
            start: "top 80%",
            toggleActions: playReverse,
          },
          opacity: 0,
          y: 30,
          stagger: 0.2,
        });
      }

      const opacityElements = container.querySelectorAll(".opacity-stagger");
      if (opacityElements.length > 0) {
        gsap.from(opacityElements, {
          scrollTrigger: {
            trigger: container,
            start: "top 80%",
            toggleActions: playReverse,
          },
          opacity: 0,
          stagger: 0.2,
        });
      }
    });
  }

  const textAnimationConfigs = [
    {
      selector: ".slide-up-words",
      wordsClass: "",
      createTween: (element, words) =>
        gsap.from(words, {
          yPercent: 20,
          autoAlpha: 0,
          stagger: 0.3,
          scrollTrigger: {
            trigger: element,
            start: "top 80%",
            toggleActions: playReverse,
          },
        }),
    },
    {
      selector: ".slide-up-words-black",
      wordsClass: "bg-clip-text bg-text-black pt-2",
      createTween: (element, words) =>
        gsap.from(words, {
          yPercent: 20,
          autoAlpha: 0,
          stagger: 0.2,
          scrollTrigger: {
            trigger: element,
            start: "top 80%",
            toggleActions: playReverse,
          },
        }),
    },
    {
      selector: ".slide-up-words-white",
      wordsClass: "bg-clip-text bg-text-white pt-2 word++",
      createTween: (element, words) =>
        gsap.from(words, {
          yPercent: 20,
          autoAlpha: 0,
          stagger: 0.2,
          scrollTrigger: {
            trigger: element,
            start: "top 80%",
            toggleActions: playReverse,
          },
        }),
    },
    {
      selector: ".slide-up-words-white-scroll",
      wordsClass: "bg-clip-text bg-text-white pt-2 word++",
      createTween: (element, words) =>
        gsap.from(words, {
          yPercent: 20,
          autoAlpha: 0,
          stagger: 0.3,
          scrollTrigger: {
            trigger: element,
            start: "top 80%",
            end: "top 50%",
            scrub: true,
            toggleActions: playReverse,
          },
        }),
    },
  ];

  if (canRunRevealAnimations && SplitText && document.fonts?.ready) {
    document.fonts.ready.then(() => {
      textAnimationConfigs.forEach((config) => {
        if (!document.querySelector(config.selector)) {
          return;
        }

        gsap.utils.toArray(config.selector).forEach((element) => {
          SplitText.create(element, {
            type: "words",
            autoSplit: true,
            smartWrap: true,
            wordsClass: config.wordsClass,
            onSplit: (self) => config.createTween(element, self.words),
          });
        });
      });
    });
  }

  const techSection = document.querySelector(".tech-section");
  const techTitle = document.querySelector(".tech-title");
  const techCards = document.querySelectorAll(".tech-card");

  if (canRunRevealAnimations && techSection && techTitle && techCards.length > 0) {
    const techTimeline = gsap.timeline({
      scrollTrigger: {
        trigger: techSection,
        start: "top top",
        end: `+=${techCards.length * 100}%`,
        pin: true,
        scrub: 1,
        anticipatePin: true,
      },
    });

    techCards.forEach((card, index) => {
      gsap.set(card, {
        y: "70vh",
        opacity: 0,
      });

      techTimeline.to(
        card,
        {
          y: "-140vh",
          duration: 3,
          ease: "none",
          onStart: () => {
            gsap.to(card, { opacity: 1, duration: 0.3 });
          },
          onUpdate() {
            const progress = this.progress();
            if (progress > 0.7) {
              gsap.set(card, { opacity: 1 - (progress - 0.7) / 0.3 });
            }
          },
        },
        index * 0.8,
      );
    });
  }

  const ipBenefits = document.querySelectorAll(".ip-benefit");
  if (canRunRevealAnimations && ipBenefits.length > 0) {
    ipBenefits.forEach((element) => {
      gsap.fromTo(
        element,
        { opacity: 0 },
        {
          opacity: 1,
          immediateRender: false,
          scrollTrigger: {
            trigger: element,
            start: "top 60%",
            end: "top 40%",
            scrub: true,
          },
        },
      );

      gsap.fromTo(
        element,
        { opacity: 1 },
        {
          opacity: 0,
          immediateRender: false,
          scrollTrigger: {
            trigger: element,
            start: "top 20%",
            end: "top 0%",
            scrub: true,
          },
        },
      );
    });
  }

  window.sfmlmAnimations = {};
}
