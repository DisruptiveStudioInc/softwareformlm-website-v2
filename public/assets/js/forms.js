// Contact form handling
const contactForm = document.getElementById("contact-form");

if (contactForm && typeof window.contactConfig !== "undefined") {
  contactForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const submitBtn = document.getElementById("submit-btn");
    const successMessage = document.getElementById("success-message");
    const errorMessage = document.getElementById("error-message");
    const errorText = document.getElementById("error-text");

    // Hide previous messages
    successMessage.classList.add("hidden");
    errorMessage.classList.add("hidden");
    document
      .querySelectorAll(".error-message")
      .forEach((el) => el.classList.add("hidden"));

    // Disable submit button
    submitBtn.disabled = true;
    submitBtn.textContent =
      window.contactConfig.language === "es" ? "Enviando..." : "Sending...";

    try {
      // Get reCAPTCHA token
      const token = await grecaptcha.execute(
        window.contactConfig.recaptchaSiteKey,
        { action: "contact" }
      );

      // Get form data
      const formData = new FormData(contactForm);
      formData.append("recaptcha_token", token);

      // Send request
      const response = await fetch(window.contactConfig.submitUrl, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        // Show success message
        successMessage.classList.remove("hidden");
        contactForm.reset();

        // Scroll to success message
        successMessage.scrollIntoView({ behavior: "smooth", block: "center" });
      } else {
        // Show errors
        if (result.errors) {
          // Field-specific errors
          Object.keys(result.errors).forEach((field) => {
            const errorEl = document.getElementById(`error-${field}`);
            if (errorEl) {
              errorEl.textContent = result.errors[field];
              errorEl.classList.remove("hidden");
            }
          });
        } else if (result.error) {
          // General error
          errorText.textContent = result.error;
          errorMessage.classList.remove("hidden");
          errorMessage.scrollIntoView({ behavior: "smooth", block: "center" });
        }
      }
    } catch (error) {
      console.error("Error:", error);
      errorText.textContent =
        window.contactConfig.language === "es"
          ? "Ocurrió un error. Por favor, intenta nuevamente."
          : "An error occurred. Please try again.";
      errorMessage.classList.remove("hidden");
      errorMessage.scrollIntoView({ behavior: "smooth", block: "center" });
    } finally {
      // Re-enable submit button
      submitBtn.disabled = false;
      submitBtn.textContent =
        window.contactConfig.language === "es"
          ? "Enviar mensaje"
          : "Send message";
    }
  });
}
