 
  // 🧱 Prevent layout jump on mobile keyboard open
  document.documentElement.style.height = '100%';
  document.body.style.height = '100%';
  document.body.style.overflow = 'hidden';

  // 🧩 Ensure numeric keypad opens on mobile for amount field
  const amountInput = document.getElementById('gift-amount');
  if (amountInput) {
    amountInput.setAttribute('inputmode', 'numeric');
    amountInput.setAttribute('pattern', '[0-9]*');
  }

  // 🪶 Optional: prevent iOS safari auto-scroll jump
  window.addEventListener('focusin', () => {
    document.body.style.position = 'fixed';
  });
  window.addEventListener('focusout', () => {
    document.body.style.position = '';
  });