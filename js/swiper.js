const EXIT_DURATION = 400;
let isAnimating = false;

const horzSwiper = new Swiper(".horz-swiper", {
  speed: 300,
  loop: true,
  effect: "fade",
  fadeEffect: {
    crossFade: true,
  },
  allowTouchMove: false,
  pagination: {
    el: ".horz-pagination",
  },
  on: {
    init: function () {
      const activeSlide = this.slides[this.activeIndex];
      if (activeSlide) {
        activeSlide.querySelectorAll(".letter-anim").forEach((el) => {
          el.classList.add("letter-visible");
        });
      }
    },
    slideChangeTransitionEnd: function () {
      this.slides.forEach((slide) => {
        slide.querySelectorAll(".letter-anim").forEach((el) => {
          el.classList.remove("letter-exit", "letter-visible");
        });
      });
      const activeSlide = this.slides[this.activeIndex];
      if (activeSlide) {
        activeSlide.querySelectorAll(".letter-anim").forEach((el) => {
          el.classList.add("letter-visible");
        });
      }
      isAnimating = false;
    },
  },
});

function animatedSlideChange(action) {
  if (isAnimating) return;
  isAnimating = true;

  const currentSlide = horzSwiper.slides[horzSwiper.activeIndex];
  if (currentSlide) {
    currentSlide.querySelectorAll(".letter-anim").forEach((el) => {
      el.classList.remove("letter-visible");
      el.classList.add("letter-exit");
    });
  }

  setTimeout(action, EXIT_DURATION);
}

// Navigation buttons
document.querySelector(".horz-next")?.addEventListener("click", () => {
  animatedSlideChange(() => horzSwiper.slideNext());
});

document.querySelector(".horz-prev")?.addEventListener("click", () => {
  animatedSlideChange(() => horzSwiper.slidePrev());
});

// Pagination bullets
document.querySelector(".horz-pagination")?.addEventListener("click", (e) => {
  const bullet = e.target.closest(".swiper-pagination-bullet");
  if (!bullet) return;
  const bullets = [
    ...document.querySelectorAll(".horz-pagination .swiper-pagination-bullet"),
  ];
  const index = bullets.indexOf(bullet);
  if (index === -1 || index === horzSwiper.realIndex) return;
  animatedSlideChange(() => horzSwiper.slideToLoop(index));
});
