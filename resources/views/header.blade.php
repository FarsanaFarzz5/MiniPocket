<!-- resources/views/includes/header.blade.php -->

@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<div class="header">
  <div class="profile">
    <img src="{{ $user && $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}" alt="User Profile">
    <span>{{ $user ? ucfirst($user->first_name) : 'Guest' }}</span>
  </div>

  <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="App Logo">
  </div>
</div>
