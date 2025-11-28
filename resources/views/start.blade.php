<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>First Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no,email=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('assets/css/start.css') }}">

</head>

<body>
  <div class="container">

    <div class="indicator">
      <div class="dot active"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>

    <!-- First -->
    <div class="slide first" style="display:block;">
      <img src="{{ asset('images/pock.jpg') }}" alt="Image 1">
    </div>

    <!-- Second -->
    <div class="slide second">
      <img src="{{ asset('images/mini 01.jpg') }}" alt="Image 2">
      <p>Saving is the<br><b>First Step<br>to Growing.</b></p>
      <div class="skip-btn" onclick="nextSlide()">Skip</div>
    </div>

    <!-- Third -->
    <div class="slide third">
      <img src="{{ asset('images/mini 02.jpg') }}" alt="Image 3">
      <p>Teach Saving,<br><b>Gift a Future</b></p>
      <div class="skip-btn" onclick="nextSlide()">Skip</div>
    </div>

    <!-- Fourth -->
    <div class="slide fourth">
      <img src="{{ asset('images/mini 03.jpg') }}" alt="Image 4">
      <p>Little Hands,<br><b>Big Plans,<br>Kind Actions</b></p>
      <div class="skip-btn" onclick="window.location.href='{{ route('welcome') }}'">Skip</div>
    </div>

  </div>

  <script>
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

    </script>
</body>
</html>
