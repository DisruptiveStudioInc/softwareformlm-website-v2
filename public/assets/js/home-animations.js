const animationSelectors = [
  ".slide-up",
  ".slide-up-delay",
  ".slide-up-stagger",
  ".slide-up-words",
  ".slide-up-words-black",
  ".slide-up-words-white",
  ".slide-up-words-white-scroll",
  ".tech-section",
  ".ip-benefit",
];

const hasAnimationMarkup = animationSelectors.some((selector) =>
  document.querySelector(selector),
);

const isDesktop = window.matchMedia("(min-width: 1088px)").matches;
const prefersReducedMotion = window.matchMedia(
  "(prefers-reduced-motion: reduce)",
).matches;

if (!hasAnimationMarkup) {
  // No-op
} else if (!isDesktop || prefersReducedMotion) {
  restoreStaticMobilePresentation();
} else {
  loadAnimationDependencies()
    .then(() => import("./animations.js"))
    .catch((error) => {
      console.error("Animation initialization failed", error);
    });
}

function restoreStaticMobilePresentation() {
  document
    .querySelectorAll(".animate-fadein, .animate-slideup")
    .forEach((el) => {
      el.style.animation = "none";
      el.style.opacity = "1";
      el.style.transform = "none";
      el.style.translate = "0 0";
    });

  document.querySelectorAll(".animate-cycle").forEach((el) => {
    el.style.animation = "none";
    el.style.display = "none";
  });

  document.querySelectorAll(".ip-benefit").forEach((el) => {
    el.style.opacity = "1";
  });

  // document
  //   .querySelectorAll(".bg-text-white, .bg-text-black")
  //   .forEach((el) => {
  //     el.style.animation = "none";
  //   });
}

function loadScript(src) {
  if (document.querySelector(`script[src="${src}"]`)) {
    return Promise.resolve();
  }

  return new Promise((resolve, reject) => {
    const script = document.createElement("script");
    script.src = src;
    script.async = true;
    script.onload = () => resolve();
    script.onerror = () => reject(new Error(`Failed to load ${src}`));
    document.head.appendChild(script);
  });
}

async function loadAnimationDependencies() {
  await Promise.all([
    loadScript("/public/assets/vendor/gsap/gsap.min.js"),
    loadScript("/public/assets/vendor/gsap/ScrollTrigger.min.js"),
  ]);
}
