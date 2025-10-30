<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Scan QR - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('assets/css/scan.css')}}">

</head>

<body>
  <div id="reader"></div>
  <h2>📷 Scan any QR code</h2>
  <div class="scanner-frame"><div class="scanner-line"></div></div>

  <div class="btn-container">
    <!-- Back button on the left -->
    <button class="back-btn" onclick="window.location.href='{{ route('kid.dashboard') }}'">Back</button>

    <!-- Upload image on the right -->
    <label for="qrFile" class="upload-btn">Upload Image</label>
    <input type="file" id="qrFile" accept="image/*">
  </div>

  <script src="https://unpkg.com/html5-qrcode"></script>
  <script src="{{ asset('assets/js/scan.js') }}"></script>
</body>
</html>
