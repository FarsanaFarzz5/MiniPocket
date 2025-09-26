<!DOCTYPE html>
<html>
<head>
    <title>Parent Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .success { color: green; margin-bottom: 15px; }

        .logout-btn {
            padding: 8px 16px;
            background-color: #e3342f;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .logout-btn:hover { background-color: #cc1f1a; }

        .add-kid-btn {
            padding: 10px 20px;
            background-color: #3490dc;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-kid-btn:hover { background-color: #2779bd; }

        #addKidForm, #editParentForm {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            max-width: 400px;
        }

        #addKidForm label, #editParentForm label { display: block; margin-top: 10px; }

        #addKidForm input, #addKidForm select,
        #editParentForm input, #editParentForm select {
            width: 100%; padding: 8px; margin-top: 3px;
            border: 1px solid #ccc; border-radius: 4px;
        }

        #addKidForm button, #editParentForm button {
            margin-top: 15px; padding: 10px; background-color: #38c172;
            color: #fff; border: none; border-radius: 5px; cursor: pointer; width: 100%;
        }
        #addKidForm button:hover, #editParentForm button:hover { background-color: #2fa360; }

        .kids-table, .transaction-table {
            margin-top: 30px; border-collapse: collapse; width: 100%; max-width: 1000px;
        }
        .kids-table th, .kids-table td,
        .transaction-table th, .transaction-table td {
            border: 1px solid #ddd; padding: 8px; vertical-align: top;
        }
        .kids-table th, .transaction-table th { background-color: #f4f4f4; }

        .invite-button {
            background-color: #6c5ce7;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .invite-button:hover { background-color: #5a4ecb; }

        .invite-form input {
            padding: 5px;
            width: 250px;
            margin-right: 10px;
            margin-top: 5px;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Parent profile styles */
        .parent-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }
        .parent-profile img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ccc;
        }
        .add-profile-btn {
            padding: 6px 12px;
            background-color: #38c172;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .add-profile-btn:hover { background-color: #2fa360; }

        #addProfileForm {
            display: none;
            margin-top: 15px;
        }
        #addProfileForm input { margin-top: 5px; }

        /* send-money form */
        .send-money-form input {
            width: 100px;
            padding: 4px;
            margin-top: 5px;
        }
        .send-money-form button {
            padding: 5px 10px;
            margin-top: 5px;
            background-color: #38c172;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .send-money-form button:hover { background-color: #2fa360; }
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

<!-- Parent Profile Picture Section -->
<div class="parent-profile">
    @if($user->profile_img)
        <img src="{{ asset('storage/' . $user->profile_img) }}" alt="Profile Image">
    @else
        <img src="{{ asset('default-profile.png') }}" alt="Profile Image">
    @endif
    <div>
        <p>First Name: {{ $user->first_name }}</p>
        <p>Second Name: {{ $user->second_name ?? 'N/A' }}</p>
        <p>Email: {{ $user->email }}</p>
        <p>Phone: {{ $user->phone_no ?? 'N/A' }}</p>
        <p>DOB: {{ $user->dob ?? 'N/A' }}</p>
        <button class="add-profile-btn" onclick="toggleProfileForm()">Add / Update Profile</button>
    </div>
</div>

<!-- Edit Parent Profile Form -->
<div id="addProfileForm">
    <form method="POST" action="{{ route('parent.add.profile') }}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="first_name" placeholder="First Name" value="{{ $user->first_name }}" required>
        <input type="text" name="second_name" placeholder="Second Name" value="{{ $user->second_name }}">
        <input type="email" name="email" placeholder="Email" value="{{ $user->email }}" required>
        <input type="text" name="phone_no" placeholder="Phone Number" value="{{ $user->phone_no }}">
        <input type="date" name="dob" placeholder="Date of Birth" value="{{ $user->dob }}">
        <input type="file" name="profile_img" accept="image/*">
        <button type="submit" class="add-profile-btn">Save Profile</button>
    </form>
</div>

<button class="add-kid-btn" onclick="toggleKidForm()">+ Add Kid</button>

<div id="addKidForm" style="display:none;">
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

@if($user->children && $user->children->count() > 0)
    <h3 style="margin-top:30px;">Your Kids</h3>
    <table class="kids-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Profile</th>
                <th>First Name</th>
                <th>Second Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Invite</th>
                <th>Send Money</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user->children as $index => $child)
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
                    <td>{{ $child->phone_no }}</td>
                    <td>{{ $child->dob ?? 'N/A' }}</td>
                    <td>{{ ucfirst($child->gender) ?? 'N/A' }}</td>
                    <td>
                        <div>
                            <button type="button" class="invite-button" onclick="toggleInviteForm({{ $child->id }})">Invite Kid</button>
                            <form id="invite-form-{{ $child->id }}" class="invite-form" style="display: none;" method="POST" action="{{ route('kids.resend.invite', $child->id) }}">
                                @csrf
                                <input type="email" name="email" value="{{ $child->email }}" readonly />
                                <button type="submit" class="invite-button">Send Invitation</button>
                            </form>
                        </div>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('parent.send.money') }}" class="send-money-form">
                            @csrf
                            <input type="hidden" name="kid_id" value="{{ $child->id }}">
                            <input type="number" name="amount" placeholder="Amount" required>
                            <button type="submit">Send Money</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

{{-- ✅ Transaction History Table --}}
@if(isset($transactions) && $transactions->count() > 0)
    <h3 style="margin-top:40px;">Transaction History</h3>
    <table class="transaction-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
                <th>Type</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transactions as $txn)
            <tr>
                <td>{{ $txn->created_at->timezone('Asia/Kolkata')->format('d-m-Y') }}</td>
                <td>{{ $txn->created_at->timezone('Asia/Kolkata')->format('h:i A') }}</td>
                <td>{{ $txn->description ?? 'Sent to ' . $txn->kid->first_name }}</td>
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
