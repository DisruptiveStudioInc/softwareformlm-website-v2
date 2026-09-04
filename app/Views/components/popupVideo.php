<button type="button" class="video-button cursor-pointer h-11 aspect-square rounded-lg hidden lg:flex flex-center self-center bg-surface-100 hover:bg-surface-300/25 text-brand-100 hover:text-brand-200 transition-colors">
  <svg class="size-7"><use href="<?= asset_url('/public/assets/icons.svg') ?>#play"/></svg>
</button>

<div id="popup-video" class="fixed top-0 left-0 w-full h-dvh flex-center p-7 bg-black/80 backdrop-blur-sm z-20 pointer-events-none opacity-0 transition-opacity">
  <button id="close-video" type="button" class="absolute top-7 right-7 p-1 rounded-sm text-white text-3xl leading-none cursor-pointer bg-surface-50/20 hover:bg-brand-100 transition-colors">
    <svg class="size-7"><use href="<?= asset_url('/public/assets/icons.svg') ?>#xmark"/></svg>
  </button>
  <iframe
    src="https://player.vimeo.com/video/<?= $constants['videos'][$currentLang] ?>"
    frameborder="0"
    allow="autoplay; fullscreen; picture-in-picture"
    allowfullscreen
    class="w-full aspect-video max-w-9/10"
    loading="lazy"
  ></iframe>
  <script src="https://player.vimeo.com/api/player.js"></script>
</div>
