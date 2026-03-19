class ResponsiveSlider {
  constructor() {
    this.currentSlide = 0;
    this.currentTabIndex = 0;
    this.isResponsive = false;

    // Get DOM elements
    this.slides = document.querySelectorAll(".tabs-content-slide");
    this.tabs = document.querySelectorAll(".tab");
    this.tabsContainer = document.getElementById("sliderTabs");
    this.prevButton = document.getElementById("prevTab");
    this.nextButton = document.getElementById("nextTab");

    this.totalSlides = this.slides.length;

    this.init();
  }

  init() {
    this.setupEventListeners();
    this.checkResponsive();
    this.updateTabsPosition();

    // Auto-play (optional)
    this.startAutoPlay();
  }

  setupEventListeners() {
    // Tab clicks
    this.tabs.forEach((tab, index) => {
      tab.addEventListener("click", () => {
        this.goToSlide(index);
      });
    });

    // Arrow buttons
    this.prevButton.addEventListener("click", () => {
      if (this.isResponsive) {
        this.prevTab();
      }
    });

    this.nextButton.addEventListener("click", () => {
      if (this.isResponsive) {
        this.nextTab();
      }
    });

    // Window resize
    window.addEventListener("resize", () => {
      this.checkResponsive();
      // Additional update after resize is complete
      clearTimeout(this.resizeTimeout);
      this.resizeTimeout = setTimeout(() => {
        this.updateTabsPosition();
      }, 100);
    });

    // Keyboard navigation
    document.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft") {
        this.prevSlide();
      } else if (e.key === "ArrowRight") {
        this.nextSlide();
      }
    });
  }

  checkResponsive() {
    this.isResponsive = window.innerWidth < 1080;

    if (this.isResponsive) {
      this.currentTabIndex = this.currentSlide;
      this.updateTabsPosition();
    }
  }

  updateTabsPosition() {
    if (this.isResponsive) {
      // In responsive mode, center the current tab.
      // Since the tabs container has justify-content: center, the tab group is centered.
      const tabWidth = this.tabs[0].offsetWidth;
      // Distance between adjacent tabs (handles potential gaps)
      const step = this.totalSlides > 1 ? (this.tabs[1].offsetLeft - this.tabs[0].offsetLeft) : tabWidth;
      
      const translateX = ((this.totalSlides - 1) / 2 - this.currentTabIndex) * step;
      this.tabsContainer.style.transform = `translateX(${translateX}px)`;
    } else {
      // In desktop mode, reset transform
      this.tabsContainer.style.transform = "translateX(0)";
    }
  }

  goToSlide(index) {
    // Remove active classes
    this.slides[this.currentSlide].classList.remove("active");
    this.tabs[this.currentSlide].classList.remove("active");

    // Update current slide
    this.currentSlide = index;
    this.currentTabIndex = index;

    // Add active classes
    this.slides[this.currentSlide].classList.add("active");
    this.tabs[this.currentSlide].classList.add("active");

    // Update tab position in responsive mode
    if (this.isResponsive) {
      this.updateTabsPosition();
    }

    // Restart auto-play
    this.restartAutoPlay();
  }

  nextSlide() {
    const nextIndex = (this.currentSlide + 1) % this.totalSlides;
    this.goToSlide(nextIndex);
  }

  prevSlide() {
    const prevIndex =
      (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
    this.goToSlide(prevIndex);
  }

  nextTab() {
    if (this.isResponsive) {
      this.nextSlide();
    }
  }

  prevTab() {
    if (this.isResponsive) {
      this.prevSlide();
    }
  }

  startAutoPlay() {
    this.autoPlayInterval = setInterval(() => {
      this.nextSlide();
    }, 5000); // Change slide every 5 seconds
  }

  stopAutoPlay() {
    if (this.autoPlayInterval) {
      clearInterval(this.autoPlayInterval);
    }
  }

  restartAutoPlay() {
    this.stopAutoPlay();
    this.startAutoPlay();
  }
}

// Initialize the slider when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  // You can now pass options to configure the slider
  window.slider = new ResponsiveSlider({
    autoPlay: false, // Enable/disable autoplay
    //autoPlayInterval: 5000, // Autoplay interval in milliseconds
  });
});

// Pause auto-play when page is not visible (only if autoplay is enabled)
// document.addEventListener("visibilitychange", () => {
//   if (!window.slider || !window.slider.options.autoPlay) return;

//   if (document.hidden) {
//     window.slider.stopAutoPlay();
//   } else {
//     window.slider.startAutoPlay();
//   }
// });
