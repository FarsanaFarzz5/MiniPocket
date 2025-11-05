<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add New Gift</title>

  <!-- ✅ Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    * { box-sizing: border-box; }

    body {
      min-height: 100vh;
      margin: 0;
      background: linear-gradient(145deg, #fffefb, #f8fff9);
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
      padding: 1.5rem;
    }

    .gift-container {
      width: 100%;
      max-width: 420px;
      background: #fff;
      border-radius: 26px;
      box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      transition: all 0.3s ease;
      animation: fadeIn 0.5s ease;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(15px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* 🧡 Header */
    .gift-header {
      background: linear-gradient(135deg, #ff8a00, #ffb347);
      color: #fff;
      text-align: center;
      padding: 1.6rem 1.2rem;
      font-size: 1.3rem;
      font-weight: 600;
      letter-spacing: 0.4px;
      border-radius: 26px 26px 0 0;
      position: relative;
      box-shadow: 0 4px 12px rgba(255, 140, 0, 0.25);
    }

    .gift-header i {
      font-size: 1.4rem;
      margin-right: 6px;
      vertical-align: middle;
    }

    /* 💳 Form Section */
    .gift-form-card {
      padding: 2rem 1.8rem 1.8rem;
    }

    label {
      font-weight: 500;
      color: #333;
      font-size: 0.9rem;
      margin-bottom: 0.4rem;
      display: block;
    }

    .input-group {
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 1.4rem;
    }

    .input-group-text {
      background: #fff8f0;
      color: #ff8a00;
      border: none;
      font-size: 1.2rem;
    }

    .form-control {
      border: none;
      padding: 12px 14px;
      font-size: 0.95rem;
      
      background: #fff;
    }

    .form-control:focus {
      box-shadow: 0 0 0 3px rgba(255,138,0,0.25);
      outline: none;
    }

    /* ✨ Buttons */
/* ✨ Buttons */
.btn-save, .btn-cancel {
  background: linear-gradient(135deg, #ff9966, #ff5e62);
  color: #fff;
  border: none;
  border-radius: 10px;
  font-weight: 600;
  padding: 12px 0;
  font-size: 1rem;
  width: 50%;
  transition: all 0.3s ease;
 
}

.btn-save:hover, .btn-cancel:hover {
  transform: translateY(-2px);
  
}


 
    .btn-row {
      display: flex;
      justify-content: space-between;
      gap: 1rem;
      margin-top: 1.2rem;
    }

    .btn-row button {
      width: 50%;
    }

    /* 📱 Mobile Responsive */
    @media (max-width: 480px) {
      html, body {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .gift-container {
        height: auto;
        margin: auto;
        border-radius: 18px;
        
      }

      .gift-form-card {
        padding: 1.5rem 1.3rem 1.5rem;
      }

      .btn-row {
        flex-direction: row; /* ✅ Keep side-by-side */
        gap: 0.8rem;
      }

      .btn-row button {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="gift-container">
    <div class="gift-header">
      <i class="bi bi-gift-fill"></i> Add New Gift
    </div>

    <div class="gift-form-card">
      <form action="{{ route('kid.gifts.store') }}" method="POST">
        @csrf

        <!-- Gift Title -->
        <label for="gift-title">Gift Title</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-box2-heart"></i></span>
          <input type="text" id="gift-title" name="title" class="form-control" placeholder="e.g. Headphones" required>
        </div>

        <!-- Target Amount -->
        <label for="gift-amount">Target Amount (₹)</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
          <input type="number" id="gift-amount" name="target_amount" class="form-control" placeholder="Enter amount" min="1" required>
        </div>

        <!-- Buttons -->
        <div class="btn-row">
          <button type="submit" class="btn-save">Save Gift</button>

            
          <button type="button" class="btn-cancel" onclick="window.history.back()">

             Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
