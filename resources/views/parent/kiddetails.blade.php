<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kid Details - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

  <style>
  /* ========================= GLOBAL RESET ========================= */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  html, body {
    width: 100%;
    height: 100%;
    background: #f2f2f2;
    overflow: hidden; /* ✅ prevent any scroll gap */
  }

  /* ========================= BODY ========================= */
  body {
    display: flex;
    justify-content: center;
    align-items: stretch; /* ✅ fills full height */
    height: 100dvh; /* ✅ dynamic viewport height for all devices */
  }

  /* ========================= CONTAINER ========================= */
  .container {
    width: 100%;
    max-width: 420px;
    height: 100dvh; /* ✅ fill viewport exactly */
    background: #fff;
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    padding: 20px 24px 40px;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-y: auto;
    position: relative;
  }

  .inner-container {
    width: 100%;
    text-align: center;
    flex-grow: 1;
  }

  /* ========================= LOGO SECTION ========================= */
  .logo-section {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 8px;
    margin-bottom: 10px;
  }

  .logo-section img {
    width: 75px;
    height: auto;
    display: block;
    margin: 0 auto;
    filter: brightness(1.1) saturate(1.1);
    transition: transform 0.3s ease;
  }

  .logo-section img:hover {
    transform: scale(1.05);
  }

  /* ========================= PAGE HEADING ========================= */
  h1 {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 22px;
    text-transform: capitalize;
  }

  /* ========================= KID CARD ========================= */
  .kid-card {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 14px;
    border: 1px solid #e7e7e7;
    border-radius: 10px;
    background: #fbfbfb;
    margin-bottom: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  .kid-card:hover {
    background: #fafafa;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
  }

  .kid-left {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .kid-left img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #00c853;
    box-shadow: 0 0 6px rgba(0,200,83,0.25);
  }

  .kid-info {
    text-align: left;
    line-height: 1.3;
  }

  .kid-info .name {
    font-weight: 600;
    font-size: 13.5px;
    color: #2c3e50;
  }

  .kid-info .gender {
    font-size: 11.5px;
    color: #8c8c8c;
  }

  .amount {
    font-weight: 700;
    color: #000;
    font-size: 13.5px;
    white-space: nowrap;
  }

  /* ========================= DETAILS BOX ========================= */
  .details {
    background: #fff;
    border-radius: 12px;
    padding: 16px;
    width: 100%;
    margin-bottom: 16px;
    text-align: left;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    display: none;
    animation: fadeIn 0.3s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .details p {
    font-size: 13px;
    color: #444;
    margin-bottom: 6px;
  }

  /* ========================= INPUT ========================= */
  .input-box {
    width: 100%;
    height: 48px;
    padding: 0 14px;
    border: 1px solid #e7e7e7;
    border-radius: 10px;
    font-size: 14px;
    background: #fff;
    color: #222;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .input-box:focus {
    border-color: #f4731d;
    box-shadow: 0 0 0 3px rgba(244,115,29,0.15);
    outline: none;
  }

  /* ========================= BUTTON ========================= */
  .btn {
    display: block;
    width: 100%;
    padding: 13px 0;
    background: #f4731d;
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 12px;
    box-shadow: 0 5px 10px rgba(244,115,29,0.3);
    transition: all 0.3s ease;
  }

  .btn:hover {
    background: #e25f00;
    transform: translateY(-2px);
  }

  /* ========================= EMPTY STATE ========================= */
  .empty {
    color: #aaa;
    font-size: 13.5px;
    text-align: center;
    margin-top: 30px;
  }

  /* ========================= RESPONSIVE ========================= */
  @media (max-width: 430px) {
    .container {
      padding: 16px;
      height: 100dvh;
    }
    .logo-section img {
      width: 65px;
    }
    h1 {
      font-size: 15px;
      margin-bottom: 18px;
    }
    .kid-card {
      padding: 10px 12px;
    }
    .btn {
      font-size: 14px;
      padding: 11px 0;
    }
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')

      <!-- Logo -->
      <div class="logo-section">
        <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo">
      </div>

      <!-- Heading -->
      <h1>{{ $user->first_name }}’s Kids</h1>

      @if($children->count() > 0)
        @foreach($children as $index => $child)
          <div class="kid-card" onclick="toggleDetails({{ $index }})">
            <div class="kid-left">
              @if($child->profile_img)
                <img src="{{ asset('storage/' . $child->profile_img) }}" alt="{{ $child->first_name }}">
              @else
                <img src="{{ asset('images/default-profile.png') }}" alt="Profile">
              @endif
              <div class="kid-info">
                <div class="name">{{ ucfirst($child->first_name) }}</div>
                <div class="gender">{{ ucfirst($child->gender) ?? 'N/A' }}</div>
              </div>
            </div>
            <div class="amount">₹{{ $child->daily_limit ?? 0 }}</div>
          </div>

          <div class="details" id="details-{{ $index }}">
            <p><strong>Full Name:</strong> {{ $child->first_name }} {{ $child->second_name ?? '' }}</p>
            <p><strong>Email:</strong> {{ $child->email }}</p>
            <p><strong>Phone:</strong> {{ $child->phone_no ?? 'N/A' }}</p>
            <p><strong>Date of Birth:</strong> {{ $child->dob ?? 'N/A' }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($child->gender) ?? 'N/A' }}</p>

            <form method="POST" action="{{ route('kids.set.limit', $child->id) }}">
              @csrf
              <input type="number" name="daily_limit" min="0" placeholder="Enter new limit" required class="input-box">
              <button type="submit" class="btn">Set Limit</button>
            </form>
          </div>
        @endforeach
      @else
        <p class="empty">No kids added yet.</p>
      @endif

    </div>
  </div>

  <script>
    function toggleDetails(index) {
      const clicked = document.getElementById('details-' + index);
      const isVisible = clicked.style.display === 'block';
      document.querySelectorAll('.details').forEach(d => d.style.display = 'none');
      if (!isVisible) clicked.style.display = 'block';
    }
  </script>
</body>
</html>
