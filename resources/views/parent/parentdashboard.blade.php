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
     @include('sidebar.sidebar')

     <div class="inner-container">
       
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
@if($selectedBank)
    <a href="{{ route('parent.sendmoney.page') }}" class="btn" style="text-decoration:none;">Send Money</a>
@else
<a href="{{ route('parent.bankaccounts') }}" class="btn" style="text-decoration:none;">
    Add Bank to Send Money
</a>

@endif

</div>


<!-- ⭐ Kids Goals Section -->
<div class="kids-goals-section">

    @if($kidsGoals->count() == 0)

    <div class="empty-box">
        <h4 class="empty-title">Kids Goals</h4>
        <p class="empty-msg">No goals found.</p>
    </div>

    @else

    <h3>Kids Goals</h3>

    <div class="goals-scroll">
        @foreach($kidsGoals as $goal)
            @php
                $goalTitle = $goal->title ?? 'Unnamed';
                $isHidden  = $goal->is_hidden ?? 0;
            @endphp

            <div class="goal-card">
                <div class="goal-circle
                    @if($goal->status == 2) gold-badge
                    @elseif($goal->status == 1) bronze-badge
                    @else silver-badge @endif
                    @if($isHidden) hidden-blur @endif">

                    <i class="fa-solid fa-award @if($isHidden) hidden-icon @endif"></i>
                </div>

                <div class="goal-kid">{{ ucfirst($goal->kid->first_name) }}</div>

                <div class="goal-name
                    @if($goal->status == 2) text-gold
                    @elseif($goal->status == 1) text-bronze
                    @else text-silver @endif
                    @if($isHidden) hidden-text @endif">
                    {{ ucfirst($goalTitle) }}
                </div>
            </div>
        @endforeach
    </div>

    @endif
</div>

<!-- 💳 Recent Transactions Section -->
<div class="transaction-section">

    @if($transactions->isEmpty())

    <div class="empty-box">
        <h4 class="empty-title">Recent Transactions</h4>
        <p class="empty-msg">No transactions yet.</p>
    </div>

    @else

    <h3>Recent Transactions</h3>

    <div class="transaction-list">
        @foreach($transactions->take(2) as $index => $txn)

        <div class="transaction-item">

            <div class="left">
                <span>{{ $index + 1 }}. {{ ucfirst($txn->kid->first_name ?? 'Kid') }}</span>

                <span>
                    @if($txn->source == 'parent_to_kid') Sent money to kid
                    @elseif($txn->source == 'kid_spending') Kid spent money
                    @elseif($txn->source == 'goal_payment') Goal purchased
                    @elseif($txn->source == 'gift_payment') Gift purchased
                    @elseif($txn->source == 'kid_to_parent') Received by kid
                    @endif
                </span>
            </div>

            <div class="right">

                <span style="
                    color:
                        @if($txn->source == 'parent_to_kid') #23a541;
                        @elseif($txn->source == 'kid_spending') #ff7a00;
                        @elseif($txn->source == 'goal_payment') #ff7a00;
                        @elseif($txn->source == 'gift_payment') #ff7a00;
                        @endif
                ">
                    ₹{{ number_format($txn->amount, 2) }}
                </span>

                <span>{{ $txn->created_at->format('d-m-Y') }}</span>

            </div>

        </div>

        @endforeach

        <div class="all-transactions">
            <button onclick="window.location.href='{{ route('parent.transactions') }}'">All Transactions</button>
        </div>

    </div>

    @endif
</div>








      </div>

    </div>
  </div>
</body>
</html>