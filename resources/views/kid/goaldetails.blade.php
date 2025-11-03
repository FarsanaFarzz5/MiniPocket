<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{ $goal->title }} – Mini Pocket</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* ===========================================================
   🌿 GLOBAL RESET + BASE THEME
=========================================================== */
* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

html, body {
  width:100%;
  height:100%;
  background:#fff;
  display:flex;
  justify-content:center;
  align-items:flex-start;
  overflow-x:hidden;
  -webkit-overflow-scrolling:touch;
}

/* ===========================================================
   📦 MAIN CONTAINER — Matches Edit Kid Layout
=========================================================== */
.container {
  width:100%;
  max-width:420px;
  min-height:100dvh; /* dynamic mobile safe height */
  background:#ffffff;
  box-shadow:0 6px 20px rgba(0,0,0,0.08);
  border-radius:0;
  padding:24px 20px 40px;
  display:flex;
  flex-direction:column;
  align-items:stretch;
  overflow-y:auto;
  -webkit-overflow-scrolling:touch;
  position:relative;
}

/* ===========================================================
   🏷 HEADER
=========================================================== */
.header {
  text-align:center;
  margin-bottom:22px;
}
.header h1 {
  font-size:20px;
  font-weight:700;
  background:linear-gradient(90deg,#059669,#10b981);
  -webkit-background-clip:text;
  -webkit-text-fill-color:transparent;
}

/* ===========================================================
   💰 GOAL INFO
=========================================================== */
.goal-info {
  background:linear-gradient(145deg,#ffffff 0%,#dcfce7 100%);
  border-radius:18px;
  box-shadow:inset 0 0 0 1px rgba(16,185,129,0.15);
  padding:16px 18px;
  margin-bottom:20px;
}
.goal-item {
  display:flex;
  justify-content:space-between;
  align-items:center;
  border-bottom:1px solid #e2e8f0;
  padding:10px 0;
}
.goal-item:last-child{border:none;}
.goal-left {
  display:flex;
  align-items:center;
  gap:8px;
}
.goal-left .num {
  background:#10b981;
  color:#fff;
  font-weight:600;
  font-size:12px;
  width:22px; height:22px;
  border-radius:50%;
  display:flex;
  justify-content:center;
  align-items:center;
}
.goal-left .label {
  font-size:14px;
  font-weight:600;
  color:#065f46;
}
.goal-right { text-align:right; }
.goal-right p {
  margin:0;
  font-size:13px;
  font-weight:600;
  color:#047857;
}
.goal-right .target { color:#64748b; }

/* ===========================================================
   📊 PROGRESS
=========================================================== */
.progress-container { margin-top:15px; }
.progress-label {
  font-size:13px;
  color:#064e3b;
  font-weight:600;
  margin-bottom:6px;
}
.progress-bar {
  width:100%;
  height:10px;
  border-radius:6px;
  background:#e2e8f0;
  overflow:hidden;
  position:relative;
}
.progress-bar::after {
  content:"";
  position:absolute;
  left:0; top:0;
  height:100%;
  width:calc({{ $progress }}%);
  background:linear-gradient(90deg,#10b981,#059669);
  transition:width 0.5s ease;
}
.progress-text {
  text-align:right;
  font-size:12.5px;
  margin-top:4px;
  color:#047857;
  font-weight:600;
}

/* ===========================================================
   ➕ ADD AMOUNT FORM
=========================================================== */
.add-form {
  display:flex;
  gap:10px;
  margin-top:18px;
}
.add-form input[type="number"] {
  flex:1;
  padding:10px 12px;
  border-radius:10px;
  border:1.5px solid #a7f3d0;
  font-size:13px;
  transition:all 0.3s;
}
.add-form input:focus {
  border-color:#10b981;
  box-shadow:0 0 0 3px rgba(16,185,129,0.2);
  outline:none;
}
.add-form button {
  padding:10px 16px;
  border:none;
  border-radius:10px;
  background:linear-gradient(90deg,#059669,#10b981);
  color:#fff;
  font-weight:600;
  font-size:13px;
  cursor:pointer;
  box-shadow:0 4px 10px rgba(16,185,129,0.3);
  transition:transform 0.2s ease;
}
.add-form button:hover { transform:translateY(-2px); }

/* ===========================================================
   💳 PAY NOW BUTTON
=========================================================== */
.pay-btn {
  display:block;
  width:100%;
  background:linear-gradient(90deg,#16a34a,#059669);
  color:#fff;
  font-weight:600;
  text-align:center;
  padding:12px 0;
  border-radius:12px;
  font-size:14px;
  margin-top:18px;
  text-decoration:none;
  box-shadow:0 4px 12px rgba(16,185,129,0.3);
  transition:transform 0.2s, box-shadow 0.3s;
}
.pay-btn:hover {
  transform:translateY(-2px);
  box-shadow:0 6px 16px rgba(16,185,129,0.4);
}

/* ===========================================================
   🧾 SAVING HISTORY
=========================================================== */
.history {
  margin-top:30px;
  background:linear-gradient(145deg,#f0fdf4,#ffffff);
  border-radius:16px;
  padding:16px 18px;
  box-shadow:0 3px 10px rgba(0,0,0,0.05), inset 0 0 0 1px #d1fae5;
}
.history h4 {
  font-size:15px;
  font-weight:700;
  color:#065f46;
  text-align:center;
  margin-bottom:14px;
}
.history ul { list-style:none; margin:0; padding:0; }
.history li {
  display:flex;
  justify-content:space-between;
  align-items:center;
  background:#ffffff;
  border-radius:10px;
  padding:10px 14px;
  margin-bottom:10px;
  box-shadow:0 1px 4px rgba(0,0,0,0.04);
  transition:all 0.2s ease;
}
.history li:hover {
  background:#f0fdf4;
  transform:translateY(-2px);
}
.history li span {
  font-size:12.5px;
  color:#6b7280;
}
.history li strong {
  font-size:13.5px;
  color:#047857;
}

.history .empty {
  text-align:left;       /* left-align like normal list items */
  padding-left:12px;     /* ✅ slight right shift for alignment */
  color:#9ca3af;
  font-size:13px;
  font-weight:500;
  padding-top:10px;
  padding-bottom:10px;
}


/* ===========================================================
   📱 RESPONSIVE
=========================================================== */
@media(max-width:420px){
  html,body{align-items:flex-start;}
  .container{
    padding:20px 16px 40px;
    border-radius:0;
    min-height:100svh;
  }
  .goal-item{flex-direction:column;align-items:flex-start;gap:4px;}
  .goal-right{text-align:left;width:100%;}
  .add-form{flex-direction:column;}
  .add-form button{width:100%;}
}
</style>
</head>

<body>
<div class="container">
  <div class="header"><h1>{{ $goal->title }}</h1></div>

  <div class="goal-info">
    <div class="goal-item">
      <div class="goal-left"><span class="num">1</span><span class="label">Target Amount</span></div>
      <div class="goal-right"><p class="target">₹{{ number_format($goal->target_amount,2) }}</p></div>
    </div>
    <div class="goal-item">
      <div class="goal-left"><span class="num">2</span><span class="label">Saved Amount</span></div>
      <div class="goal-right"><p>₹{{ number_format($goal->saved_amount,2) }}</p></div>
    </div>
  </div>

  <div class="progress-container">
    <p class="progress-label">Goal Progress</p>
    <div class="progress-bar"></div>
    <p class="progress-text">{{ $progress }}% completed</p>
  </div>

  @if($progress < 100)
  <form action="{{ route('goals.addSavings', $goal->id) }}" method="POST" class="add-form">
    @csrf
    <input type="number" name="saved_amount" min="1" placeholder="Enter amount to add" required>
    <button type="submit">Add</button>
  </form>
  @else
  <a href="{{ route('kid.scanqr') }}" class="pay-btn">Pay Now</a>
  @endif

  <div class="history">
    <h4>Saving History</h4>
    <ul>
      @forelse($goal->savings as $saving)
        <li>
          <strong>₹{{ number_format($saving->saved_amount,2) }}</strong>
          <span>{{ $saving->created_at->format('d M, Y') }}</span>
        </li>
      @empty
        <li class="empty" > No savings yet.</li>
      @endforelse
    </ul>
  </div>
</div>
</body>
</html>
