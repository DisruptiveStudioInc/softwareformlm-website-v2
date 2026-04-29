<?php
  $exitIntentFormId = $currentLang === 'en'
    ? 'ZYcPrzRgQkMc4ZocMJEj'
    : 'X2ITzrwHHELujZVjnyQK';
  $exitIntentFormConfig = [
    'src' => 'https://api.leadconnectorhq.com/widget/form/' . $exitIntentFormId,
    'scriptSrc' => 'https://link.msgsndr.com/js/form_embed.js',
    'id' => 'inline-exit-intent-' . $exitIntentFormId,
    'title' => $currentLang === 'en'
      ? 'Exit Intent Lead Form - English'
      : 'Exit Intent Lead Form - Espanol',
    'height' => $currentLang === 'en' ? '1153' : '945',
    'formId' => $exitIntentFormId,
  ];
?>
<dialog id="exit-intent-popup" class="popup bg-transparent m-auto w-full max-w-2xl px-7" data-exit-intent-popup>
  <div class="relative w-full rounded-xl lg:rounded-2xl max-h-[90vh] overflow-x-hidden overflow-y-auto" style="background-color:#12173800">
    <button type="button" data-target="exit-intent-popup" class="close-popup absolute top-2 right-2 text-gray-100 bg-surface-200 hover:bg-brand-100 hover:text-secondary-100 rounded-lg cursor-pointer p-1 transition-colors">
      <svg class="size-6 transition-colors"><use href="#xmark"/></svg>
    </button>
    <div
      class="min-h-[70vh] rounded-xl lg:rounded-2xl bg-white overflow-hidden"
      data-lazy-embed-root
      data-lazy-embed-state="idle"
    >
      <div class="flex min-h-[70vh] items-center justify-center p-6 text-center text-secondary-200">
        <p><?= $currentLang === 'es' ? 'Cargando formulario...' : 'Loading form...' ?></p>
      </div>
    </div>
    <script type="application/json" data-lazy-embed-config><?= json_encode($exitIntentFormConfig, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
  </div>
</dialog>