<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Send Money - Mini Pocket</title>
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
    overflow: hidden; /* ✅ Prevent background scroll gap */
  }

  /* ========================= BODY ========================= */
  body {
    display: flex;
    justify-content: center;
    align-items: stretch;
    height: 100dvh; /* ✅ Full dynamic viewport height */
  }

  /* ========================= CONTAINER ========================= */
  .container {
    width: 100%;
    max-width: 420px;
    height: 100dvh;
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

  /* ========================= HEADING ========================= */
  h3 {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 22px;
    text-transform: capitalize;
  }

  /* ========================= SEARCH BOX ========================= */
  .search-box {
    width: 100%;
    margin-bottom: 18px;
  }

  .search-box input {
    width: 100%;
    height: 46px;
    padding: 0 14px;
    border: 1px solid #e7e7e7;
    border-radius: 10px;
    font-size: 14px;
    color: #222;
    background: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
  }

  .search-box input::placeholder {
    color: #bfbfbf;
  }

  .search-box input:focus {
    border-color: #f4731d;
    outline: none;
    box-shadow: 0 0 0 3px rgba(244,115,29,0.15);
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
    color: #000;
    text-decoration: none;
  }

  .kid-card:hover {
    background: #fafafa;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    transform: translateY(-2px);
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

  /* ========================= EMPTY TEXT ========================= */
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

    h3 {
      font-size: 15px;
      margin-bottom: 18px;
    }

    .search-box input {
      height: 44px;
      font-size: 13px;
    }

    .kid-card {
      padding: 10px 12px;
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
      <h3>Select a Kid to Send Money</h3>

      <!-- Search -->
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search kid by name...">
      </div>

      <!-- Kids List -->
      @if($children->count() > 0)
        <div id="kidList">
          @foreach($children as $child)
            @php
              $img = asset('images/default-profile.png');
              if (!empty($child->profile_img)) {
                  if (\Illuminate\Support\Str::startsWith($child->profile_img, 'profile_images/')) {
                      $img = asset('storage/' . $child->profile_img);
                  } elseif (\Illuminate\Support\Str::startsWith($child->profile_img, 'storage/')) {
                      $img = asset($child->profile_img);
                  } elseif (\Illuminate\Support\Str::startsWith($child->profile_img, ['http', 'https'])) {
                      $img = $child->profile_img;
                  } else {
                      $img = asset($child->profile_img);
                  }
              }
            @endphp

            <a href="{{ route('parent.pay.kid.page', $child->id) }}" class="kid-card">
              <div class="kid-left">
                <img src="{{ $img }}" alt="{{ $child->first_name }}">
                <div class="kid-info">
                  <div class="name">{{ ucfirst($child->first_name) }}</div>
                  <div class="gender">{{ ucfirst($child->gender) }}</div>
                </div>
              </div>
              <div class="amount">₹{{ $child->daily_limit ?? 0 }}</div>
            </a>
          @endforeach
        </div>
      @else
        <p class="empty">No kids found.</p>
      @endif
    </div>
  </div>

  <script>
    const searchInput = document.getElementById('searchInput');
    const kidList = document.getElementById('kidList');
    searchInput.addEventListener('keyup', function() {
      const filter = this.value.toLowerCase();
      const kids = kidList.getElementsByClassName('kid-card');
      Array.from(kids).forEach(kid => {
        const name = kid.textContent.toLowerCase();
        kid.style.display = name.includes(filter) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
