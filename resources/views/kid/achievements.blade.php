<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>🏆 Achievements – Mini Pocket</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
<style>
:root {
  --green: #23a541;
  --green-soft: rgba(35, 165, 65, 0.10);
  --text-main: #1e293b;
  --text-subtle: #6b7280;
  --line: #e3e7ef;
  --card-bg: #ffffff;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body, html {
  width: 100%;
  height: 100%;
  background: #eef2f7;
  display: flex;
  justify-content: center;
  overflow: hidden;
}

.container {
  width: 100%;
  max-width: 420px;
  height: 100vh;
  background: #fff;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.inner-container {
  flex: 1;
  overflow-y: auto;
  padding: 16px 20px 110px;
  background: #fff;
}

/* ---------------------- */
/*       PAGE TITLE       */
/* ---------------------- */
/* ---------------------- */
/*       PAGE TITLE       */
/* ---------------------- */
.page-heading {
  text-align: center;
  margin: 18px 0 30px;
}

.page-heading h2 {
  font-size: 22px;
  font-weight: 600;
  color: var(--text-main);
  position: relative;
  display: inline-block;
  padding-bottom: 12px;
  letter-spacing: 0.5px;
}

.page-heading h2::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 50%;
  width: 110px;
  height: 3px;
  background: var(--green);
  transform: translateX(-50%);
  border-radius: 30px;
  opacity: 0.9;
}


/* ---------------------- */
/*        TIMELINE        */
/* ---------------------- */
.timeline {
  position: relative;
  padding-left: 30px;
  margin-top: 10px;
}

.timeline::before {
  content: "";
  position: absolute;
  left: 15px;
  top: 0;
  width: 3px;
  height: 100%;
  background: var(--line);
  border-radius: 10px;
}

/* ---------------------- */
/*         CARD           */
/* ---------------------- */
.item {
  background: var(--card-bg);
  padding: 18px 18px 20px;
  margin-bottom: 40px;
  margin-left: 22px;
  border-radius: 18px;
  box-shadow: 0 8px 25px rgba(15, 23, 42, 0.05);
  position: relative;
  border: 1px solid #f6f7fb;
  transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.item:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
}

/* timeline dot */
.dot {
  width: 18px;
  height: 18px;
  background: #fff;
  border: 4px solid var(--green);
  border-radius: 50%;
  position: absolute;
  left: -45px;
  top: 5%;
  transform: translateY(-50%);
  box-shadow: 0 0 0 3px #fff;
}

/* ---------------------- */
/*        BADGES          */
/* ---------------------- */
.badge {
  padding: 6px 14px;
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 10px;
  display: inline-block;
}

.badge {
  background: var(--green-soft);
  color: #25653e;
}

.gift-badge {
  background: var(--green-soft);
  color: #25653e;
}

.refund-badge {
  background: rgba(251, 146, 60, 0.18);
  color: #8a3600;
}

/* ---------------------- */
/* TEXT STYLING           */
/* ---------------------- */
.title {
  font-size: 16.5px;
  font-weight: 600;
  color: var(--text-main);
  letter-spacing: 0.2px;
}

.subtitle {
  font-size: 13px;
  color: var(--text-subtle);
  margin-top: 4px;
}

.amount {
  font-size: 18px;
  font-weight: 700;
  margin-top: 10px;
  color: var(--green);
}

/* EMPTY STATE */
.empty {
  text-align: center;
  color: #b6b6b6;
  font-size: 15px;
  margin-top: 25px;
  letter-spacing: 0.2px;
}

@media (max-width: 480px) {
  .inner-container {
    padding-bottom: 150px !important;
  }
}

/* ============================
   📦 Standard Empty Box Style
============================ */
.empty-box {
    width: 100%;
    background: #ffffff;
    border-radius: 14px;
    padding: 12px 18px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    margin: 0;
    text-align: left;
}

.empty-msg {
    font-size: 13px;
    font-weight: 500;
    color: #aaa;
    padding-left: 2px;
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

    {{-- EMPTY → NO TIMELINE --}}
    @if($allAchievements->isEmpty())
        <div class="empty-box">
      <p class="empty-msg">No achievements yet.</p>
  </div>

    {{-- NOT EMPTY → SHOW TIMELINE --}}
    @else
      <div class="timeline">
        @foreach($allAchievements as $item)

          <div class="item">
            <div class="dot"></div>

            {{-- GOAL --}}
            @if($item->type == 'goal')
              <span class="badge">Paid Goal</span>
              <div class="title">{{ $item->title }}</div>
              <div class="subtitle">Completed successfully</div>
              <div class="subtitle">{{ $item->date->format('d M Y, h:i A') }}</div>

            {{-- GIFT --}}
            @elseif($item->type == 'gift')
              <span class="badge gift-badge">Paid Gift</span>
              <div class="title">{{ $item->title }}</div>
              <div class="subtitle">Completed successfully</div>
              <div class="subtitle">{{ $item->date->format('d M Y, h:i A') }}</div>

            {{-- REFUND --}}
            @elseif($item->type == 'refund')
              @php
                $title = trim(str_replace(['Returned savings for goal:', 'Returned savings for gift:'], '', $item->description));
                $isGoal = str_contains($item->description, 'goal');
              @endphp

              <span class="badge refund-badge">Money Returned</span>
              <div class="title">{{ $title }}</div>

              <div class="subtitle">
                {{ $isGoal ? 'Returned savings for goal' : 'Returned savings for gift' }}
              </div>

              <div class="amount">₹{{ number_format($item->amount) }}</div>
              <div class="subtitle">{{ $item->date->format('d M Y, h:i A') }}</div>
            @endif
          </div>

        @endforeach
      </div>
    @endif

  </div>
</div>

</body>
</html>
