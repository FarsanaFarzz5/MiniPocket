<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Mini Pocket - Kid Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="{{asset('assets/css/kiddashboard.css')}}">


</head>

<body>
  <div class="container">
    <div class="inner-container">
       @include('sidebar.profile')
      <!-- Header -->
      <div class="header">
        <div class="profile">
          <img id="kidProfileToggle" src="{{ $user->profile_img ? asset('storage/'.$user->profile_img) : asset('images/default-avatar.png') }}" alt="Profile" />
          <span>{{ ucfirst($user->first_name) }}</span>
        </div>
        <div class="logo">
          <img src="{{ asset('images/moneylogo.jpg') }}" alt="Mini Pocket Logo" />
        </div>
      </div>

      <!-- Orange Card -->
      <div class="orange-card">
        <img src="{{ asset('images/kid sitting.png') }}" class="kid-image" alt="Kid Illustration" />
        <div class="content">
          <h3>Hi,</h3>
          <h3><span>{{ ucfirst($user->first_name) }}</span></h3>
          <div class="balance-box">
            <p>Your Balance</p>
            <h2>₹{{ number_format($balance ?? 0, 0) }}</h2>
          </div>
        </div>
      </div>

<!-- Green QR Section -->
<a href="{{ route('kid.scanqr') }}" style="text-decoration: none;">
  <div class="qr-section">
    <div class="qr-left">
      <img src="{{ asset('images/scan.png') }}" alt="Scan QR" />
    </div>
    <div class="qr-right">
      <h4>Scan QR Code</h4>
      <p>Send Money</p>
    </div>
  </div>
</a>

      <!-- Footer Card -->
      <div class="footer-card">
        <div class="footer-text">
          Little savings today,<br>big dreams tomorrow.
        </div>
        <img src="{{ asset('images/pig.png') }}" alt="Piggy Bank" />
      </div>

      <!-- ✅ Transaction Section (won’t affect any card sizes) -->
<div style="
  width:100%;
  margin-top:26px;
  text-align:left;
  display:block;
  box-sizing:border-box;
">
  <h3 style="font-size:15px;font-weight:600;color:#333;margin-bottom:10px;">Recent Transactions</h3>
  @if($transactions->isEmpty())
    <p style="text-align:center;color:#aaa;font-size:13px;">No transactions yet.</p>
  @else
    <div style="background:#fff;border-radius:14px;box-shadow:0 4px 10px rgba(0,0,0,0.05);padding:14px;width:100%;box-sizing:border-box;">
      @foreach($transactions->take(2) as $txn)
        <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:8px 0;border-bottom:1px solid #eee;">
          <div>
            <span style="display:block;font-size:14px;font-weight:600;color:#333;">
              {{ ucfirst($txn->description ?? 'Transaction') }}
            </span>
            <span style="display:block;font-size:12px;color:#777;">
              {{ $txn->type == 'credit' ? 'Received from Parent' : 'Payment Made' }}
            </span>
          </div>
          <div style="text-align:right;">
            <span style="display:block;font-size:14px;font-weight:600;color:{{ $txn->type == 'credit' ? '#23a541' : '#e53935' }}">
              {{ $txn->type == 'credit' ? '+' : '-' }}₹{{ number_format($txn->amount, 2) }}
            </span>
            <span style="display:block;font-size:12px;color:#999;">{{ $txn->created_at->format('d-m-Y') }}</span>
          </div>
        </div>
      @endforeach

      <div style="text-align:center;margin-top:12px;">
        <button onclick="window.location.href='{{ route('kid.transactions') }}'"
                style="width:100%;background:#f4f4f4;border:none;color:#333;font-size:14px;
                       font-weight:600;padding:12px 0;border-radius:10px;cursor:pointer;
                       box-shadow:0 3px 6px rgba(0,0,0,0.05);transition:all 0.3s ease;">
          All Transactions
        </button>
      </div>
    </div>
  @endif
</div>

    </div>
  </div>

  
</body>
</html>
