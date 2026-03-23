import Swiper from "https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.mjs";
import DepthSlider from "./depthSlider.js";

const heroSwiper = new Swiper("#hero-swiper", {
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

const techSwiper = new Swiper("#tech-swiper", {
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

const subcategoriesSwiper = new Swiper("#subcategories-swiper", {
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

const ipsSwiper = new Swiper("#ips-swiper", {
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
  speed: 9000,
  spaceBetween: 40,
  autoHeight: false,
  slidesPerView: 2,
  loop: true,
  initialSlide: 6,
  lazyPreloadPrevNext: 4,
  loopAdditionalSlides: 6,
  freemode: {
    enabled: true,
    momentum: false,
  },
  breakpoints: {
    640: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 4,
    },
  },
};
const clients1Swiper = new Swiper(".clients-swiper", {
  ...clientsSliderOps,
  autoplay: {
    delay: 0,
    disableOnInteraction: false,
    pauseOnMouseEnter: false,
    reverseDirection: false,
  },
});

const officesThubsSwiper = new Swiper("#offices-thumbs-swiper", {
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
const officesSwiper = new Swiper("#offices-swiper", {
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
    swiper: officesThubsSwiper,
  },
});

const swiperServices = new Swiper(".swiper-tt", {
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
    renderBullet: function (index, className) {
      return `<li tabindex="0" role="button" aria-label="Got to slide ${
        index + 1
      }" class="h-3 w-4 xs:w-8 transition-colors ${className}"></li>`;
    },
  },
});

const servicesFirstButton = document.getElementById("serv-int-button");
if (swiperServices && servicesFirstButton) {
  servicesFirstButton.addEventListener("click", () => {
    swiperServices.slideNext();
  });
}

const mySwiper = new Swiper(".my-swiper", {
  effect: "cards",
  grabCursor: true,
  pagination: {
    el: "#my-swiper-pagination",
    clickable: true,
    bulletClass: "flex-center",
    bulletActiveClass: "active",
    renderBullet: function (index, className) {
      return `<li tabindex="0" role="button" aria-label="Go to process ${
        index + 1
      }" class="size-9 lg:size-12 text-lg lg:text-xl font-bold text-white leading-none rounded-full bg-brand-100 hover:bg-brand-200 active:bg-brand-200 [&.active]:bg-brand-200 [&.active]:ring-2 [&.active]:ring-white transition-colors cursor-pointer ${className}">${
        index + 1
      }</li>`;
    },
  },
});

const faqSliderEl = document.getElementById("faq-slider");
if (faqSliderEl) {
  const faqSlider = new DepthSlider("#faq-slider");
}
