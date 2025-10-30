<!-- ✅ Font Awesome CDN -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

<!-- ===== Topbar + Sidebar ===== -->
<div class="topbar">
  <div class="hamburger" id="menuToggle">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="right-space"></div>
</div>

<!-- 🔳 Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ===== Sidebar ===== -->
<div class="sidebar" id="sidebarMenu">
  <ul>
    <!-- Dashboard -->
    <li>
      <a href="{{ route('dashboard.parent') }}">
        <i class="fa-solid fa-house"></i> Dashboard
      </a>
    </li>

    <!-- Edit Profile -->
    <li>
      <a href="{{ route('parent.editprofile') }}">
        <i class="fa-solid fa-user-gear"></i> Edit Profile
      </a>
    </li>

    <!-- Kid Dropdown -->
    <li class="dropdown">
      <div class="dropdown-btn">
        <i class="fa-solid fa-children"></i>
        <span>Kid</span>
        <i class="fa-solid fa-angle-down arrow"></i>
      </div>
      <ul class="dropdown-menu">
        <li>
          <a href="{{ route('parent.addkid') }}">
            <i class="fa-solid fa-user-plus"></i> Add Kid
          </a>
        </li>
        <li>
          <a href="{{ route('parent.kiddetails') }}">
            <i class="fa-solid fa-id-card-clip"></i> Kid Details
          </a>
        </li>
      </ul>
    </li>

    <!-- Transactions -->
    <li>
      <a href="{{ route('parent.transactions') }}">
        <i class="fa-solid fa-money-bill-transfer"></i> Transactions
      </a>
    </li>

    <!-- Logout -->
    <li>
      <a
        href="#"
        onclick="event.preventDefault(); document.getElementById('logoutForm').submit();"
      >
        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
      </a>
      <form
        id="logoutForm"
        action="{{ route('logout') }}"
        method="POST"
        style="display: none"
      >
        @csrf
      </form>
    </li>
  </ul>
</div>

<script src="{{ asset('assets/js/sidebar.js') }}"></script>