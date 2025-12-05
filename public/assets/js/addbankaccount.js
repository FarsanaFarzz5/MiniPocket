const cardNumber = document.getElementById('card_number');
const expiryInput = document.getElementById('expiry');
const cvvInput = document.getElementById('cvv');
const form = document.getElementById('bankForm');
const alertBox = document.getElementById('alertBox');
const cardNumberDisplay = document.getElementById('cardNumberDisplay');
const expiryDisplay = document.getElementById('expiryDisplay');


// =====================================================
// ✅ FORMAT CARD NUMBER (exactly 16 digits, spaced 4-4-4-4)
// =====================================================
cardNumber.addEventListener('input', () => {
  let raw = cardNumber.value.replace(/\D/g, '');

  // limit length to 16 digits
  if (raw.length > 16) raw = raw.slice(0, 16);

  // apply spacing every 4 digits
  let formatted = raw.replace(/(.{4})/g, '$1 ').trim();

  cardNumber.value = formatted;

  // update preview
  cardNumberDisplay.textContent = formatted || '1234 5678 9012 3456';
});


// =====================================================
// ✅ FORMAT EXPIRY DATE MM/YY
// =====================================================
expiryInput.addEventListener('input', () => {
  let val = expiryInput.value.replace(/\D/g, '');

  if (val.length > 2) val = val.slice(0, 2) + '/' + val.slice(2, 4);

  expiryInput.value = val;
  expiryDisplay.textContent = val || 'MM/YY';
});


// =====================================================
// ⚠️ CUSTOM ALERT BOX
// =====================================================
function showAlert(message, color = '#e53935') {
  alertBox.textContent = message;
  alertBox.style.background = `linear-gradient(135deg, ${color}, ${color}cc)`;
  alertBox.style.color = '#fff';
  alertBox.style.display = 'block';
  alertBox.style.animation = 'slideDown 0.4s ease forwards';

  setTimeout(() => {
    alertBox.style.animation = 'slideUp 0.4s ease forwards';
  }, 1800);

  setTimeout(() => {
    alertBox.style.display = 'none';
  }, 2300);
}


// =====================================================
// ✅ FORM VALIDATION (16-digit card, CVV, Expiry)
// =====================================================
form.addEventListener('submit', (e) => {
  e.preventDefault();

  // -----------------------------------------
  // 🔢 CARD NUMBER VALIDATION (must be 16 digits)
  // -----------------------------------------
  const rawCard = cardNumber.value.replace(/\s/g, '');

  if (rawCard.length !== 16) {
    showAlert("Card number must contain exactly 16 digits.");
    return;
  }


  // -----------------------------------------
  // 🔐 CVV VALIDATION
  // -----------------------------------------
  const cvv = cvvInput.value.trim();

  if (!/^\d{3}$/.test(cvv)) {
    showAlert("CVV must be exactly 3 digits.");
    return;
  }


  // -----------------------------------------
  // 🗓 EXPIRY DATE VALIDATION (MM/YY)
  // -----------------------------------------
  const exp = expiryInput.value.split('/');

  if (exp.length !== 2 || exp[0].length !== 2 || exp[1].length !== 2) {
    showAlert("Enter expiry date in MM/YY format.");
    return;
  }

  const month = parseInt(exp[0]);
  const year = parseInt("20" + exp[1]);

  if (month < 1 || month > 12) {
    showAlert("Month must be between 01 and 12.");
    return;
  }

  const now = new Date();
  const expiryDate = new Date(year, month - 1, 1);

  if (expiryDate < now) {
    showAlert("Expiry date must be a future date.");
    return;
  }


  // -----------------------------------------
  // 🎉 SUCCESS → SHOW ALERT & SUBMIT
  // -----------------------------------------
  showAlert("Bank card added successfully!", "#4caf50");

  setTimeout(() => {
    form.submit();
  }, 2000);
});


// =====================================================
// 🚫 PREVENT OUTER PAGE SCROLL
// =====================================================
document.body.addEventListener(
  "touchmove",
  function (e) {
    if (!e.target.closest(".container")) e.preventDefault();
  },
  { passive: false }
);
