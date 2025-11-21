<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>🏆 Achievements – Mini Pocket</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Sidebar + Header -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">

  <style>

  /* ========== GLOBAL RESET ========== */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

html, body {
  width: 100%;
  height: 100%;
  background: #f2f2f2;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  overflow: hidden;
}

/* ================= CONTAINER ================= */
.container {
  width: 100%;
  max-width: 420px;
  height: 100dvh;
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  overflow: hidden;
}

.inner-container {
  flex: 1;
  width: 100%;
  overflow-y: auto;
  padding: 16px 20px 110px; /* bottom space for FAB */
  position: relative;
  z-index: 1;
}


/* PURE CLEAN PREMIUM HEADING */
.page-heading {
  width: 100%;
  text-align: center;
  margin: 10px 0 15px;
}

.page-heading h2 {

 
  text-transform: capitalize;
  position: relative;
  display: inline-block;
  padding-bottom: 6px;
      font-size: 22px;
    font-weight: 600;
    color: #1e293b;
    text-align: center;
    letter-spacing: 0.3px;
    margin-bottom: 20px;
    font-family: 'Poppins', sans-serif;
    
}

/* Nice underline highlight */
.page-heading h2::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 60%;
  height: 3px;
  background:  #23a541;
  transform: translateX(-50%);
  border-radius: 3px;
}


/* -------------------------------------------------------
   🎯 Premium Vertical Timeline Line
------------------------------------------------------- */
.timeline {
  position: relative;
  margin-top: 20px;
  padding-left: 30px;
}

.timeline::before {
  content: "";
  position: absolute;
  left: 13px;
  top: 0;
  width: 3px;
  height: 100%;
  background: linear-gradient(#e5e6ee, #dcdde7);
  border-radius: 20px;
}

/* -------------------------------------------------------
   🟦 Elegant Timeline Card
------------------------------------------------------- */
.item {
  position: relative;
  background: #fff;
  padding: 18px 18px;
  border-radius: 18px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.06);
  margin-bottom: 40px;
  border-left: 6px solid transparent;
  transition: 0.25s ease;
  margin-left: 20px;         /* reduced gap */
}

/* Dot closer to the card */
.dot {
  width: 18px;
  height: 18px;
  background: #fff;
  border: 4px solid #23a541;
  position: absolute;
  left: -50px;               /* closer to the card */
  top: 10%;                  /* perfect vertical center */
  transform: translateY(-50%);
  border-radius: 50%;
  box-shadow: 0 0 0 3px #fff;
  z-index: 5;
}

/* -------------------------------------------------------
   🟢 Category Badges (More professional)
------------------------------------------------------- */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 5px 12px;
  border-radius: 50px;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 8px;
  margin-left: -7px;
}

.goal-badge {
  border-color: #6FAF8C;
  background: rgba(111, 175, 140, 0.12);
  color: #2E6148;
}

.gift-badge {
  border-color: #6FAF8C;
  background: rgba(111, 175, 140, 0.12);
  color: #2E6148;
}

.refund-badge {
  border-color: #6FAF8C;
  background: rgba(111, 175, 140, 0.12);
  color: #2E6148;
}

/* -------------------------------------------------------
   📌 Card Content
------------------------------------------------------- */
.title {
  font-size: 16px;
  font-weight: 600;
  color: #2d2d2d;
}

.subtitle {
  font-size: 13px;
  color: #707070;
  margin-top: 4px;
}

.amount {
  margin-top: 8px;
  font-size: 18px;
  font-weight: 700;
  color: #23a541;
}

/* Empty Message */
.empty {
  color: #b4b4b4;
  font-size: 14px;
  margin: 12px 0;
  text-align: center;
}

  </style>
</head>

<body>

<div class="container">
  @include('sidebar.profile')
  

 

  <div class="inner-container">

@include('header')
    <div class="page-heading">
    <h2>My Achievements</h2>
</div>


    <div class="timeline">

      <!-- ------------------ PAID GOALS ------------------ -->
      <div class="section-title"></div>
@forelse($paidGoals as $goal)
    <div class="item">
      <div class="dot"></div>

      <span class="badge goal-badge">Paid Goal</span>

      <!-- Title -->
      <div class="title">{{ $goal->title }}</div>

      <!-- Completed message -->
      <div class="subtitle">Completed successfully</div>

   

      <!-- Date -->
      <div class="subtitle">
        {{ $goal->updated_at->format('d M Y, h:i A') }}
      </div>
    </div>
@empty
  <p class="empty">No paid goals yet.</p>
@endforelse


      <!-- ------------------ PAID GIFTS ------------------ -->
@forelse($paidGifts as $gift)
    <div class="item">
      <div class="dot"></div>

      <span class="badge gift-badge">Paid Gift</span>

      <!-- Title -->
      <div class="title">{{ $gift->title }}</div>

      <!-- Message -->
      <div class="subtitle">completed successfully</div>

      <!-- Date -->
      <div class="subtitle">
        {{ $gift->updated_at->format('d M Y, h:i A') }}
      </div>
    </div>
@empty
  <p class="empty">No paid gifts yet.</p>
@endforelse


@forelse($refunds as $refund)

    @php
        // Extract item name from description
        $itemName = str_replace(['Returned savings for goal:', 'Returned savings for gift:'], '', $refund->description);
        $itemName = trim($itemName);

        // Detect whether it was goal or gift refund
        $isGoal = str_contains($refund->description, 'Returned savings for goal:');
        $isGift = str_contains($refund->description, 'Returned savings for gift:');
    @endphp

    <div class="item">
        <div class="dot"></div>

        <span class="badge refund-badge">Money Returned</span>

        <!-- 1️⃣ Item Name -->
        <div class="title">
            {{ $itemName }}
        </div>

        <!-- 2️⃣ Returned savings line (NO item name here!) -->
        <div class="subtitle">
            @if($isGoal)
                Returned savings for goal
            @elseif($isGift)
                Returned savings for gift
            @endif
        </div>

        <!-- 3️⃣ Amount -->
        <div class="amount">
            ₹{{ number_format($refund->amount) }}
        </div>

        <!-- 4️⃣ Date -->
        <div class="subtitle">
            {{ $refund->created_at->format('d M Y, h:i A') }}
        </div>
    </div>

@empty
    <p class="empty">No money returned yet.</p>
@endforelse


    </div>
  </div>

</div>

</body>
</html>
