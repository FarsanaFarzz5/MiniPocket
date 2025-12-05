<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Send Money - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="format-detection" content="telephone=no,email=no,address=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sendmoney.css') }}">
</head>

<body>
  <div class="container">
    <div class="inner-container">
      @include('sidebar.sidebar')

      <!-- ✅ Logo Section -->
      <div class="logo-section">
        <img src="{{ asset('images/logo.png') }}" alt="Mini Pocket Logo">
      </div>

      <!-- ✅ Heading -->
      <h1>Select a Kid to Send Money</h1>

      <!-- ✅ Search Box -->
      <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search kid by name...">
      </div>

      <!-- ✅ Kids List -->
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
                  <div class="gender">{{ ucfirst($child->gender ?? 'N/A') }}</div>
                </div>
              </div>

              <div class="amount-box">
                <div class="amount">₹{{ $child->daily_limit ?? 0 }}</div>
                <div class="limit-label">Daily Limit</div>
              </div>
            </a>
          @endforeach
        </div>
      @else
        <div class="empty-box">
    <div class="empty-title">Kids List</div>
    <div class="empty-msg">No kids found.</div>
</div>
      @endif
    </div>
  </div>

  <script src="{{ asset('assets/js/sendmoney.js') }}"></script>
</body>
</html>
