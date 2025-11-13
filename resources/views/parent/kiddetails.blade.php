<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kid Details - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no,email=no,address=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kiddetails.css') }}">
</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')
        @include('headerparent')

        <!-- ✅ Toggle Switch -->
<div class="toggle-wrapper">
  <a href="{{ route('parent.addkid') }}" 
     class="toggle-btn {{ request()->routeIs('parent.addkid') ? 'active' : '' }}">
    Add Kid
  </a>
  <a href="{{ route('parent.kiddetails') }}" 
     class="toggle-btn {{ request()->routeIs('parent.kiddetails') ? 'active' : '' }}">
    Kid Details
  </a>
</div>


     
      <!-- ✅ Heading -->
      <h1>{{ $user->first_name }}’s Kids</h1>

      @if($children->count() > 0)
        @foreach($children as $index => $child)
          <!-- ✅ Kid Card -->
          <div class="kid-card" data-index="{{ $index }}">
            <div class="kid-left">
              @if($child->profile_img)
                <img src="{{ asset('storage/' . $child->profile_img) }}" alt="{{ $child->first_name }}">
              @else
                <img src="{{ asset('images/default-profile.png') }}" alt="Profile">
              @endif
              <div class="kid-info">
                <div class="name">{{ ucfirst($child->first_name) }}</div>
                <div class="gender">{{ ucfirst($child->gender ?? 'N/A') }}</div>
              </div>
            </div>

            <div class="amount-box">
              <div class="amount">₹{{ $child->daily_limit ?? 0 }}</div>
              <div class="limit-label">Money Limit</div>
            </div>
          </div>

          <!-- ✅ Kid Details Box -->
          <div class="details" id="details-{{ $index }}">
            <p><strong>Name:</strong> {{ $child->first_name }} {{ $child->second_name ?? '' }}</p>
            <p><strong>Email:</strong> {{ $child->email }}</p>
            <p><strong>Phone:</strong> {{ $child->phone_no ?? 'N/A' }}</p>
            <p><strong>Date of Birth:</strong> {{ $child->dob ?? 'N/A' }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($child->gender ?? 'N/A') }}</p>
            <p class="balance-line"><strong>Balance:</strong> ₹{{ $child->balance ?? 0 }}</p>

            <form method="POST" action="{{ route('kids.set.limit', $child->id) }}">
              @csrf
              <input type="number" name="daily_limit" min="0" placeholder="Enter new limit" required class="input-box">
              <button type="submit" class="btn">Set Limit</button>
            </form>
          </div>
        @endforeach
      @else
        <p class="empty">No kids added yet.</p>
      @endif

    </div>
  </div>

  
<script src="{{ asset('assets/js/kiddetails.js') }}"></script>
</body>
</html>
