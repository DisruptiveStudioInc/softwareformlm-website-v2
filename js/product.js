/* ============================================== */
/* GSAP SCROLL ANIMATIONS (DESKTOP ONLY) */
/* ============================================== */

document.addEventListener("DOMContentLoaded", function () {
  gsap.registerPlugin(ScrollTrigger);

  gsap.matchMedia().add("(min-width: 1080px)", () => {
    // ========== INGREDIENTS (class toggle)
    document.querySelectorAll(".ingredients_wrap").forEach((wrap) => {
      const ingredientsElement = wrap.querySelector(".ingredients");
      if (ingredientsElement) {
        ScrollTrigger.create({
          trigger: wrap,
          start: "top 80%",
          end: "+=80%",
          toggleClass: { targets: ingredientsElement, className: "fade-in" },
        });
      }
    });

    // ========== IMG_MED (parallax image)
    gsap.fromTo(
      ".img_med img",
      { y: "-20%" },
      {
        y: "3%",
        scrollTrigger: {
          trigger: ".img_med",
          start: "top bottom",
          end: "+=150%",
          scrub: true,
        },
      },
    );
  });
});

/* ============================================== */
/* BANNER */
/* ============================================== */

document.addEventListener("DOMContentLoaded", () => {
  const slides = document.querySelectorAll(".banner li");
  let current = 0;
  let interval;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove("active", "fade-out");
      if (i === index) slide.classList.add("active");
    });
  }

  function nextSlide() {
    slides[current].classList.add("fade-out"); // Fade-out texto antes de salir
    setTimeout(() => {
      current = (current + 1) % slides.length;
      showSlide(current);
    }, 600);
  }

  function startSlider() {
    interval = setInterval(nextSlide, 4000); // cada 4s
  }

  function stopSlider() {
    clearInterval(interval);
  }

  // Inicialización
  showSlide(current);
  startSlider();

  // Detener al hacer hover
  const banner = document.querySelector(".banner");
  banner.addEventListener("mouseenter", stopSlider);
  banner.addEventListener("mouseleave", startSlider);
});

/* ============================================== */
/* TILT */
/* ============================================== */

const imgContainer = document.querySelector(".c-sub .h-100");
const img = document.querySelector(".c-sub .img-middle");

imgContainer.addEventListener("mousemove", (e) => {
  const rect = imgContainer.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;

  const centerX = rect.width / 2;
  const centerY = rect.height / 2;

  const deltaX = (x - centerX) / centerX; // -1 a 1
  const deltaY = (y - centerY) / centerY; // -1 a 1

  // inclinación
  const rotateX = deltaY * 15;
  const rotateY = deltaX * -15;

  img.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
});

imgContainer.addEventListener("mouseleave", () => {
  img.style.transform = "rotateX(0deg) rotateY(0deg) scale(1)";
});
