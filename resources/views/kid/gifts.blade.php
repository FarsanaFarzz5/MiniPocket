<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>🎁 My Gift Savings</title>

  <!-- ✅ Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    .card {
      border: none;
      border-radius: 15px;
      transition: transform 0.2s ease;
    }

    .card:hover {
      transform: scale(1.02);
    }

    .progress {
      height: 10px;
      border-radius: 10px;
    }

    .progress-bar {
      transition: width 0.5s ease-in-out;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #0d6efd;
    }

    .btn-primary {
      background-color: #0d6efd;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
    }

    .btn-success {
      background-color: #198754;
      border: none;
    }

    .btn-success:hover {
      background-color: #157347;
    }
  </style>
</head>
<body>
  <div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center text-primary">🎁 My Gift Savings</h2>

    <!-- ✅ Success / Error Messages -->
    @if(session('success'))
      <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger text-center">
        {{ $errors->first() }}
      </div>
    @endif

    <!-- ✅ Add Gift Form -->
    <div class="card p-4 mb-5 shadow-sm">
      <form action="{{ route('kid.gifts.store') }}" method="POST">
        @csrf
        <div class="row g-3 align-items-center">
          <div class="col-md-5">
            <input 
              type="text" 
              name="title" 
              class="form-control" 
              placeholder="🎀 Gift Title" 
              required
            >
          </div>
          <div class="col-md-5">
            <input 
              type="number" 
              name="target_amount" 
              class="form-control" 
              placeholder="🎯 Target Amount (₹)" 
              required
              min="1"
            >
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Add</button>
          </div>
        </div>
      </form>
    </div>

    <!-- ✅ Gift List -->
    <div class="row">
      @forelse($gifts as $gift)
        @php
          $progress = $gift->target_amount > 0 
            ? min(($gift->saved_amount / $gift->target_amount) * 100, 100)
            : 0;
        @endphp

        <div class="col-md-4 mb-4">
          <div class="card text-center shadow-sm p-4">
            <h5 class="fw-bold text-secondary">{{ ucfirst($gift->title) }}</h5>

            <p class="mb-2 text-muted">
              Saved: <strong>₹{{ number_format($gift->saved_amount, 2) }}</strong> 
              / ₹{{ number_format($gift->target_amount, 2) }}
            </p>

            <!-- ✅ Progress Bar -->
            <div class="progress mb-3">
              <div 
                class="progress-bar bg-success" 
                role="progressbar" 
                style="width: {{ $progress }}%;" 
                aria-valuenow="{{ $progress }}" 
                aria-valuemin="0" 
                aria-valuemax="100">
              </div>
            </div>

            <!-- ✅ Add Saving Form -->
            @if($gift->saved_amount < $gift->target_amount)
              <form 
                action="{{ route('kid.gifts.add') }}" 
                method="POST" 
                class="d-flex justify-content-center"
              >
                @csrf
                <input type="hidden" name="gift_id" value="{{ $gift->id }}">
                <input 
                  type="number" 
                  name="amount" 
                  class="form-control w-50 me-2" 
                  placeholder="Add ₹" 
                  min="1" 
                  max="{{ $gift->target_amount - $gift->saved_amount }}"
                  required
                >
                <button type="submit" class="btn btn-success">Save</button>
              </form>
            @else
              <p class="text-success fw-bold mt-2 mb-0">🎉 Goal Reached!</p>
            @endif
          </div>
        </div>

      @empty
        <div class="col-12 text-center">
          <p class="text-muted mt-3">No gifts added yet. Start saving for something special!</p>
        </div>
      @endforelse
    </div>
  </div>

  <!-- ✅ Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
