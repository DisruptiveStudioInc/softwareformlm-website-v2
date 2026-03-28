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
const mainFooter = document.getElementById("main-footer");

if (lateralUp && lateralDown && navSections.length > 0) {
  let currentSectionIndex = 0;

  const isFullyInsideFooter = (element, footerRect) => {
    const elementRect = element.getBoundingClientRect();

    return (
      elementRect.top >= footerRect.top &&
      elementRect.bottom <= footerRect.bottom &&
      elementRect.left >= footerRect.left &&
      elementRect.right <= footerRect.right
    );
  };

  const updateLateralNavigationState = () => {
    const isFirst = currentSectionIndex === 0;
    const isLast = currentSectionIndex === navSections.length - 1;
    const buttonsInsideFooter = mainFooter
      ? (() => {
          const footerRect = mainFooter.getBoundingClientRect();

          return (
            isFullyInsideFooter(lateralUp, footerRect) &&
            isFullyInsideFooter(lateralDown, footerRect)
          );
        })()
      : false;

    lateralUp.classList.toggle("!opacity-0", isFirst || buttonsInsideFooter);
    lateralDown.classList.toggle("!opacity-0", isLast || buttonsInsideFooter);
    lateralUp.classList.toggle(
      "pointer-events-none",
      isFirst || buttonsInsideFooter,
    );
    lateralDown.classList.toggle(
      "pointer-events-none",
      isLast || buttonsInsideFooter,
    );
  };

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
        if (index !== -1) {
          currentSectionIndex = index;
          updateLateralNavigationState();
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
  window.addEventListener("scroll", updateLateralNavigationState, {
    passive: true,
  });
  window.addEventListener("resize", updateLateralNavigationState);
  updateLateralNavigationState();
}

// Scroll gradients
const scrollGradientContainers = document.querySelectorAll(
  ".top-bottom-scroll-grad",
);

if (scrollGradientContainers.length > 0) {
  const scrollGradientThreshold = 0.3;
  const scrollGradientObserverThresholds = [0, scrollGradientThreshold, 1];

  const setScrollGradientState = (
    container,
    scrollRoot,
    firstChild,
    lastChild,
  ) => {
    const scrollRootRect = scrollRoot.getBoundingClientRect();
    const firstRect = firstChild.getBoundingClientRect();
    const lastRect = lastChild.getBoundingClientRect();

    const firstVisibleHeight =
      Math.min(firstRect.bottom, scrollRootRect.bottom) -
      Math.max(firstRect.top, scrollRootRect.top);
    const lastVisibleHeight =
      Math.min(lastRect.bottom, scrollRootRect.bottom) -
      Math.max(lastRect.top, scrollRootRect.top);

    const firstRatio =
      firstRect.height > 0
        ? Math.max(0, firstVisibleHeight) / firstRect.height
        : 0;
    const lastRatio =
      lastRect.height > 0
        ? Math.max(0, lastVisibleHeight) / lastRect.height
        : 0;
    const hasOverflow = scrollRoot.scrollHeight > scrollRoot.clientHeight;

    container.classList.toggle(
      "show-top-scroll-grad",
      hasOverflow && firstRatio < scrollGradientThreshold,
    );
    container.classList.toggle(
      "show-bottom-scroll-grad",
      hasOverflow && lastRatio < scrollGradientThreshold,
    );
  };

  scrollGradientContainers.forEach((container) => {
    const scrollRoot = container.firstElementChild;
    const firstChild = scrollRoot?.firstElementChild;
    const lastChild = scrollRoot?.lastElementChild;

    if (!scrollRoot || !firstChild || !lastChild) return;

    const handleObserverEntry = (entries) => {
      const hasOverflow = scrollRoot.scrollHeight > scrollRoot.clientHeight;

      entries.forEach((entry) => {
        if (entry.target === firstChild) {
          container.classList.toggle(
            "show-top-scroll-grad",
            hasOverflow && entry.intersectionRatio < scrollGradientThreshold,
          );
        }

        if (entry.target === lastChild) {
          container.classList.toggle(
            "show-bottom-scroll-grad",
            hasOverflow && entry.intersectionRatio < scrollGradientThreshold,
          );
        }
      });
    };

    const scrollGradientObserver = new IntersectionObserver(
      handleObserverEntry,
      {
        root: scrollRoot,
        threshold: scrollGradientObserverThresholds,
      },
    );

    scrollGradientObserver.observe(firstChild);
    if (lastChild !== firstChild) {
      scrollGradientObserver.observe(lastChild);
    }

    setScrollGradientState(container, scrollRoot, firstChild, lastChild);

    window.addEventListener("resize", () => {
      setScrollGradientState(container, scrollRoot, firstChild, lastChild);
    });
  });
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

// Dialog popups
const popupOpenButtons = document.querySelectorAll(".open-popup[data-target]");
const popupCloseButtons = document.querySelectorAll(
  ".close-popup[data-target]",
);
const popupDialogs = document.querySelectorAll("dialog.popup");

if (
  popupOpenButtons.length > 0 &&
  popupCloseButtons.length > 0 &&
  popupDialogs.length > 0
) {
  const lockScroll = () => {
    document.documentElement.classList.add("overflow-hidden");
    document.body.classList.add("overflow-hidden");
  };

  const unlockScroll = () => {
    const hasOpenPopup = Array.from(popupDialogs).some((dialog) => dialog.open);

    if (hasOpenPopup) return;

    document.documentElement.classList.remove("overflow-hidden");
    document.body.classList.remove("overflow-hidden");
  };

  const getPopupDialog = (targetId) => {
    if (!targetId) return null;

    const targetDialog = document.getElementById(targetId);
    if (!(targetDialog instanceof HTMLDialogElement)) return null;

    return targetDialog;
  };

  const openPopupDialog = (targetId) => {
    const targetDialog = getPopupDialog(targetId);
    if (!targetDialog || targetDialog.open) return;

    lockScroll();
    targetDialog.showModal();
  };

  const closePopupDialog = (targetId) => {
    const targetDialog = getPopupDialog(targetId);
    if (!targetDialog || !targetDialog.open) return;

    targetDialog.close();
  };

  popupOpenButtons.forEach((button) => {
    button.addEventListener("click", () => {
      openPopupDialog(button.dataset.target);
    });
  });

  popupCloseButtons.forEach((button) => {
    button.addEventListener("click", () => {
      closePopupDialog(button.dataset.target);
    });
  });

  popupDialogs.forEach((dialog) => {
    dialog.addEventListener("click", (event) => {
      if (event.target === dialog) {
        closePopupDialog(dialog.id);
      }
    });

    dialog.addEventListener("close", unlockScroll);
  });
}
