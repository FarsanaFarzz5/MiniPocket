<!DOCTYPE html>
<html>
<head>
    <title>Kid Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 40px;
            background: #f9f9f9;
        }

        .dashboard-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4CAF50;
            margin-bottom: 15px;
        }

        .welcome {
            font-size: 26px;
            margin-bottom: 10px;
            color: #333;
        }

        .details-list {
            text-align: left;
            margin-top: 15px;
        }

        .details-list p {
            margin: 6px 0;
            color: #444;
        }

        .label {
            font-weight: bold;
            color: #333;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .edit-btn {
            background-color: #2196F3;
            color: white;
        }

        .edit-btn:hover {
            background-color: #1976D2;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            margin-top: 15px;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        .section {
            margin-top: 30px;
            text-align: left;
        }

        .section h3 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        /* Edit form modal */
        .edit-form-container {
            display: none;
            margin-top: 20px;
            background: #f1f1f1;
            padding: 20px;
            border-radius: 10px;
            text-align: left;
        }

        .edit-form-container input,
        .edit-form-container select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .edit-form-container button {
            margin-top: 15px;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-form-container button:hover {
            background: #45a049;
        }

        .profile-img-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-top: 10px;
        }

        .send-money-form {
            margin-top: 20px;
            background: #f1f1f1;
            padding: 15px;
            border-radius: 10px;
        }

        .send-money-form input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .send-money-form button {
            margin-top: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .send-money-form button:hover {
            background: #45a049;
        }

        /* Transaction table */
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .transaction-table th,
        .transaction-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .transaction-table th {
            background-color: #4CAF50;
            color: white;
        }

        .transaction-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .transaction-table tr:hover {
            background-color: #f1f1f1;
        }
    </style>
    <script>
        function toggleEditForm() {
            const form = document.getElementById('editForm');
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</head>
<body>

<div class="dashboard-container">

    {{-- Profile Picture --}}
    @if(!empty($user->profile_img))
        <img src="{{ asset('storage/' . $user->profile_img) }}" alt="Profile Picture" class="profile-picture">
    @else
        <img src="https://via.placeholder.com/120x120.png?text=Kid" alt="Default Profile" class="profile-picture">
    @endif

    <h1 class="welcome">Welcome, {{ $user->first_name }}!</h1>

    {{-- Edit Profile Button --}}
    <button class="btn edit-btn" onclick="toggleEditForm()">Edit Profile</button>

    {{-- Details --}}
    <div class="details-list">
        <p><span class="label">First Name:</span> {{ $user->first_name }}</p>
        <p><span class="label">Second Name:</span> {{ $user->second_name ?? 'N/A' }}</p>
        <p><span class="label">Email:</span> {{ $user->email }}</p>
        <p><span class="label">Phone:</span> {{ $user->phone_no ?? 'N/A' }}</p>
        <p><span class="label">Date of Birth:</span> {{ $user->dob ?? 'N/A' }}</p>
        <p><span class="label">Gender:</span> {{ $user->gender ? ucfirst($user->gender) : 'N/A' }}</p>
    </div>

    {{-- Logout Button --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn logout-btn">Logout</button>
    </form>

    {{-- Wallet Section --}}
    <div class="section">
        <h3>Your Wallet</h3>
        <p><strong>Total Received:</strong> ₹{{ number_format($receivedMoney, 2) }}</p>
        <p><strong>Total Spent:</strong> ₹{{ number_format($sentMoney, 2) }}</p>
        <p><strong>Balance:</strong> ₹{{ number_format($balance, 2) }}</p>
    </div>

    {{-- Transaction Bill Details Section --}}
    <div class="section">
        <h3>Transaction Bill Details</h3>
        @if($transactions->isEmpty())
            <p>No transactions yet.</p>
        @else
            <table class="transaction-table">
    <thead>
        <tr>
            <th>Date</th>       {{-- 🆕 just date --}}
            <th>Time</th>       {{-- 🆕 new column --}}
            <th>Description</th>
            <th>Type</th>
            <th>Amount (₹)</th>
        </tr>
    </thead>
    <tbody>
@foreach ($transactions as $transaction)
    <tr>
        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
        <td>{{ $transaction->created_at->format('h:i:s') }}</td>
        <td>{{ $transaction->description }}</td>
        <td>{{ $transaction->type }}</td>
        <td>{{ $transaction->amount }}</td>
    </tr>
@endforeach
    </tbody>
</table>
        @endif
    </div>

    {{-- Send Money Section --}}
    <div class="send-money-form">
        <h3>Pay Amount</h3>
        <form action="{{ route('kid.send.money') }}" method="POST">
            @csrf
            <label>Amount (₹):</label>
            <input type="number" name="amount" min="1" required step="0.01">
            <label>Description:</label>
            <input type="text" name="description" placeholder="Reason / Note" required>
            <button type="submit">Pay</button>
        </form>
    </div>

    {{-- Kid Activities Section --}}
    <div class="section">
        <h3>Your Kid Activities</h3>
        <p>Here you can see your tasks, progress, or any assigned activities.</p>
    </div>

    {{-- Edit Form --}}
    <div class="edit-form-container" id="editForm">
        <h3>Edit Profile</h3>
        <form action="{{ route('kid.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>First Name:</label>
            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>

            <label>Second Name:</label>
            <input type="text" name="second_name" value="{{ old('second_name', $user->second_name) }}">

            <label>Phone Number:</label>
            <input type="text" name="phone_no" value="{{ old('phone_no', $user->phone_no) }}">

            <label>Date of Birth:</label>
            <input type="date" name="dob" value="{{ old('dob', $user->dob) }}">

            <label>Gender:</label>
            <select name="gender">
                <option value="">Select</option>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
            </select>

            <label>Profile Image:</label>
            <input type="file" name="profile_img" accept="image/*">
            @if($user->profile_img)
                <img src="{{ asset('storage/' . $user->profile_img) }}" class="profile-img-preview" alt="Profile Image">
            @endif

            <button type="submit">Update Profile</button>
        </form>
    </div>

</div>

</body>
</html>
