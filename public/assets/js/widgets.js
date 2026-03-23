import { ballDownAnim, ballUpAnim, flipTabContent } from "./animations.js";

// Mobile menu toggle
const mobileMenuButton = document.getElementById("mobile-menu-button");
const mobileCloseMenuButton = document.getElementById("close-mobile-button");
const mobileMenu = document.getElementById("mobile-menu");
const mobileNavMenu = document.getElementById("mobile-nav");

if (mobileMenuButton && mobileCloseMenuButton && mobileMenu && mobileNavMenu) {
  mobileMenuButton.addEventListener("click", () => {
    mobileMenu.classList.remove("-translate-y-full");
    document.body.classList.add("overflow-y-hidden");
  });
  mobileCloseMenuButton.addEventListener("click", () => {
    mobileMenu.classList.add("-translate-y-full");
    document.body.classList.remove("overflow-y-hidden");
  });
  mobileNavMenu.addEventListener("click", (event) => {
    const link = event.target.closest("a");
    if (!link || !mobileNavMenu.contains(link)) return;
    mobileMenu.classList.add("-translate-y-full");
    document.body.classList.remove("overflow-y-hidden");
  });
}

// Language switcher for mobile
const langSwitchers = document.querySelectorAll(".language-switcher");

if (langSwitchers.length > 0) {
  langSwitchers.forEach((switcher) => {
    const trigger = switcher.querySelector(".lang-trigger");
    const options = switcher.querySelector(".lang-options");

    const handleLangClose = () => {
      trigger.classList.remove("open");
      options.classList.remove("open");
    };

    const handleLangToggle = () => {
      if (window.innerWidth >= 1088) return;
      trigger.addEventListener("click", () => {
        trigger.classList.toggle("open");
        options.classList.toggle("open");
      });
    };

    window.addEventListener("resize", () => {
      if (window.innerWidth >= 1088) {
        handleLangClose();
      } else {
        handleLangToggle();
      }
    });

    //close switcher when clicked outsite
    window.addEventListener("click", (event) => {
      const targetElement = event.target;
      if (!switcher.contains(targetElement)) {
        handleLangClose();
      }
    });

    handleLangToggle();
  });
}

// Side navigation for sections
const lateralUp = document.getElementById("lat-nav-up");
const lateralDown = document.getElementById("lat-nav-down");
const navSections = document.querySelectorAll(".nav-section");

if (lateralUp && lateralDown && navSections.length > 0) {
  let currentSectionIndex = 0;

  navSections.forEach((innerSection, index) => {
    const sectionIndex = innerSection.dataset.navIndex;
    if (!sectionIndex) return;
    innerSection.id = `inner-section-${sectionIndex}`;
  });

  const optionsNavObserver = {
    rootMargin: `-64px 0px -${window.innerHeight - 104}px 0px`,
    threshold: 0,
  };

  const navObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const index = Array.from(navSections).indexOf(entry.target);
        const isFirst = index === 0;
        const isLast = index === navSections.length - 1;
        lateralUp.classList.toggle("!opacity-0", isFirst);
        lateralDown.classList.toggle("!opacity-0", isLast);
        if (index !== -1) {
          currentSectionIndex = index;
        }
      }
    });
  }, optionsNavObserver);

  navSections.forEach((section) => {
    navObserver.observe(section);
  });

  function navigateToSection(direction) {
    const targetIndex = currentSectionIndex + direction;
    if (targetIndex >= 0 && targetIndex < navSections.length) {
      navSections[targetIndex].scrollIntoView({ behavior: "smooth" });
    }
  }

  lateralUp.addEventListener("click", () => navigateToSection(-1));
  lateralDown.addEventListener("click", () => navigateToSection(1));
}

// Accordion toggle
const accordionContainers = document.querySelectorAll(".accordion-container");

if (accordionContainers.length > 0) {
  accordionContainers.forEach((accContainer) => {
    accContainer.addEventListener("click", (event) => {
      const trigger = event.target.closest(".acc-trigger");
      if (!trigger) return;

      const content = document.getElementById(trigger.dataset.target);
      if (!content) return;
      content.classList.toggle("open");
      trigger.classList.toggle("open");
    });
  });
}

// Discover tabs
const discoverTabs = document.getElementById("discover-tabs");
const discoverContent = document.getElementById("discover-content");

if (discoverTabs && discoverContent) {
  discoverTabs.addEventListener("click", (event) => {
    const trigger = event.target.closest(".discover-tab");
    if (!trigger) return;

    const tabs = discoverTabs.querySelectorAll(".discover-tab");
    tabs.forEach((tab) => tab.classList.remove("active"));
    trigger.classList.add("active");

    const contentData = JSON.parse(discoverContent.dataset.content);
    if (!contentData) return;
    const index = trigger.dataset.index;
    const svgAnim = trigger.dataset.animation;

    const icon = discoverContent.querySelector("svg use");
    const title = discoverContent.querySelector("h3");
    const text = discoverContent.querySelector("p");

    const setContent = () => {
      title.innerHTML = contentData[index].title;
      text.innerHTML = contentData[index].text;
      icon.setAttribute("href", `#${contentData[index].icon}`);
    };

    svgAnim === "up" ? ballUpAnim.restart() : ballDownAnim.restart();
    setTimeout(() => {
      flipTabContent.restart();
    }, 1000);
    setTimeout(() => {
      setContent();
    }, 1200);
  });
}
// Cases image parallax
const casesSection = document.querySelector(".cases-section");
const cases = document.querySelectorAll(".case");

if (casesSection && cases.length > 0) {
  let mouseMoveHandler = null;

  const handleMouseMove = (event) => {
    const target = event.target.closest(".case");
    if (!target) return;
    const image = target.querySelector(".case-image");
    if (!image) return;

    const rect = target.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
    const moveX = (rect.width / 2 - x) / 20;
    const moveY = (rect.height / 2 - y) / 20;

    image.style.transform = `translate(${moveX}px, ${moveY}px)`;

    target.addEventListener(
      "mouseleave",
      () => {
        image.style.transform = `translate(0px, 0px)`;
      },
      { once: true },
    );
  };

  const attachParallax = () => {
    if (window.innerWidth >= 1088 && !mouseMoveHandler) {
      mouseMoveHandler = handleMouseMove;
      casesSection.addEventListener("mousemove", mouseMoveHandler);
    }
  };

  const detachParallax = () => {
    if (mouseMoveHandler) {
      casesSection.removeEventListener("mousemove", mouseMoveHandler);
      mouseMoveHandler = null;

      // Reset all images
      cases.forEach((caseEl) => {
        const image = caseEl.querySelector(".case-image");
        if (image) {
          image.style.transform = "none";
        }
      });
    }
  };

  const checkViewport = () => {
    if (window.innerWidth >= 1088) {
      attachParallax();
    } else {
      detachParallax();
    }
  };

  // Initial check
  checkViewport();

  // Listen for resize
  window.addEventListener("resize", checkViewport);
}

// IPs how works tabs
const ipTabsContainer = document.getElementById("ip-works-tabs");
const ipTabs = document.querySelectorAll(".ip-works-trigger");
const ipTabsContents = document.querySelectorAll(".ip-works-content");
const ipTabsImages = document.querySelectorAll(".ip-works-image");

if (ipTabsContainer && ipTabs && ipTabsContents && ipTabsImages) {
  const ipImagesWraps = Array.from(ipTabsImages).map((el) => el.parentElement);

  const setIpTabsImages = () => {
    const [current] = ipImagesWraps.filter((wrap) =>
      wrap.classList.contains("active"),
    );
    const inactiveWraps = ipImagesWraps.filter(
      (wrap) => !wrap.classList.contains("active"),
    );
    current.style.zIndex = `${ipImagesWraps.length}`;
    current.style.transform = "";
    inactiveWraps.forEach((wrap, index) => {
      wrap.style.zIndex = `${inactiveWraps.length - index}`;
      wrap.style.transform = `translateX(calc(40px * ${index + 1}))`;
    });
  };
  setIpTabsImages();

  ipTabsContainer.addEventListener("click", (event) => {
    const target = event.target.closest(".ip-works-trigger");
    if (!target) return;

    ipTabs.forEach((tab) => tab.parentElement.classList.remove("active"));
    ipTabsContents.forEach((tabText) => tabText.classList.remove("open"));
    ipImagesWraps.forEach((wrap) => wrap.classList.remove("active"));

    target.parentElement.classList.add("active");
    target.nextElementSibling.classList.add("open");
    ipImagesWraps[target.dataset.index].classList.add("active");

    setIpTabsImages();
  });
}

//Video popup
const videoButtons = document.querySelectorAll(".video-button");
const videoPopup = document.getElementById("popup-video");
const closeVideo = document.getElementById("close-video");

if (videoButtons.length > 0 && videoPopup && closeVideo) {
  const iframe = videoPopup.querySelector("iframe");
  let player = null;

  // Initialize Vimeo player after the script loads
  const initPlayer = () => {
    if (window.Vimeo && iframe) {
      player = new Vimeo.Player(iframe);
    }
  };

  // Check if Vimeo API is already loaded, otherwise wait for it
  if (window.Vimeo) {
    initPlayer();
  } else {
    // Wait for Vimeo script to load
    const checkVimeo = setInterval(() => {
      if (window.Vimeo) {
        initPlayer();
        clearInterval(checkVimeo);
      }
    }, 100);
  }

  const openPopup = () => {
    videoPopup.classList.remove("pointer-events-none", "opacity-0");
    videoPopup.classList.add("opacity-100");
    document.body.classList.add("overflow-hidden");

    // Play video with audio
    if (player) {
      player.setMuted(false).then(() => {
        player.play();
      });
    }
  };

  const closePopup = () => {
    videoPopup.classList.add("pointer-events-none", "opacity-0");
    videoPopup.classList.remove("opacity-100");
    document.body.classList.remove("overflow-hidden");

    // Pause video
    if (player) {
      player.pause();
    }
  };

  // Open popup on button click
  videoButtons.forEach((btn) => btn.addEventListener("click", openPopup));

  // Close popup on close button click
  closeVideo.addEventListener("click", closePopup);

  // Close popup on ESC key
  document.addEventListener("keydown", (event) => {
    if (
      event.key === "Escape" &&
      !videoPopup.classList.contains("pointer-events-none")
    ) {
      closePopup();
    }
  });

  // Close popup when clicking outside the video (on the backdrop)
  videoPopup.addEventListener("click", (event) => {
    if (event.target === videoPopup) {
      closePopup();
    }
  });
}
