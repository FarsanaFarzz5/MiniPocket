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

      <!-- ================================ -->
      <!-- 1️⃣ PARENT → KID TRANSACTIONS -->
      <!-- ================================ -->
      <h2 class="section-title">Money Sent to Kids</h2>

      @if($parentTransactions->isEmpty())
        <p class="no-data">No money transfers yet.</p>
      @else
        <div class="transaction-list">
          @foreach($parentTransactions as $txn)
            <div class="transaction-card">
              <div class="left">
                <img src="{{ $txn->kid && $txn->kid->profile_img 
                  ? asset('storage/'.$txn->kid->profile_img) 
                  : asset('images/default-profile.png') }}" alt="Kid Avatar">

                <div class="details">
                  <h4>{{ ucfirst($txn->kid->first_name ?? 'Unknown Kid') }}</h4>
                  <p>Sent to kid</p>
                </div>
              </div>

              <div class="right">
                <h4>₹{{ number_format($txn->amount, 2) }}</h4>
                <span>{{ $txn->created_at->format('d M Y') }}</span><br>
                <span class="type type-parent">Debit</span>
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <!-- ================================ -->
      <!-- 2️⃣ KID SPENDING / GOALS / GIFTS -->
      <!-- ================================ -->
      <h2 class="section-title">Kid Spending & Activities</h2>

      @if($kidTransactions->isEmpty())
        <p class="no-data">No kid activities yet.</p>
      @else
        <div class="transaction-list">
          @foreach($kidTransactions as $txn)
            <div class="transaction-card">
              
              <div class="left">
                <img src="{{ $txn->kid && $txn->kid->profile_img 
                  ? asset('storage/'.$txn->kid->profile_img) 
                  : asset('images/default-profile.png') }}" alt="Kid Avatar">

                <div class="details">
                  <h4>{{ ucfirst($txn->kid->first_name ?? 'Kid') }}</h4>

                  {{-- Description: choose sensible text per source (avoid default "spent for need" for kid_to_parent) --}}
                  <p>
                    @if($txn->source == 'kid_spending')
                        Spent for need
                    @elseif($txn->source == 'goal_payment')
                       {{ $txn->description ? ' ' . $txn->description : '' }}
                    @elseif($txn->source == 'gift_payment')
                        {{ $txn->description ? ' ' . $txn->description : '' }}
                    @elseif($txn->source == 'goal_saving')
                        Saved for goal{{ $txn->description ? '' . $txn->description : '' }}
                    @elseif($txn->source == 'gift_saving')
                        Saved for gift{{ $txn->description ? '' . $txn->description : '' }}
                    @elseif($txn->source == 'kid_to_parent')
                        Recieved by kid
                    @elseif($txn->source == 'parent_to_kid')
                        Received from parent
                    @else
                        {{ $txn->description ?? 'Activity' }}
                    @endif
                  </p>
                </div>
              </div>

              <div class="right">
                <h4>₹{{ number_format($txn->amount, 2) }}</h4>
                <span>{{ $txn->created_at->format('d M Y') }}</span><br>

                {{-- Type badge with classes for styling --}}
                {{-- Type badge with forced logic --}}
<span class="type
    @if($txn->source == 'kid_to_parent')
        type-credit       {{-- parent receives money --}}
    @elseif($txn->type == 'credit')
        type-credit
    @else
        type-debit
    @endif
">
    @if($txn->source == 'kid_to_parent')
        Credit
    @elseif($txn->type == 'credit')
        Credit
    @else
        Debit
    @endif
</span>


              </div>
            </div>
          @endforeach
        </div>
      @endif

    </div>
  </div>
</body>
</html>
