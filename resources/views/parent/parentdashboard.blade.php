<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parent Dashboard - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no,email=no">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Font Awesome (CSS) -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      integrity="sha512-... (auto) ..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- External CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/parent.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="inner-container">
        @include('sidebar.sidebar')
         @include('headerparent')


      <!-- 👨‍👩‍👧 Parent Info -->
      <div class="content-section">
        <div class="parent-card">
          <div class="parent-avatar">
            <img src="{{ asset('images/parents.png') }}" alt="Parent Icon">
          </div>

          <div class="parent-details">
            <div class="parent-name">{{ ucfirst($user->first_name) }} {{ ucfirst($user->second_name ?? '') }}</div>
           <div class="bank-name">
  <i class="fas fa-building-columns"></i>
  <a href="{{ route('parent.bankaccounts') }}" style="text-decoration: none; color: inherit;">
    {{ $selectedBank ? $selectedBank->bank_name : 'No Bank Added' }} 
  </a>
</div>
            <div class="wallet-info">Wallet ID: <span>{{ $walletId ?? '----' }}</span></div>
            <div class="kids-linked" >Kids Linked: <span>{{ $kidsLinked ?? 0 }}</span></div>
          </div>
        </div>

        <!-- 💰 Add Money -->
        <div class="send-money-box">
          <a href="{{ route('parent.sendmoney.page') }}" class="btn" style="text-decoration: none;">Send Money</a>
        </div>

        <!-- 💳 Transaction Section -->
        <div class="transaction-section">
          <h3>Recent Transactions</h3>

          @if($transactions->isEmpty())
            <p class="no-data">No transactions yet.</p>
          @else
            <div class="transaction-list">
              @foreach($transactions->take(3) as $index => $txn)
                <div class="transaction-item">
                  <div class="left">
                    <span>{{ $index + 1 }}. {{ ucfirst($txn->kid->first_name ?? 'Unknown Kid') }}</span>
                    <span>Stationery store in Palakkad, Kerala</span>
                  </div>
                  <div class="right">
                    <span>₹{{ number_format($txn->amount, 2) }}</span>
                    <span>{{ $txn->created_at->format('d-m-Y') }}</span>
                  </div>
                </div>
              @endforeach

              <div class="all-transactions">
                <button onclick="window.location.href='{{ route('parent.transactions') }}'">
                  All Transactions
                </button>
              </div>
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>
</body>
</html>