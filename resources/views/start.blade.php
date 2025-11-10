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

<script src="{{ asset('assets/js/start.js') }}"></script>
</body>
</html>
