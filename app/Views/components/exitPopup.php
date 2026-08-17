<dialog id="exit-intent-popup" class="popup bg-transparent m-auto w-full max-w-2xl px-7" data-exit-intent-popup>
  <div class="relative w-full bg-white rounded-xl lg:rounded-2xl max-h-[90vh] overflow-x-hidden overflow-y-auto">
    <button type="button" data-target="exit-intent-popup" aria-label="Close dialog" class="close-popup absolute top-2 right-2 text-gray-100 bg-surface-200 hover:bg-brand-100 hover:text-secondary-100 rounded-lg cursor-pointer p-1 transition-colors">
      <svg class="size-6 transition-colors"><use href="/public/assets/icons.svg.php#xmark"/></svg>
    </button>
    <div class="p-6 lg:p-8 text-secondary-200">
      <div class="text-center mb-6">
        <h2 class="font-title text-3xl lg:text-4xl leading-tight text-balance mb-3"><?= $trans('exit_popup.title') ?></h2>
        <p class="text-balance"><?= $trans('exit_popup.text') ?></p>
      </div>

      <div id="exit-intent-success-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
        <?= $trans('exit_popup.success') ?>
      </div>

      <div id="exit-intent-error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
        <span id="exit-intent-error-text"></span>
      </div>

      <form
        id="exit-intent-form"
        class="space-y-4"
        data-submit-url="/exit-intent-submit"
        data-language="<?= $currentLang ?>"
        data-recaptcha-site-key="<?= htmlspecialchars($config['recaptcha']['site_key'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
      >
        <input type="hidden" name="language" value="<?= $currentLang ?>">
        <input type="hidden" name="page_path" value="<?= htmlspecialchars(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="source" value="exit_popup">
        <input type="hidden" name="campaign_medium" value="">
        <input type="hidden" name="campaign_name" value="">
        <input type="hidden" name="campaign_source" value="">
        <input type="hidden" name="ad_id" value="">
        <input type="hidden" name="campaign_content" value="">

        <div>
          <label for="exit-intent-name" class="block text-sm mb-1">
            <?= $trans('contact.form.name') ?>
          </label>
          <input
            type="text"
            id="exit-intent-name"
            name="name"
            required
            class="w-full px-4 py-3 border border-grey-100/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-100"
          >
          <span class="error-message text-red-700 text-sm hidden" id="exit-intent-error-name"></span>
        </div>

        <div>
          <label for="exit-intent-email" class="block text-sm mb-1">
            <?= $trans('contact.form.email') ?>
          </label>
          <input
            type="email"
            id="exit-intent-email"
            name="email"
            required
            class="w-full px-4 py-3 border border-grey-100/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-100"
          >
          <span class="error-message text-red-700 text-sm hidden" id="exit-intent-error-email"></span>
        </div>

        <div>
          <label for="exit-intent-phone" class="block text-sm mb-1">
            <?= $trans('contact.form.phone') ?>
          </label>
          <input
            type="tel"
            id="exit-intent-phone"
            name="phone"
            class="w-full px-4 py-3 border border-grey-100/40 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-100"
          >
        </div>

        <button
          type="submit"
          id="exit-intent-submit-btn"
          class="button w-full bg-brand-100 text-white py-3 px-8 rounded-lg font-semibold cursor-pointer hover:bg-brand-200 transition-colors disabled:opacity-60 disabled:pointer-events-none disabled:cursor-not-allowed"
        >
          <?= $trans('exit_popup.submit') ?>
        </button>

        <p class="text-xs text-center text-grey-100/80">
          <?= $currentLang === 'es'
            ? 'Este sitio está protegido por reCAPTCHA y se aplican la Política de privacidad y los Términos de servicio de Google.'
            : 'This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.'
          ?>
        </p>
      </form>
    </div>
  </div>
</dialog>
