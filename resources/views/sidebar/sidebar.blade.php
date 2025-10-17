<!-- ===== Topbar + Sidebar ===== -->
<div class="topbar">
  <div class="hamburger" id="menuToggle">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="right-space"></div>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebarMenu">
  <ul>
    <li><a href="{{ route('dashboard.parent') }}">🏠 Dashboard</a></li>
    
    <!-- ✏️ Edit Profile -->
    <li><a href="{{ route('parent.editprofile') }}">✏️ Edit Profile</a></li>

    <!-- Kid Dropdown -->
    <li class="dropdown">
      <div class="dropdown-btn">
        👦 Kid
        <span class="arrow">&#9662;</span>
      </div>
      <ul class="dropdown-menu">
        <li><a href="{{ route('parent.addkid') }}">➕ Add Kid</a></li>
        <li><a href="{{ route('parent.kiddetails') }}">📋 Kid Details</a></li>
      </ul>
    </li>

    <li><a href="{{ route('parent.transactions') }}">💰 Transactions</a></li>

    <!-- 🚪 Logout -->
    <li>
      <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
        🚪 Logout
      </a>
      <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
      </form>
    </li>
  </ul>
</div>

<!-- JavaScript -->
<script>
  const menuToggle = document.getElementById("menuToggle");
  const sidebarMenu = document.getElementById("sidebarMenu");

  menuToggle.addEventListener("click", () => {
    menuToggle.classList.toggle("active");
    sidebarMenu.classList.toggle("open");
  });

  // Dropdown toggle
  document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const parent = btn.parentElement;
      parent.classList.toggle('open');
    });
  });
</script>