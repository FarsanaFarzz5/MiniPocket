<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">

<div class="footer-container">
  <nav class="footer-nav">

    <!-- 🏠 Home -->
    <a href="{{ route('kid.dashboard') }}" class="nav-item active">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="#23a541" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9.5L12 3l9 6.5v10.5a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5z"/>
        </svg>
        <span>Home</span>
      </div>
    </a>

    <!-- 🎯 Goals -->
    <a href="{{ route('kid.goals') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="#23a541" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/>
          <path d="M12 6v6l4 2"/>
        </svg>
        <span>Goals</span>
      </div>
    </a>

    <!-- 🏅 Reward -->
    <a href="{{ route('kid.achievements') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="#23a541" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="8" r="4"/>
          <path d="M8.5 12.5L7 22l5-3 5 3-1.5-9.5"/>
        </svg>
        <span>Reward</span>
      </div>
    </a>

    <!-- 💸 Transactions -->
    <a href="{{ route('kid.transactions') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="#23a541" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 7h13l-3-3m3 3-3 3"/>
          <path d="M20 17H7l3 3m-3-3 3-3"/>
        </svg>
        <span>Transactions</span>
      </div>
    </a>

    <!-- 👤 Profile -->
    <a href="{{ route('kid.edit') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="#23a541" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="7" r="4"/>
          <path d="M5 21c1.5-3.5 12.5-3.5 14 0"/>
        </svg>
        <span>Profile</span>
      </div>
    </a>

  </nav>
</div>
