const slider = document.getElementById('subcategories-swiper');

if (slider) {
  const slides = [...slider.querySelectorAll('[data-native-slide]')];
  const previous = document.querySelector('.subcategories-button-prev');
  const next = document.querySelector('.subcategories-button-next');
  let activeIndex = 0;

  const setActive = (index) => {
    activeIndex = Math.max(0, Math.min(index, slides.length - 1));
    slides.forEach((slide, slideIndex) => {
      slide.classList.toggle('swiper-slide-active', slideIndex === activeIndex);
      slide.setAttribute('aria-hidden', slideIndex === activeIndex ? 'false' : 'true');
    });
    previous?.toggleAttribute('disabled', activeIndex === 0);
    next?.toggleAttribute('disabled', activeIndex === slides.length - 1);
  };

  const scrollToSlide = (index) => {
    slides[index]?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
  };

  previous?.addEventListener('click', () => scrollToSlide(activeIndex - 1));
  next?.addEventListener('click', () => scrollToSlide(activeIndex + 1));

  const observer = new IntersectionObserver((entries) => {
    const current = entries
      .filter((entry) => entry.isIntersecting)
      .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
    if (current) setActive(slides.indexOf(current.target));
  }, { root: slider, threshold: [0.55, 0.8] });

  slides.forEach((slide) => observer.observe(slide));
  setActive(0);
}
