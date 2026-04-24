import DepthSlider from "./depthSlider.js";

const sliderSelectors = [
  "#hero-swiper",
  "#tech-swiper",
  "#subcategories-swiper",
  "#ips-swiper",
  ".clients-odd-swiper",
  ".clients-even-swiper",
  "#offices-thumbs-swiper",
  "#offices-swiper",
  ".swiper-tt",
  ".my-swiper",
  "#faq-slider",
];

const hasSliderMarkup = sliderSelectors.some((selector) =>
  document.querySelector(selector),
);

if (hasSliderMarkup) {
  initSliders().catch((error) => {
    console.error("Slider initialization failed", error);
  });
}

async function initSliders() {
  const { default: Swiper } =
    await import("https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.mjs");

  const createSwiper = (selector, options) => {
    const element = document.querySelector(selector);
    if (!element) {
      return null;
    }

    return new Swiper(selector, options);
  };

  createSwiper("#hero-swiper", {
    speed: 800,
    spaceBetween: 10,
    slidesPerView: "auto",
    centeredSlides: true,
    loopAdditionalSlides: true,
    loop: true,
    initialSlide: 4,
    autoplay: {
      delay: 1200,
    },
  });

  createSwiper("#tech-swiper", {
    speed: 1000,
    spaceBetween: 20,
    autoHeight: false,
    slidesPerView: 1,
    centeredSlides: true,
    loopAdditionalSlides: true,
    loop: true,
    autoplay: true,
    initialSlide: 3,
  });

  createSwiper("#subcategories-swiper", {
    speed: 1000,
    spaceBetween: 20,
    autoHeight: false,
    slidesPerView: 1,
    centeredSlides: true,
    navigation: {
      nextEl: ".subcategories-button-next",
      prevEl: ".subcategories-button-prev",
    },
  });

  createSwiper("#ips-swiper", {
    speed: 1000,
    spaceBetween: 20,
    autoHeight: false,
    slidesPerView: 1,
    loopAdditionalSlides: true,
    loop: true,
    autoplay: true,
    pagination: {
      el: ".ips-pagination",
      type: "bullets",
      dynamicBullets: true,
    },
  });

  const clientsSliderOps = {
    speed: 7000,
    spaceBetween: 20,
    autoHeight: false,
    slidesPerView: 2,
    loop: true,
    initialSlide: 6,
    lazyPreloadPrevNext: 4,
    loopAdditionalSlides: 8,
    allowTouchMove: false,
    simulateTouch: false,
    centeredSlides: false,
    watchOverflow: false,
    breakpoints: {
      640: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 5,
      },
      1088: {
        slidesPerView: 10,
      },
    },
  };

  const clientsSection = document.querySelector('[data-nav-index="7"]');
  const clientRows = [
    {
      selector: "#clients1-swiper",
      autoplay: {
        delay: 1,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
        reverseDirection: false,
        waitForTransition: true,
      },
    },
    {
      selector: "#clients2-swiper",
      autoplay: {
        delay: 1,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
        reverseDirection: true,
        waitForTransition: true,
      },
    },
    {
      selector: "#clients3-swiper",
      autoplay: {
        delay: 1,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
        reverseDirection: false,
        waitForTransition: true,
      },
    },
    {
      selector: "#clients4-swiper",
      autoplay: {
        delay: 1,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
        reverseDirection: true,
        waitForTransition: true,
      },
    },
  ];

  const clientSwipers = [];
  let clientsInitialized = false;

  const attachClientSwiperWatchdog = (swiper) => {
    let lastTranslate = null;
    let stalledChecks = 0;

    const isVisible = () => {
      const rect = swiper.el.getBoundingClientRect();

      return rect.bottom > 0 && rect.top < window.innerHeight;
    };

    const restart = () => {
      swiper.update();
      swiper.slideToLoop(swiper.realIndex, 0, false);

      if (swiper.autoplay?.running) {
        swiper.autoplay.stop();
      }

      swiper.autoplay?.start();
      lastTranslate = Math.round(swiper.translate);
      stalledChecks = 0;
    };

    const ensureRunning = () => {
      if (document.hidden || !isVisible()) {
        return;
      }

      if (!swiper.autoplay?.running) {
        restart();
      }
    };

    swiper.on("autoplayStop", ensureRunning);
    swiper.on("resize", restart);
    swiper.on("observerUpdate", ensureRunning);

    window.addEventListener("resize", restart);
    document.addEventListener("visibilitychange", () => {
      if (!document.hidden) {
        restart();
      }
    });

    window.setInterval(() => {
      if (document.hidden || !isVisible()) {
        return;
      }

      const currentTranslate = Math.round(swiper.translate);

      if (lastTranslate === currentTranslate) {
        stalledChecks += 1;
      } else {
        lastTranslate = currentTranslate;
        stalledChecks = 0;
      }

      if (stalledChecks >= 2) {
        restart();
      }
    }, 2500);
  };

  const ensureClientSwipers = () => {
    if (clientsInitialized) {
      return;
    }

    clientRows.forEach((row) => {
      const swiperInstance = createSwiper(row.selector, {
        ...clientsSliderOps,
        autoplay: row.autoplay,
      });

      if (swiperInstance) {
        clientSwipers.push(swiperInstance);
        attachClientSwiperWatchdog(swiperInstance);
      }
    });

    clientsInitialized = true;
  };

  const syncClientSwipers = () => {
    clientSwipers.forEach((swiper) => {
      swiper.update();
      if (swiper.autoplay && !swiper.autoplay.running) {
        swiper.autoplay.start();
      }
    });
  };

  if (clientsSection) {
    const clientsObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) {
            return;
          }

          ensureClientSwipers();
          requestAnimationFrame(() => {
            syncClientSwipers();
          });
        });
      },
      {
        threshold: 0.15,
      },
    );

    clientsObserver.observe(clientsSection);
  } else {
    ensureClientSwipers();
    syncClientSwipers();
  }

  document.addEventListener("visibilitychange", () => {
    if (document.hidden || clientSwipers.length === 0) {
      return;
    }

    syncClientSwipers();
  });

  const officesThumbsElement = document.querySelector("#offices-thumbs-swiper");
  const officesElement = document.querySelector("#offices-swiper");

  if (officesThumbsElement && officesElement) {
    const officesThumbsSwiper = new Swiper("#offices-thumbs-swiper", {
      slidesPerView: 2,
      spaceBetween: 20,
      freeMode: true,
      watchSlidesProgress: true,
      breakpoints: {
        530: {
          slidesPerView: 3,
        },
      },
    });

    new Swiper("#offices-swiper", {
      slidesPerView: 1,
      speed: 800,
      effect: "fade",
      loop: true,
      autoplay: {
        delay: 6000,
        disableOnInteraction: false,
        pauseOnMouseEnter: false,
      },
      thumbs: {
        swiper: officesThumbsSwiper,
      },
    });
  }

  const servicesSwiper = createSwiper(".swiper-tt", {
    direction: "vertical",
    effect: "fade",
    speed: 500,
    spaceBetween: 0,
    breakpoints: {
      1088: {
        direction: "horizontal",
        allowTouchMove: false,
      },
    },
    navigation: {
      nextEl: "#serv-next",
      prevEl: "#serv-prev",
    },
    pagination: {
      el: "#serv-dots",
      clickable: true,
      bulletClass: "serv-dot",
      bulletActiveClass: "bg-brand-100",
      renderBullet(index, className) {
        return `<li tabindex="0" role="button" aria-label="Got to slide ${
          index + 1
        }" class="h-3 w-4 xs:w-8 transition-colors ${className}"></li>`;
      },
    },
  });

  const servicesFirstButton = document.getElementById("serv-int-button");
  if (servicesSwiper && servicesFirstButton) {
    servicesFirstButton.addEventListener("click", () => {
      servicesSwiper.slideNext();
    });
  }

  createSwiper(".my-swiper", {
    effect: "cards",
    grabCursor: true,
    pagination: {
      el: "#my-swiper-pagination",
      clickable: true,
      bulletClass: "flex-center",
      bulletActiveClass: "active",
      renderBullet(index, className) {
        return `<li tabindex="0" role="button" aria-label="Go to process ${
          index + 1
        }" class="size-9 lg:size-12 text-lg lg:text-xl font-bold text-secondary-100 leading-none rounded-full bg-brand-100 hover:bg-brand-200 active:bg-brand-200 [&.active]:bg-secondary-200 [&.active]:text-white transition-colors cursor-pointer ${className}">${
          index + 1
        }</li>`;
      },
    },
  });

  if (document.getElementById("faq-slider")) {
    new DepthSlider("#faq-slider");
  }
}
