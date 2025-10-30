<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bank Accounts - Mini Pocket</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="{{ asset('assets/css/bankaccounts.css') }}">
 
</head>

<body>
  <div class="container">
   
<div class="page-header">
  <div class="header-inline">
   <div class="back-btn" onclick="window.location.href='{{ route('dashboard.parent') }}'">

      <i class="fa-solid fa-arrow-left"></i>
    </div>
    <h1>Payment Methods</h1>
    <div class="spacer"></div>
  </div>
</div>


    <div class="bank-list">
      @forelse($accounts as $account)
        @php
          $bankMap = [
              'hdfc bank' => 'hdfc.png',
              'canara bank' => 'canara.png',
              'sbi bank' => 'sbi.png',
              'axis bank' => 'axis.png',
              'icici bank' => 'icici.png',
              'kotak bank' => 'kotak.png'
          ];
          $key = strtolower(trim($account->bank_name));
          $bankFile = $bankMap[$key] ?? 'kotak.png';
        @endphp

        <div class="bank-card {{ session('active_bank_account') == $account->id ? 'active' : '' }}"
             onclick="confirmPrimary('{{ route('parent.select.bank', $account->id) }}')">
          <div class="bank-left">
            <img src="{{ asset('images/' . $bankFile) }}" alt="{{ $account->bank_name }}">
            <div class="bank-info">
              <h4>{{ $account->bank_name }}</h4>
             
              <p class="card-mask">
  Card No: <span>••••  {{ substr($account->card_number, -4) }}</span>
</p>

            </div>
          </div>

          @if(session('active_bank_account') == $account->id)
            <span class="status-tag">Primary Account</span>
          @endif
        </div>
      @empty
        <p style="text-align:center; color:#999;">No bank accounts added yet.</p>
      @endforelse
    </div>

    <div class="add-bank-shortcut" onclick="toggleBankGrid()">
      <i class="fa-solid fa-building-columns"></i> Add Bank Account
    </div>

    <div id="bankGrid">

            <div class="bank-option" onclick="goToAddBank('HDFC Bank')">
        <img src="{{ asset('images/hdfc.png') }}" alt="HDFC Bank">
        <span>HDFC Bank</span>
      </div>
     
     
     
        <div class="bank-option" onclick="goToAddBank('ICICI Bank')">
        <img src="{{ asset('images/icici.png') }}" alt="ICICI Bank">
        <span>ICICI Bank</span>
      </div>
     <div class="bank-option" onclick="goToAddBank('Canara Bank')">
        <img src="{{ asset('images/canara.png') }}" alt="Canara Bank">
        <span>Canara Bank</span>
      </div>
       <div class="bank-option" onclick="goToAddBank('Axis Bank')">
        <img src="{{ asset('images/axis.png') }}" alt="Axis Bank">
        <span>Axis Bank</span>
      </div>
    
          <div class="bank-option" onclick="goToAddBank('SBI Bank')">
        <img src="{{ asset('images/sbi.png') }}" alt="SBI Bank">
        <span>SBI Bank</span>
      </div>
     
       <div class="bank-option" onclick="goToAddBank('Kotak Bank')">
        <img src="{{ asset('images/kotak.png') }}" alt="Kotak Bank">
        <span>Kotak Bank</span>
      </div>
    
 
    </div>

    <form id="addForm" action="{{ route('parent.add.bank') }}" method="POST" style="display:none;">
      @csrf
      <input type="hidden" id="bank_name" name="bank_name" required>
      <input type="hidden" name="account_number" value="0000000000">
      <input type="hidden" name="ifsc_code" value="XXXX000000">
      <input type="hidden" name="branch_name" value="Main Branch">
    </form>
  </div>

  <div class="popup-overlay" id="popup">
    <div class="popup-box">
      <h3>Set this as your Primary Account?</h3>
      <div class="popup-btns">
        <button class="yes-btn" id="yesBtn">Yes</button>
        <button class="no-btn" id="noBtn">No</button>

      </div>
    </div>
  </div>

<script src="{{ asset('assets/js/bankaccounts.js') }}"></script>



</body>
</html>
