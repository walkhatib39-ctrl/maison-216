import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'flowbite';

document.addEventListener('DOMContentLoaded', () => {
  // TN phone formatter for inputs with data-tel-tn
  const inputs = document.querySelectorAll('input[data-tel-tn]');
  inputs.forEach((input) => {
    const format = (v) => {
      let digits = (v || '').replace(/\D+/g, '');

      // Strip optional country code if pasted
      if (digits.startsWith('216')) digits = digits.slice(3);

      // Max 8 digits (TN)
      digits = digits.slice(0, 8);

      if (digits.length <= 2) return digits;
      if (digits.length <= 5) return `${digits.slice(0, 2)} ${digits.slice(2)}`;
      return `${digits.slice(0, 2)} ${digits.slice(2, 5)} ${digits.slice(5)}`;
    };

    const onInput = (e) => {
      const atEnd =
        document.activeElement === e.target &&
        e.target.selectionStart === e.target.value.length;
      e.target.value = format(e.target.value);
      if (atEnd) {
        e.target.setSelectionRange(e.target.value.length, e.target.value.length);
      }
    };

    const onBlur = (e) => {
      e.target.value = format(e.target.value);
    };

    input.addEventListener('input', onInput);
    input.addEventListener('blur', onBlur);

    // Initialize current value
    input.value = format(input.value || '');
  });
});

// Scroll to first error on forms (server-side validation)
document.addEventListener('DOMContentLoaded', () => {
  try {
    const firstInvalid = document.querySelector('[aria-invalid="true"], .text-red-600');
    if (firstInvalid) {
      const field = firstInvalid.closest('input, textarea, select') || firstInvalid;
      setTimeout(() => {
        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        if (field && typeof field.focus === 'function') field.focus({ preventScroll: true });
      }, 50);
    }
  } catch (e) { /* no-op */ }
});
