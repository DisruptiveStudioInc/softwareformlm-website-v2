import DepthSlider from './depthSlider.js';

const slider = document.querySelector('[data-service-slider]');

if (slider) {
  const wrapper = slider.querySelector('[data-service-slides]');
  const slides = [...slider.querySelectorAll('[data-service-slide]')];
  const previous = document.getElementById('serv-prev');
  const next = document.getElementById('serv-next');
  const dots = document.getElementById('serv-dots');
  const introButton = document.getElementById('serv-int-button');
  const desktopQuery = window.matchMedia('(min-width: 1088px)');
  let activeIndex = 0;
  let observer;

  const setActive = (index, shouldFocus = false) => {
    activeIndex = Math.max(0, Math.min(index, slides.length - 1));
    slides.forEach((slide, slideIndex) => {
      const active = slideIndex === activeIndex;
      slide.classList.toggle('swiper-slide-active', active);
      slide.classList.toggle('swiper-slide-fully-visible', active);
      slide.setAttribute('aria-hidden', active ? 'false' : 'true');
    });
    [...dots.querySelectorAll('button')].forEach((dot, dotIndex) => {
      const active = dotIndex === activeIndex;
      dot.classList.toggle('bg-brand-100', active);
      dot.setAttribute('aria-current', active ? 'true' : 'false');
    });
    previous.disabled = activeIndex === 0;
    next.disabled = activeIndex === slides.length - 1;

    if (desktopQuery.matches) {
      slider.scrollTo({ left: 0, top: 0, behavior: 'auto' });
      wrapper.style.transform = `translate3d(-${activeIndex * 100}%, 0, 0)`;
    } else if (shouldFocus) {
      slides[activeIndex].scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  slides.forEach((_, index) => {
    const dot = document.createElement('button');
    dot.type = 'button';
    dot.className = 'serv-dot h-3 w-4 xs:w-8 rounded-sm transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-brand-200';
    dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
    dot.addEventListener('click', () => setActive(index, true));
    dots.appendChild(dot);
  });

  previous.addEventListener('click', () => setActive(activeIndex - 1, true));
  next.addEventListener('click', () => setActive(activeIndex + 1, true));
  introButton?.addEventListener('click', () => setActive(1, true));

  const attachMobileObserver = () => {
    observer?.disconnect();
    if (desktopQuery.matches) return;
    observer = new IntersectionObserver((entries) => {
      const current = entries
        .filter((entry) => entry.isIntersecting)
        .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
      if (current) setActive(slides.indexOf(current.target));
    }, { root: slider, threshold: [0.55, 0.8] });
    slides.forEach((slide) => observer.observe(slide));
  };

  desktopQuery.addEventListener('change', () => {
    attachMobileObserver();
    setActive(activeIndex);
  });
  attachMobileObserver();
  setActive(0);

  const processSlider = document.querySelector('[data-process-slider]');
  if (processSlider) {
    const processSlides = [...processSlider.querySelectorAll('[data-process-slide]')];
    const pagination = document.getElementById('my-swiper-pagination');
    const processButtons = [];
    let processActiveIndex = 0;
    let processScrollTimer;

    const setProcessActive = (index) => {
      processActiveIndex = Math.max(0, Math.min(index, processSlides.length - 1));

      processSlides.forEach((slide, slideIndex) => {
        const active = slideIndex === processActiveIndex;
        slide.classList.toggle('swiper-slide-active', active);
        slide.classList.toggle('swiper-slide-prev', slideIndex === processActiveIndex - 1);
        slide.classList.toggle('swiper-slide-next', slideIndex === processActiveIndex + 1);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
      });

      processButtons.forEach((button, buttonIndex) => {
        const active = buttonIndex === processActiveIndex;
        button.classList.toggle('active', active);
        button.setAttribute('aria-current', active ? 'true' : 'false');
      });
    };

    const getProcessSlideOffset = (slide) => (
      slide.offsetLeft - processSlides[0].offsetLeft
    );

    const scrollToProcessSlide = (index) => {
      const boundedIndex = Math.max(0, Math.min(index, processSlides.length - 1));
      const target = processSlides[boundedIndex];
      if (!target) return;

      setProcessActive(boundedIndex);
      processSlider.scrollTo({
        left: getProcessSlideOffset(target),
        top: 0,
        behavior: 'smooth',
      });
    };

    processSlides.forEach((slide, index) => {
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'flex-center size-9 lg:size-12 text-lg lg:text-xl font-bold text-secondary-100 leading-none rounded-full bg-brand-100 hover:bg-brand-200 [&.active]:bg-secondary-200 [&.active]:text-white transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-brand-200';
      button.textContent = String(index + 1);
      button.setAttribute('aria-label', `Go to process ${index + 1}`);
      button.addEventListener('click', (event) => {
        event.stopPropagation();
        scrollToProcessSlide(index);
      });
      processButtons.push(button);
      pagination?.appendChild(button);
    });

    processSlider.addEventListener('scroll', () => {
      window.clearTimeout(processScrollTimer);
      processScrollTimer = window.setTimeout(() => {
        const closestIndex = processSlides.reduce((closest, slide, index) => {
          const closestDistance = Math.abs(
            getProcessSlideOffset(processSlides[closest]) - processSlider.scrollLeft,
          );
          const currentDistance = Math.abs(
            getProcessSlideOffset(slide) - processSlider.scrollLeft,
          );
          return currentDistance < closestDistance ? index : closest;
        }, 0);
        setProcessActive(closestIndex);
      }, 80);
    }, { passive: true });

    setProcessActive(0);
  }

  if (document.getElementById('faq-slider')) {
    new DepthSlider('#faq-slider');
  }
}
