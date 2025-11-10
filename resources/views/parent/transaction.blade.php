<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Parent Transactions - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Nunito:wght@600;700&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/transaction.css') }}">
</head>

<body>
  <div class="container">
    <div class="inner-container">

      @include('sidebar.sidebar')

      @include('headerparent')

      

      <h1>Transaction History</h1>

      @if($transactions->isEmpty())
        <p class="no-data">No transactions found yet.</p>
      @else
        <div class="transaction-list">
          @foreach($transactions as $txn)
            <div class="transaction-card">
              <div class="left">
                <img src="{{ $txn->kid && $txn->kid->profile_img 
                  ? asset('storage/'.$txn->kid->profile_img) 
                  : asset('images/default-profile.png') }}" alt="Kid Avatar">
                <div class="details">
                  <h4>{{ ucfirst($txn->kid->first_name ?? 'Unknown Kid') }}</h4>
                  <p>{{ $txn->description ?? 'Sent money to kid' }}</p>
                </div>
              </div>
              <div class="right">
                <h4>₹{{ number_format($txn->amount, 2) }}</h4>
                <span>{{ $txn->created_at->format('d M Y') }}</span><br>
                <span class="type">Debit</span>
              </div>
            </div>
          @endforeach
        </div>
      @endif

    </div>
  </div>
</body>
</html>
