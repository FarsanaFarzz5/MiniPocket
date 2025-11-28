const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
let current = 0;

// Show slide instantly (no animation)
function showSlide(index) {
  slides.forEach((s, i) => s.style.display = (i === index) ? 'block' : 'none');
  dots.forEach(dot => dot.classList.remove('active'));
  if (index > 0 && index <= dots.length) dots[index - 1].classList.add('active');
  current = index;
}

// Next and previous
function nextSlide() {
  if (current < slides.length - 1) {
    showSlide(current + 1);
  } else {
    // Redirect to /start on last slide
    window.location.href = "/start";
  }
}


function prevSlide() {
  if (current > 1) showSlide(current - 1);
}

// Auto switch from first → second
setTimeout(() => {
  current = 1;
  showSlide(current);
}, 4000);

// Swipe detection
let startX = 0, endX = 0;
const container = document.querySelector('.container');
container.addEventListener('touchstart', e => startX = e.touches[0].clientX);
container.addEventListener('touchmove', e => endX = e.touches[0].clientX);
container.addEventListener('touchend', () => {
  let diff = startX - endX;
  if (Math.abs(diff) > 50) {
    if (diff > 0) nextSlide();
    else prevSlide();
  }
});
