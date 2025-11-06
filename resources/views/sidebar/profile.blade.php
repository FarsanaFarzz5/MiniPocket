<!-- ===== KID FOOTER NAVIGATION ===== -->
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

        <!-- 🎁 Gifts (Updated Icon) -->
    <a href="{{ route('kid.gifts') }}" class="nav-item">
      <div class="icon-wrapper">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
             stroke="#23a541" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="7" width="20" height="15" rx="2" ry="2"/>
          <path d="M12 7V22"/>
          <path d="M2 12h20"/>
          <path d="M12 7c0-2 2-4 4-4s2 2 0 4h-4zM12 7c0-2-2-4-4-4s-2 2 0 4h4z"/>
        </svg>
        <span>Gifts</span>
      </div>
    </a>

    <!-- 🎯 Goals (Updated Icon) -->
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

<!-- ===== CSS (same as yours) ===== -->
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: "Poppins", sans-serif; background: #fff; overflow-x: hidden; }

/* ===== Footer ===== */
.footer-container {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  max-width: 420px;
  z-index: 500;
}

/* Footer Nav */
.footer-nav {
  background: #ffffff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 0 6px;
  border-top: 1px solid #e0f3e6;
  box-shadow: 0 -3px 10px rgba(35, 165, 65, 0.08);
  border-radius: 12px 12px 0 0;
  transition: all 0.3s ease;
}

/* Nav Items */
.nav-item {
  flex: 1;
  text-align: center;
  text-decoration: none;
  position: relative;
}

.icon-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px ;
}

.icon-wrapper span {
  font-size: 11px;
  font-weight: 500;
  color: #7b8a7b;
  transition: color 0.3s ease;
}

/* SVG Icon Effects */
.nav-item svg {
  opacity: 0.9;
  transition: transform 0.25s ease, filter 0.25s ease;
  filter: drop-shadow(0 0 1px rgba(35, 165, 65, 0.2));
}

/* Active + Hover */
.nav-item.active .icon-wrapper span,
.nav-item:hover .icon-wrapper span {
  color: #23a541;
}

.nav-item.active svg,
.nav-item:hover svg {
  transform: scale(1.12);
  filter: drop-shadow(0 0 3px rgba(35, 165, 65, 0.3));
}



/* Responsive */
@media (max-width: 480px) {
  .footer-nav { padding: 10px 0 5px; }
  .nav-item svg { width: 24px; height: 24px; }
  .icon-wrapper span { font-size: 10.5px; }
}
</style>
