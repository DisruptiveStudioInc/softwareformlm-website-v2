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
    if (!link || !mobileNavMenu.contains(link)) {
      return;
    }

    mobileMenu.classList.add("-translate-y-full");
    document.body.classList.remove("overflow-y-hidden");
  });
}

const langSwitchers = document.querySelectorAll(".language-switcher");

if (langSwitchers.length > 0) {
  langSwitchers.forEach((switcher) => {
    const trigger = switcher.querySelector(".lang-trigger");
    const options = switcher.querySelector(".lang-options");

    if (!trigger || !options) {
      return;
    }

    const handleLangClose = () => {
      trigger.classList.remove("open");
      options.classList.remove("open");
    };

    const toggleLangOptions = () => {
      if (window.innerWidth >= 1088) {
        return;
      }

      trigger.classList.toggle("open");
      options.classList.toggle("open");
    };

    trigger.addEventListener("click", toggleLangOptions);

    window.addEventListener("resize", () => {
      if (window.innerWidth >= 1088) {
        handleLangClose();
      }
    });

    window.addEventListener("click", (event) => {
      if (!switcher.contains(event.target)) {
        handleLangClose();
      }
    });
  });
}

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

  navSections.forEach((innerSection) => {
    const sectionIndex = innerSection.dataset.navIndex;

    if (!sectionIndex) {
      return;
    }

    innerSection.id = `inner-section-${sectionIndex}`;
  });

  const navObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) {
          return;
        }

        const index = Array.from(navSections).indexOf(entry.target);
        if (index !== -1) {
          currentSectionIndex = index;
          updateLateralNavigationState();
        }
      });
    },
    {
      rootMargin: `-64px 0px -${window.innerHeight - 104}px 0px`,
      threshold: 0,
    },
  );

  navSections.forEach((section) => {
    navObserver.observe(section);
  });

  const navigateToSection = (direction) => {
    const targetIndex = currentSectionIndex + direction;

    if (targetIndex >= 0 && targetIndex < navSections.length) {
      navSections[targetIndex].scrollIntoView({ behavior: "smooth" });
    }
  };

  lateralUp.addEventListener("click", () => navigateToSection(-1));
  lateralDown.addEventListener("click", () => navigateToSection(1));
  window.addEventListener("scroll", updateLateralNavigationState, {
    passive: true,
  });
  window.addEventListener("resize", updateLateralNavigationState);
  updateLateralNavigationState();
}

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

    if (!scrollRoot || !firstChild || !lastChild) {
      return;
    }

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

const accordionContainers = document.querySelectorAll(".accordion-container");

if (accordionContainers.length > 0) {
  accordionContainers.forEach((accContainer) => {
    accContainer.addEventListener("click", (event) => {
      const trigger = event.target.closest(".acc-trigger");
      if (!trigger) {
        return;
      }

      const content = document.getElementById(trigger.dataset.target);
      if (!content) {
        return;
      }

      content.classList.toggle("open");
      trigger.classList.toggle("open");
    });
  });
}

const ipTabsContainer = document.getElementById("ip-works-tabs");
const ipTabs = document.querySelectorAll(".ip-works-trigger");
const ipTabsContents = document.querySelectorAll(".ip-works-content");
const ipTabsImages = document.querySelectorAll(".ip-works-image");

if (ipTabsContainer && ipTabs.length > 0 && ipTabsContents.length > 0) {
  const ipImagesWraps = Array.from(ipTabsImages).map((el) => el.parentElement);

  const setIpTabsImages = () => {
    if (ipImagesWraps.length === 0) {
      return;
    }

    const [current] = ipImagesWraps.filter((wrap) =>
      wrap.classList.contains("active"),
    );
    const inactiveWraps = ipImagesWraps.filter(
      (wrap) => !wrap.classList.contains("active"),
    );

    if (!current) {
      return;
    }

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
    if (!target) {
      return;
    }

    ipTabs.forEach((tab) => tab.parentElement.classList.remove("active"));
    ipTabsContents.forEach((tabText) => tabText.classList.remove("open"));
    ipImagesWraps.forEach((wrap) => wrap.classList.remove("active"));

    target.parentElement.classList.add("active");
    target.nextElementSibling.classList.add("open");

    if (ipImagesWraps[target.dataset.index]) {
      ipImagesWraps[target.dataset.index].classList.add("active");
      setIpTabsImages();
    }
  });
}

const videoButtons = document.querySelectorAll(".video-button");
const videoPopup = document.getElementById("popup-video");
const closeVideo = document.getElementById("close-video");

if (videoButtons.length > 0 && videoPopup && closeVideo) {
  const iframe = videoPopup.querySelector("iframe");
  let player = null;

  const initPlayer = () => {
    if (window.Vimeo && iframe) {
      player = new window.Vimeo.Player(iframe);
    }
  };

  if (window.Vimeo) {
    initPlayer();
  } else {
    const checkVimeo = window.setInterval(() => {
      if (window.Vimeo) {
        initPlayer();
        window.clearInterval(checkVimeo);
      }
    }, 100);
  }

  const openPopup = () => {
    videoPopup.classList.remove("pointer-events-none", "opacity-0");
    videoPopup.classList.add("opacity-100");
    document.body.classList.add("overflow-hidden");

    if (player) {
      player.setMuted(false).then(() => player.play());
    }
  };

  const closePopup = () => {
    videoPopup.classList.add("pointer-events-none", "opacity-0");
    videoPopup.classList.remove("opacity-100");
    document.body.classList.remove("overflow-hidden");

    if (player) {
      player.pause();
    }
  };

  videoButtons.forEach((btn) => btn.addEventListener("click", openPopup));
  closeVideo.addEventListener("click", closePopup);

  document.addEventListener("keydown", (event) => {
    if (
      event.key === "Escape" &&
      !videoPopup.classList.contains("pointer-events-none")
    ) {
      closePopup();
    }
  });

  videoPopup.addEventListener("click", (event) => {
    if (event.target === videoPopup) {
      closePopup();
    }
  });
}

const popupOpenButtons = document.querySelectorAll(".open-popup[data-target]");
const popupCloseButtons = document.querySelectorAll(
  ".close-popup[data-target]",
);
const popupDialogs = document.querySelectorAll("dialog.popup");
const externalScripts = new Map();

const loadExternalScript = (src) => {
  if (!src) {
    return Promise.resolve();
  }

  if (externalScripts.has(src)) {
    return externalScripts.get(src);
  }

  const existingScript = document.querySelector(`script[src="${src}"]`);
  if (existingScript) {
    if (existingScript.dataset.loadStatus === "loaded") {
      const resolved = Promise.resolve(existingScript);
      externalScripts.set(src, resolved);
      return resolved;
    }

    if (existingScript.dataset.loadStatus === "error") {
      existingScript.remove();
    } else {
      const pending = new Promise((resolve, reject) => {
        existingScript.addEventListener("load", () => resolve(existingScript), {
          once: true,
        });
        existingScript.addEventListener(
          "error",
          () => reject(new Error(`Failed to load ${src}`)),
          { once: true },
        );
      }).catch((error) => {
        externalScripts.delete(src);
        existingScript.remove();
        throw error;
      });

      externalScripts.set(src, pending);
      return pending;
    }
  }

  const promise = new Promise((resolve, reject) => {
    const script = document.createElement("script");
    script.src = src;
    script.async = true;
    script.dataset.loadStatus = "loading";
    script.onload = () => {
      script.dataset.loadStatus = "loaded";
      resolve(script);
    };
    script.onerror = () => {
      script.dataset.loadStatus = "error";
      externalScripts.delete(src);
      script.remove();
      reject(new Error(`Failed to load ${src}`));
    };
    document.body.appendChild(script);
  }).catch((error) => {
    externalScripts.delete(src);
    throw error;
  });

  externalScripts.set(src, promise);
  return promise;
};

const createDemoEmbed = (dialog) => {
  const configElement = dialog.querySelector("[data-lazy-embed-config]");
  const root = dialog.querySelector("[data-lazy-embed-root]");

  if (!configElement || !root || root.dataset.lazyEmbedState === "loaded") {
    return Promise.resolve();
  }

  let config = null;

  try {
    config = JSON.parse(configElement.textContent);
  } catch (error) {
    root.dataset.lazyEmbedState = "error";
    root.innerHTML =
      '<div class="flex min-h-[70vh] items-center justify-center p-6 text-center text-red-700"><p>Unable to load demo.</p></div>';
    return Promise.reject(error);
  }

  root.dataset.lazyEmbedState = "loading";
  root.innerHTML =
    '<div class="flex min-h-[70vh] items-center justify-center p-6 text-center text-secondary-200"><p>Loading demo...</p></div>';

  const iframe = document.createElement("iframe");
  iframe.src = config.src;
  iframe.id = config.id;
  iframe.title = config.title;
  iframe.style.width = "100%";
  iframe.style.height = "100%";
  iframe.style.border = "none";
  iframe.style.borderRadius = "0px";
  iframe.setAttribute("data-layout", "{'id':'INLINE'}");
  iframe.setAttribute("data-trigger-type", "alwaysShow");
  iframe.setAttribute("data-trigger-value", "");
  iframe.setAttribute("data-activation-type", "alwaysActivated");
  iframe.setAttribute("data-activation-value", "");
  iframe.setAttribute("data-deactivation-type", "neverDeactivate");
  iframe.setAttribute("data-deactivation-value", "");
  iframe.setAttribute("data-form-name", config.title);
  iframe.setAttribute("data-height", config.height);
  iframe.setAttribute("data-layout-iframe-id", config.id);
  iframe.setAttribute("data-form-id", config.formId);

  root.innerHTML = "";
  root.appendChild(iframe);

  return loadExternalScript(config.scriptSrc)
    .then(() => {
      root.dataset.lazyEmbedState = "loaded";
    })
    .catch((error) => {
      root.dataset.lazyEmbedState = "error";
      root.innerHTML =
        '<div class="flex min-h-[70vh] items-center justify-center p-6 text-center text-red-700"><p>Unable to load demo.</p></div>';
      throw error;
    });
};

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

    if (hasOpenPopup) {
      return;
    }

    document.documentElement.classList.remove("overflow-hidden");
    document.body.classList.remove("overflow-hidden");
  };

  const getPopupDialog = (targetId) => {
    if (!targetId) {
      return null;
    }

    const targetDialog = document.getElementById(targetId);
    if (!(targetDialog instanceof HTMLDialogElement)) {
      return null;
    }

    return targetDialog;
  };

  const openPopupDialog = async (targetId) => {
    const targetDialog = getPopupDialog(targetId);
    if (!targetDialog || targetDialog.open) {
      return;
    }

    lockScroll();
    targetDialog.showModal();

    if (targetDialog.id === "demo-popup") {
      try {
        await createDemoEmbed(targetDialog);
      } catch (error) {
        console.error(error);
      }
    }
  };

  const closePopupDialog = (targetId) => {
    const targetDialog = getPopupDialog(targetId);
    if (!targetDialog || !targetDialog.open) {
      return;
    }

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
