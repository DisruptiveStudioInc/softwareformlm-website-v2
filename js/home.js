/* ==============================================
    MODAL
============================================== */
// Función para abrir el modal
function openModal(modalId) {
  var modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.add("open"); // Muestra el modal
    document.body.classList.add("no-scroll"); // Bloquea el scroll
  }
}

// Función para cerrar el modal
function closeModal(modalId) {
  var modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove("open"); // Oculta el modal
    checkModalsOpen(); // Verifica si hay otros modales abiertos
  }
}

// Función para verificar si hay modales abiertos y desbloquear el scroll
function checkModalsOpen() {
  var openModals = document.querySelectorAll(".modal.open");
  if (openModals.length === 0) {
    document.body.classList.remove("no-scroll"); // Reactiva el scroll
  }
}

// Función para cerrar el modal si se hace clic fuera de él
window.onclick = function (event) {
  var modals = document.querySelectorAll(".modal");
  modals.forEach(function (modal) {
    if (event.target === modal) {
      closeModal(modal.id);
    }
  });
};

document.addEventListener("DOMContentLoaded", function () {
  /* ==============================================
       GSAP SCROLL ANIMATIONS (DESKTOP ONLY)
    ============================================== */
  gsap.registerPlugin(ScrollTrigger);

  gsap.matchMedia().add("(min-width: 1080px)", () => {
    const animationSpeed = 0.75;
    const animationLinear = "power3.inOut";
    const animationIn = "expo.in";
    const animationInOut = "expo.inOut";

    // ========== HERO (pin + text fade-in)
    // NOTE: Created before Gallery so ScrollTrigger calculates pin spacing in DOM order
    // gsap.fromTo(
    //   ".hero-text",
    //   { opacity: 0 },
    //   { opacity: 1, duration: animationSpeed },
    // );

    // ========== PARALLAX (boxes fly in)
    // const parallaxTimeline = gsap.timeline({
    //   scrollTrigger: {
    //     trigger: ".parallax",
    //     start: "top 65%",
    //     end: "+=50%",
    //     scrub: true,
    //   },
    // });
    // parallaxTimeline
    //   .from(".parallax .box_1", {
    //     scale: 1.2,
    //     x: -100,
    //     y: 0,
    //     opacity: 0,
    //     duration: animationSpeed,
    //     ease: animationIn,
    //   })
    //   .from(
    //     ".parallax .box_2",
    //     {
    //       scale: 1.2,
    //       x: 0,
    //       y: 30,
    //       opacity: 0,
    //       duration: animationSpeed,
    //       ease: animationIn,
    //     },
    //     0,
    //   )
    //   .from(
    //     ".parallax .box_3",
    //     {
    //       scale: 1.2,
    //       x: 100,
    //       y: 0,
    //       opacity: 0,
    //       duration: animationSpeed,
    //       ease: animationIn,
    //     },
    //     0,
    //   );

    // ========== LICENSES (pin + stagger reveal)
    const licensesTimeline = gsap.timeline({
      scrollTrigger: {
        trigger: ".products",
        start: "top top",
        end: "+=200%",
        pin: true,
        scrub: true,
      },
    });
    licensesTimeline
      .fromTo(
        ".product-bo",
        {
          scale: 1.75,
          x: 200,
        },
        {
          scale: 1,
          x: 0,
          duration: animationSpeed,
        },
      )
      .from(".product-bo-title", {
        y: 40,
        opacity: 0,
        duration: animationSpeed,
      })
      .from(".product-bo-text", {
        x: 80,
        opacity: 0,
        duration: animationSpeed,
      })
      .from(".product-bo-text2", {
        x: 80,
        opacity: 0,
        duration: animationSpeed,
      })
      .from(".product-bo-btn", {
        x: 80,
        opacity: 0,
        duration: animationSpeed,
      });
  });

  /* ==============================================
       MOUSE HOVER
    ============================================== */
  const texts = document.querySelectorAll(".text_spirit div");
  const products = document.querySelectorAll(".img_product");

  if (texts.length && products.length) {
    texts.forEach((text, index) => {
      text.addEventListener("mouseenter", () => {
        products.forEach((product, i) => {
          const circle = product.querySelector(".img_reference");
          if (i === index) {
            product.style.opacity = "1";
            if (circle)
              circle.style.animation = "circleSlideFade 0.6s 0.2s forwards";
            product.classList.add("show");
          } else {
            product.style.opacity = "0";
            if (circle) circle.style.animation = "none";
            product.classList.remove("show");
          }
        });
      });
    });
  }

  /* ==============================================
       PARALLAX TEXTO SOLO EN DESKTOP
    ============================================== */
  function initMouseTrackFloat(selector) {
    const elements = document.querySelectorAll(selector);

    elements.forEach((element) => {
      let halfWidth = element.offsetWidth / 2;

      const updateDimensions = () => {
        halfWidth = element.offsetWidth / 2;
      };

      element.addEventListener("mouseenter", (e) => {
        const rect = element.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const xValue = Math.max(
          -halfWidth,
          Math.min(halfWidth, mouseX - halfWidth),
        );
        element.style.setProperty("--x", `${xValue}px`);
      });

      element.addEventListener("mousemove", (e) => {
        const rect = element.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        const xValue = Math.max(
          -halfWidth,
          Math.min(halfWidth, mouseX - halfWidth),
        );
        element.style.setProperty("--x", `${xValue}px`);
      });

      element.addEventListener("mouseleave", () => {
        element.style.setProperty("--x", "0px");
      });

      // Handle resize
      window.addEventListener("resize", updateDimensions);
    });
  }
  initMouseTrackFloat(".truth-item");
});
