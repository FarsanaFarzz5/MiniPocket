<!DOCTYPE html>
<html>
<head>
    <title>Parent Register</title>
    <style>
        /* Reset some default styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
        }

        .container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        form input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        form input:focus {
            border-color: #6a11cb;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #6a11cb;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #2575fc;
        }

        .errors {
            background: #ffe0e0;
            color: #c00;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .errors div {
            margin-bottom: 5px;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #6a11cb;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .login-link:hover {
            color: #2575fc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Parent Register</h1>

        @if($errors->any())
            <div class="errors">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
            <input type="text" name="second_name" placeholder="Second Name" value="{{ old('second_name') }}">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            <input type="text" name="phone_no" placeholder="Phone" value="{{ old('phone_no') }}">
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="password_confirmation" placeholder="Confirm Password">
            <button type="submit">Register</button>
        </form>

        <a href="{{ route('login.form') }}" class="login-link">Already have an account? Login</a>
    </div>
</body>
</html>
