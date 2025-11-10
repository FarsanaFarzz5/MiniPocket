<link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">

<!-- ===== Footer Navigation ===== -->
<div class="footer-container">
  <nav class="footer-nav">

    <!-- 🏠 Home -->
    <a href="{{ route('dashboard.parent') }}" class="nav-item active">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="url(#grad)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <defs>
            <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#ff8a00"/>
              <stop offset="100%" stop-color="#ff5f00"/>
            </linearGradient>
          </defs>
          <path d="M3 9.5L12 3l9 6.5v10.5a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5z"/>
        </svg>
        <span>Home</span>
      </div>
    </a>

    <!-- 👧 Kids -->
    <div class="nav-item kids-item" id="kidsMenuToggle">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="url(#grad)" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="6" r="2.5"/>
          <path d="M10.5 6.8 Q12 7.7 13.5 6.8"/>
          <path d="M8 10 Q12 14 16 10"/>
          <path d="M6 11 L9 10 M15 10 L18 11"/>
          <path d="M10 21 V14 M14 21 V14"/>
        </svg>
        <span>Kids</span>
      </div>

      <!-- ✅ Submenu -->
      <div class="kids-submenu" id="kidsSubmenu">
        <a href="{{ route('parent.addkid') }}" class="submenu-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
               stroke="url(#grad)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="7" r="3"/>
            <path d="M5 21v-2a4 4 0 0 1 4-4h6a4 4 0 0 1 4 4v2"/>
            <line x1="12" y1="10" x2="12" y2="14"/>
            <line x1="10" y1="12" x2="14" y2="12"/>
          </svg>
          <span>Add Kid</span>
        </a>

        <a href="{{ route('parent.kiddetails') }}" class="submenu-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
               stroke="url(#grad)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="16" rx="2" ry="2"/>
            <line x1="9" y1="9" x2="15" y2="9"/>
            <line x1="9" y1="13" x2="15" y2="13"/>
          </svg>
          <span>Kid Details</span>
        </a>
      </div>
    </div>

    <!-- 🏦 Bank -->
    <a href="{{ route('parent.bankaccounts') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="url(#grad)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="7" width="20" height="13" rx="2" ry="2"/>
          <path d="M16 3H8l-6 4h20l-6-4z"/>
        </svg>
        <span>Bank</span>
      </div>
    </a>

    <!-- 💸 Transactions -->
    <a href="{{ route('parent.transactions') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="url(#grad)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 7h13l-3-3m3 3-3 3"/>
          <path d="M20 17H7l3 3m-3-3 3-3"/>
        </svg>
        <span>Transactions</span>
      </div>
    </a>

    <!-- 👤 Profile -->
    <a href="{{ route('parent.editprofile') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="url(#grad)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="7" r="4"/>
          <path d="M5 21c1.5-3.5 12.5-3.5 14 0"/>
        </svg>
        <span>Profile</span>
      </div>
    </a>

  </nav>
</div>

<script src="{{ asset('assets/js/sidebar.js') }}"></script>

