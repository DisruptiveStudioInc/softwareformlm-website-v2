export default class DepthSlider {
  constructor(container) {
    this.container =
      typeof container === "string"
        ? document.querySelector(container)
        : container;
    // Check if container exists before proceeding
    if (!this.container) {
      console.warn(`DepthSlider: Container "${container}" not found`);
      return;
    }
    this.currentIndex = 0;
    this.slides = [];
    this.init();
  }

  init() {
    // Safety check in case constructor returned early
    if (!this.container) return;

    this.collectSlides();

    // Only proceed if we found slides
    if (this.slides.length === 0) {
      console.warn("DepthSlider: No slides found in container");
      return;
    }

    this.renderPagination();
    this.updateSlides();
    this.updateWrapperHeight();
    this.attachEvents();
  }

  collectSlides() {
    this.slides = Array.from(this.container.querySelectorAll(".slide-depth"));
  }

  updateWrapperHeight() {
    let maxHeight = 0;
    this.slides.forEach((slide) => {
      const height = slide.offsetHeight;
      if (height > maxHeight) {
        maxHeight = height;
      }
    });
    this.container.style.height = maxHeight + "px";
  }

  renderPagination() {
    const pagination = document.getElementById("pagination-depth");
    this.slides.forEach((_, i) => {
      const dot = document.createElement("button");
      dot.className = "pagination-dot";
      dot.dataset.index = i;
      dot.addEventListener("click", () => this.goToSlide(i));
      pagination.appendChild(dot);
    });
  }

  updateSlides() {
    const total = this.slides.length;

    this.slides.forEach((slide, i) => {
      slide.classList.remove("active", "prev", "next", "next-2", "hide");

      if (i === this.currentIndex) {
        slide.classList.add("active");
      } else if (i === (this.currentIndex - 1 + total) % total) {
        slide.classList.add("prev");
      } else if (i === (this.currentIndex + 1) % total) {
        slide.classList.add("next");
      } else if (i === (this.currentIndex + 2) % total) {
        slide.classList.add("next-2");
      } else {
        slide.classList.add("hide");
      }
    });

    this.updatePagination();
  }

  updatePagination() {
    const dots = document.querySelectorAll(".pagination-dot");
    dots.forEach((dot, i) => {
      dot.classList.toggle("active", i === this.currentIndex);
    });
  }

  goToSlide(index) {
    this.currentIndex = index;
    this.updateSlides();
  }

  next() {
    this.currentIndex = (this.currentIndex + 1) % this.slides.length;
    this.updateSlides();
  }

  prev() {
    this.currentIndex =
      (this.currentIndex - 1 + this.slides.length) % this.slides.length;
    this.updateSlides();
  }

  attachEvents() {
    document
      .getElementById("nextBtn")
      .addEventListener("click", () => this.next());
    document
      .getElementById("prevBtn")
      .addEventListener("click", () => this.prev());

    // Keyboard navigation
    document.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft") this.prev();
      if (e.key === "ArrowRight") this.next();
    });

    // Desktop drag interaction (only on screens > 1088px)
    this.setupDragInteraction();

    // Update wrapper height on window resize
    window.addEventListener("resize", () => this.updateWrapperHeight());
  }

  setupDragInteraction() {
    let startY = 0;
    let currentY = 0;
    let isDragging = false;
    const threshold = 50; // pixels to trigger slide change

    const onMouseDown = (e) => {
      // Only enable on desktop
      if (window.innerWidth <= 1088) return;

      // Only if clicking on active slide
      if (!e.target.closest(".slide-depth.active")) return;

      isDragging = true;
      startY = e.clientY;
      currentY = e.clientY;

      document.body.style.cursor = "grabbing";
      e.preventDefault();
    };

    const onMouseMove = (e) => {
      if (!isDragging) return;
      currentY = e.clientY;
    };

    const onMouseUp = () => {
      if (!isDragging) return;

      const deltaY = currentY - startY;

      // Swipe up = previous slide
      if (deltaY < -threshold) {
        this.prev();
      }
      // Swipe down = next slide
      else if (deltaY > threshold) {
        this.next();
      }

      isDragging = false;
      document.body.style.cursor = "";
    };

    this.container.addEventListener("mousedown", onMouseDown);
    document.addEventListener("mousemove", onMouseMove);
    document.addEventListener("mouseup", onMouseUp);

    // Prevent text selection during drag
    this.container.addEventListener("dragstart", (e) => {
      if (window.innerWidth > 1088) {
        e.preventDefault();
      }
    });
  }
}
