const cardNumber = document.getElementById('card_number');
const expiryInput = document.getElementById('expiry');
const form = document.getElementById('bankForm');
const alertBox = document.getElementById('alertBox');
const cardNumberDisplay = document.getElementById('cardNumberDisplay');
const expiryDisplay = document.getElementById('expiryDisplay');

// ✅ Format card number with spaces
cardNumber.addEventListener('input', () => {
  let formatted = cardNumber.value.replace(/\D/g, '').replace(/(.{4})/g, '$1 ').trim();
  cardNumber.value = formatted;
  cardNumberDisplay.textContent = formatted || '1234 5678 9012 3456';
});

// ✅ Format expiry date MM/YY
expiryInput.addEventListener('input', () => {
  let val = expiryInput.value.replace(/\D/g, '');
  if (val.length > 2) val = val.slice(0, 2) + '/' + val.slice(2, 4);
  expiryInput.value = val;
  expiryDisplay.textContent = val || 'MM/YY';
});

// ✅ Show styled alert (reusable)
function showAlert(message, color = '#4caf50', textColor = '#fff') {
  alertBox.textContent = message;
  alertBox.style.background = `linear-gradient(135deg, ${color}, ${color}cc)`;
  alertBox.style.color = textColor;
  alertBox.style.display = 'block';
  alertBox.style.animation = 'slideDown 0.4s ease forwards';

  // Auto-hide
  setTimeout(() => {
    alertBox.style.animation = 'slideUp 0.4s ease forwards';
  }, 1800);

  // Hide fully after animation
  setTimeout(() => {
    alertBox.style.display = 'none';
  }, 2300);
}

// ✅ Validate expiry date on submit
form.addEventListener('submit', (e) => {
  e.preventDefault();

  const exp = expiryInput.value.split('/');
  if (exp.length !== 2 || exp[0].length < 2 || exp[1].length < 2) {
    showAlert('Please enter a valid expiry date.', '#e53935');
    return;
  }

  const month = parseInt(exp[0]);
  const year = parseInt('20' + exp[1]);
  const now = new Date();
  const expiryDate = new Date(year, month - 1);

  if (month < 1 || month > 12 || expiryDate < now) {
    showAlert('Expiry date must be a future date.', '#e53935');
    return;
  }

  // ✅ Success alert + delay submit
  showAlert(' Bank card added successfully!', '#4caf50');

  setTimeout(() => {
    form.submit();
  }, 2200);
  
    document.body.addEventListener('touchmove', function (e) {
    if (!e.target.closest('.container')) e.preventDefault();
  }, { passive: false });
});
