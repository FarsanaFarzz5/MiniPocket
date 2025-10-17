<!DOCTYPE html>
<html>
<head>
    <title>Parent Dashboard</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding: 20px; 
            background: #f9f9f9; 
        }
        h1 { color: #333; }

        .success { 
            color: green; 
            margin-bottom: 15px; 
            font-weight: bold;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #e3342f;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        .logout-btn:hover {
            background-color: #cc1f1a;
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0,0,0,0.15);
        }

        .add-profile-btn {
            padding: 10px 18px;
            background-color: #3490dc;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .add-profile-btn:hover {
            background-color: #2779bd;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .add-kid-btn {
            padding: 10px 20px;
            background-color: #38c172;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
            transition: all 0.3s ease;
        }
        .add-kid-btn:hover {
            background-color: #2fa360;
            transform: translateY(-2px);
        }

        #addKidForm, #addProfileForm {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        #addKidForm label, #addProfileForm label { 
            display: block; 
            margin-top: 10px; 
            font-weight: bold; 
        }
        #addKidForm input, #addKidForm select,
        #addProfileForm input, #addProfileForm select {
            width: 100%; 
            padding: 8px; 
            margin-top: 3px;
            border: 1px solid #ccc; 
            border-radius: 4px;
        }

        #addKidForm button, #addProfileForm button {
            margin-top: 15px; 
            padding: 10px; 
            background-color: #3490dc;
            color: #fff; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            width: 100%;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        #addKidForm button:hover, #addProfileForm button:hover {
            background-color: #2779bd;
            transform: translateY(-1px);
        }

        .kids-table, .transaction-table {
            margin-top: 30px; 
            border-collapse: collapse; 
            width: 100%;
            background: #fff; 
            border-radius: 6px; 
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .kids-table th, .kids-table td,
        .transaction-table th, .transaction-table td {
            border: 1px solid #ddd; 
            padding: 8px; 
            vertical-align: middle; 
            text-align: center;
        }
        .kids-table th, .transaction-table th { 
            background-color: #f4f4f4; 
            font-weight: bold; 
        }

        .invite-button {
            background-color: #6c5ce7;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .invite-button:hover { 
            background-color: #5a4ecb; 
            transform: translateY(-1px);
        }

        .profile-img { 
            width: 50px; 
            height: 50px; 
            object-fit: cover; 
            border-radius: 6px; 
        }

        .parent-profile {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            background: #fff; 
            padding: 20px; 
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .parent-profile img {
            width: 80px; 
            height: 80px; 
            object-fit: cover; 
            border-radius: 50%; 
            border: 2px solid #ccc;
        }

        .send-money-form input { 
            width: 80px; 
            padding: 4px; 
            margin-top: 5px; 
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .send-money-form button {
            padding: 6px 12px; 
            margin-top: 5px;
            background-color: #38c172; 
            color: #fff; 
            border: none;
            border-radius: 6px; 
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .send-money-form button:hover { 
            background-color: #2fa360; 
            transform: translateY(-1px);
        }

        .daily-limit-form input {
            width: 80px;
            padding: 4px;
            margin-right: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .daily-limit-form button {
            padding: 5px 10px;
            background-color: #ff9f43;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .daily-limit-form button:hover {
            background-color: #e58e26;
        }
    </style>
</head>
<body>

<h1>Welcome, {{ $user->first_name }}</h1>

<form method="POST" action="{{ route('logout') }}" style="display:inline;">
    @csrf
    <button type="submit" class="logout-btn">Logout</button>
</form>

@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif

{{-- Parent Profile Section --}}
<div class="parent-profile">
    @if($user->profile_img)
        <img src="{{ asset('storage/' . $user->profile_img) }}" alt="Profile Image">
    @else
        <img src="{{ asset('default-profile.png') }}" alt="Profile Image">
    @endif
    <div>
        <p><strong>First Name:</strong> {{ $user->first_name }}</p>
        <p><strong>Second Name:</strong> {{ $user->second_name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone_no ?? 'N/A' }}</p>
        <p><strong>DOB:</strong> {{ $user->dob ?? 'N/A' }}</p>
        <button class="add-profile-btn" onclick="toggleProfileForm()">Add / Update Profile</button>
    </div>
</div>

{{-- Edit Parent Profile Form --}}
<div id="addProfileForm">
    <form method="POST" action="{{ route('parent.add.profile') }}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="first_name" placeholder="First Name" value="{{ $user->first_name }}" required>
        <input type="text" name="second_name" placeholder="Second Name" value="{{ $user->second_name }}">
        <input type="email" name="email" placeholder="Email" value="{{ $user->email }}" required>
        <input type="text" name="phone_no" placeholder="Phone Number" value="{{ $user->phone_no }}">
        <input type="date" name="dob" placeholder="Date of Birth" value="{{ $user->dob }}">
        <input type="file" name="profile_img" accept="image/*">
        <button type="submit">Save Profile</button>
    </form>
</div>

{{-- Add Kid Button --}}
<button class="add-kid-btn" onclick="toggleKidForm()">+ Add Kid</button>

{{-- Add Kid Form --}}
<div id="addKidForm">
    <h3>Add Kid</h3>
    <form method="POST" action="{{ route('kids.store') }}" enctype="multipart/form-data">
        @csrf
        <label>First Name:</label>
        <input type="text" name="first_name" required>
        <label>Second Name:</label>
        <input type="text" name="second_name">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Phone Number:</label>
        <input type="text" name="phone_no">
        <label>Password:</label>
        <input type="password" name="password" required>
        <label>Confirm Password:</label>
        <input type="password" name="password_confirmation" required>
        <label>Date of Birth:</label>
        <input type="date" name="dob">
        <label>Gender:</label>
        <select name="gender">
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <label>Profile Image:</label>
        <input type="file" name="profile_img" accept="image/*">
        <button type="submit">Create Kid</button>
    </form>
</div>

{{-- Kids Table --}}
@if($children && $children->count() > 0)
    <h3>Your Kids</h3>
    <table class="kids-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Profile</th>
                <th>First Name</th>
                <th>Second Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Daily Limit (₹)</th>
                <th>Set Limit</th>
                <th>Invite</th>
                <th>Send Money</th>
            </tr>
        </thead>
        <tbody>
            @foreach($children as $index => $child)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($child->profile_img)
                            <img src="{{ asset('storage/' . $child->profile_img) }}" class="profile-img">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $child->first_name }}</td>
                    <td>{{ $child->second_name }}</td>
                    <td>{{ $child->email }}</td>
                    <td>{{ $child->phone_no ?? 'N/A' }}</td>
                    <td>{{ $child->dob ?? 'N/A' }}</td>
                    <td>{{ ucfirst($child->gender) ?? 'N/A' }}</td>
                    <td>₹{{ $child->daily_limit ?? 0 }}</td>
                    <td>
                        <form method="POST" action="{{ route('kids.set.limit', $child->id) }}" class="daily-limit-form">
                            @csrf
                            <input type="number" name="daily_limit" min="0" required>
                            <button type="submit">Set Limit</button>
                        </form>
                    </td>
                    <td>
                        <button type="button" class="invite-button" onclick="toggleInviteForm({{ $child->id }})">Invite Kid</button>
                        <form id="invite-form-{{ $child->id }}" style="display: none;" method="POST" action="{{ route('kids.resend.invite', $child->id) }}">
                            @csrf
                            <input type="email" name="email" value="{{ $child->email }}" readonly>
                            <button type="submit" class="invite-button">Send Invitation</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('parent.send.money') }}" class="send-money-form">
                            @csrf
                            <input type="hidden" name="kid_id" value="{{ $child->id }}">
                            <input type="number" name="amount" placeholder="Amount" min="1" step="0.01" required>
                            <button type="submit">Send Money</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- Transaction History --}}
@if(isset($transactions) && $transactions->count() > 0)
    <h3>Transaction History</h3>
    <table class="transaction-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Sent To</th>
                <th>Type</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $txn)
                <tr>
                    <td>{{ $txn->created_at->format('d-m-Y') }}</td>
                    <td>{{ $txn->created_at->format('h:i A') }}</td>
                    <td>{{ $txn->kid->first_name }}</td>
                    <td>{{ ucfirst($txn->type) }}</td>
                    <td>{{ number_format($txn->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<script>
    function toggleKidForm() {
        const form = document.getElementById('addKidForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
    function toggleInviteForm(kidId) {
        const form = document.getElementById('invite-form-' + kidId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
    function toggleProfileForm() {
        const form = document.getElementById('addProfileForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
</script>

</body>
</html>

