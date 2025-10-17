<!-- =======================
     KID SIDEBAR COMPONENT
     ======================= -->

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<div class="kid-sidebar" id="kidSidebarMenu">
  {{-- @dd($user) --}}
  <div class="kid-sidebar-header">
    <img src="{{ $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}"
         alt="Profile" class="kid-sidebar-avatar" />
    <h4>{{ ucfirst($user->first_name) }}</h4>
  </div>

  <ul class="kid-sidebar-links">
    <li><a href="{{ route('kid.dashboard') }}"><span>🏠</span> Dashboard</a></li>
    <li><a href="{{ route('kid.edit') }}"><span>✏️</span>Edit Profile</a></li>

    <li><a href="{{ route('kid.transactions') }}"><span>💰</span> My Transactions</a></li>
    <li><a href="#"><span>📈</span> Savings Goals</a></li>
    <li>
      <a href="#" onclick="event.preventDefault(); document.getElementById('logoutFormKid').submit();">
        <span>🚪</span> Logout
      </a>
    </li>
  </ul>

  <form id="logoutFormKid" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
  </form>
</div>

<!-- ===== JS for Sidebar Toggle ===== -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const kidProfileToggle = document.getElementById('kidProfileToggle');
    const kidSidebarMenu = document.getElementById('kidSidebarMenu');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (kidProfileToggle && kidSidebarMenu && sidebarOverlay) {
      kidProfileToggle.addEventListener('click', () => {
        kidSidebarMenu.classList.toggle('open');
        sidebarOverlay.classList.toggle('show');
      });

      sidebarOverlay.addEventListener('click', () => {
        kidSidebarMenu.classList.remove('open');
        sidebarOverlay.classList.remove('show');
      });

      document.addEventListener('click', (event) => {
        if (!kidSidebarMenu.contains(event.target) &&
            !kidProfileToggle.contains(event.target)) {
          kidSidebarMenu.classList.remove('open');
          sidebarOverlay.classList.remove('show');
        }
      });
    }
  });
</script>

<!-- ===== CSS Styling ===== -->
<style>
/* ===== Overlay (inside container) ===== */
.sidebar-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.35);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 8;
}
.sidebar-overlay.show {
  opacity: 1;
  visibility: visible;
}

/* ===== Sidebar ===== */
.kid-sidebar {
  position: absolute;
  top: 0;
  left: -250px;
  width: 220px;
  height: 100%;
  background: #ffffff;
  box-shadow: 3px 0 12px rgba(0, 0, 0, 0.08);
  transition: left 0.35s ease;
  padding-top: 70px;
  z-index: 10;
  font-family: 'Poppins', sans-serif;
}
.kid-sidebar.open {
  left: 0;
}

/* ===== Sidebar Header ===== */
.kid-sidebar-header {
  position: absolute;
  top: 20px;
  left: 0;
  width: 100%;
  text-align: center;
}
.kid-sidebar-avatar {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  border: 3px solid #23a541;
  object-fit: cover;
  margin-bottom: 6px;
}
.kid-sidebar-header h4 {
  font-size: 14px;
  color: #333;
  font-weight: 600;
  margin-top: -6px; 
}

/* ===== Sidebar Links ===== */
.kid-sidebar-links {
  list-style: none;
  padding-left: 25px;
  margin-top: 65px; /* 🔽 lowered the links slightly */
}
.kid-sidebar-links li {
  margin-bottom: 10px;
  position: relative;
  padding-bottom: 5px;
}
.kid-sidebar-links li:not(:last-child)::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 85%;
  height: 1px;
  background: #f0f0f0;
  border-radius: 2px;
}
.kid-sidebar-links a {
  text-decoration: none;
  color: #777;
  font-weight: 500;
  font-size: 13.5px;
  display: flex;
  align-items: center;
  gap: 10px;
  transition: all 0.3s ease;
  padding: 6px 0;
  letter-spacing: 0.2px;
}
.kid-sidebar-links a:hover {
  color: #23a541;
  transform: translateX(3px);
}
</style>
