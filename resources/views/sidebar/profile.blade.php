<link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">

<!-- ✅ Font Awesome CDN -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<div class="kid-sidebar" id="kidSidebarMenu">
  <div class="kid-sidebar-header">
    <img
      src="{{ $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}"
      alt="Profile"
      class="kid-sidebar-avatar"
    />
    <h4>{{ ucfirst($user->first_name) }}</h4>
  </div>

  <ul class="kid-sidebar-links">
<li>
  <a href="{{ route('kid.dashboard') }}">
    <i class="fa-solid fa-house"></i> Dashboard
  </a>
</li>
<li>
  <a href="{{ route('kid.edit') }}">
    <i class="fa-solid fa-pen-to-square"></i> Edit Profile
  </a>
</li>
<li>
  <a href="{{ route('kid.transactions') }}">
    <i class="fa-solid fa-wallet"></i> My Transactions
  </a>
</li>
<li>
  <a href="{{ route('kid.goals') }}">
    <i class="fa-solid fa-bullseye"></i> My Goals
  </a>
</li>

    <li>
      <a href="{{ route('kid.gifts') }}">
        <i class="fa-solid fa-gift"></i> My Gifts
      </a>
    </li>


<li>
  <a href="#" onclick="event.preventDefault(); document.getElementById('logoutFormKid').submit();">
    <i class="fa-solid fa-right-from-bracket"></i> Logout
  </a>
</li>

  </ul>

  <form id="logoutFormKid" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
  </form>
</div>

<script src="{{ asset('assets/js/profile.js') }}"></script>

