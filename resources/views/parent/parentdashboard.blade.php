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
          <a href="{{ route('parent.sendmoney.page') }}" class="btn" style="text-decoration: none;">Send Money</a>
        </div>

<!-- ⭐ Kids Goals Section -->
<div class="kids-goals-section">
    <h3>Kids Goals</h3>

    <div class="goals-scroll">

       @forelse($kidsGoals as $goal)

    @php
        $goalTitle = $goal->title ?? 'Unnamed';
        $isHidden = $goal->is_hidden ?? 0;
    @endphp

    <!-- 🔥 CASE 1: HIDDEN GOAL (still blurred GOLD circle) -->
    @if($isHidden == 1 && $goal->status != 2)

        <div class="goal-card">
            <div class="goal-circle hidden-blur"></div>

            <div class="goal-kid">{{ ucfirst($goal->kid->first_name) }}</div>

            <div class="goal-name blurred-text">{{ ucfirst($goalTitle) }}</div>
        </div>

    @else

        <!-- ⭐ NORMAL GOAL -->
        <div class="goal-card">

            <div class="goal-circle
                @if($goal->status == 2)
                    gold-badge   <!-- ⭐ PAID → GOLD -->
                @else
                    silver-badge <!-- 🥈 COMPLETED/PROGRESS → SILVER -->
                @endif
            ">
                <i class="fa-solid fa-award"></i>
            </div>

            <div class="goal-kid">{{ ucfirst($goal->kid->first_name) }}</div>
            <div class="goal-name">{{ ucfirst($goalTitle) }}</div>

        </div>

    @endif

@empty
    <p class="no-goals">No goals found.</p>
@endforelse

    </div>
</div>



<!-- 💳 Transaction Section -->
<div class="transaction-section">
  <h3>Recent Transactions</h3>

  @if($transactions->isEmpty())
    <p class="no-data">No transactions yet.</p>
  @else
    <div class="transaction-list">

      @foreach($transactions->take(2) as $index => $txn)
        <div class="transaction-item">

          <div class="left">
            <span>
              {{ $index + 1 }}. {{ ucfirst($txn->kid->first_name ?? 'Kid') }}
            </span>

            <!-- DESCRIPTION -->
            <span>
              @if($txn->source == 'parent_to_kid')
                Sent money to kid
              @elseif($txn->source == 'kid_spending')
                Kid spent money
              @elseif($txn->source == 'goal_payment')
                Goal purchased
              @elseif($txn->source == 'gift_payment')
                Gift purchased
              @endif
            </span>
          </div>

          <div class="right">

            <!-- AMOUNT -->
            <span
              style="
                color:
                  @if($txn->source == 'parent_to_kid') #23a541;
                  @elseif($txn->source == 'kid_spending') #ff7a00;
                  @elseif($txn->source == 'goal_payment') #ff7a00;
                  @elseif($txn->source == 'gift_payment') #ff7a00;
                  @endif
              "
            >
              ₹{{ number_format($txn->amount, 2) }}
            </span>

            <!-- DATE -->
            <span>
              {{ $txn->created_at->format('d-m-Y') }}
            </span>

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