<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
            display: block;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Login</h1>

    {{-- Show error messages --}}
    @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    {{-- Login form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    {{-- Show register link only for parent login (role=1) --}}
    @if(isset($role) && $role == 1)
        <a class="register-link" href="{{ route('register.form', ['role' => 1]) }}">
            Don’t have an account? Register here
        </a>
    @endif

</div>

</body>
</html>
