<nav class="hidden lg:flex flex-col items-center gap-4 fixed -bottom-4 left-1/2 -translate-x-1/2 -rotate-90 z-10">
  <button type="button" id="lat-nav-up" aria-label="Previous section" class="lat-button group p-1 cursor-pointer text-brand-50 hover:text-brand-200 opacity-70 hover:opacity-100 active:opacity-100 transition-opacity duration-300">
    <svg class="w-10 h-auto drop-shadow-sm drop-shadow-brand-100 transition-colors" width="18" height="32" fill="none">
      <use href="<?= asset_url('/public/assets/icons.svg') ?>#arrows-nav-up"/>
    </svg>
  </button>
  <button type="button" id="lat-nav-down" aria-label="Next section" class="lat-button group p-1 cursor-pointer text-brand-50 hover:text-brand-200 opacity-70 hover:opacity-100 active:opacity-100 transition-opacity duration-300">
    <svg class="w-10 h-auto drop-shadow-sm drop-shadow-brand-100 transition-colors" width="18" height="32" fill="none">
      <use href="<?= asset_url('/public/assets/icons.svg') ?>#arrows-nav-down"/>
    </svg>
  </button>
</nav>
