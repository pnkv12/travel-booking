<!DOCTYPE html>
<html>

<head>
    <title>Login to System</title>
    <link rel="stylesheet" href="assets/css/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100&display=swap" rel="stylesheet">
</head>

<body>
    <div>
        <h1 style="color: #fda500;">VnGo Dashboard!</h1>
        <form class="box" method="POST" action="{{ route('user.postLogin') }}">
            @csrf
            <div class="form-header" style="margin-top: 30px;">
                <h2>Login</h2>
            </div>
            <div>
                <input type="text" name="username" placeholder="Username" autocomplete="off">
                @error('username')
                <div class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ $message }}</div>
                @enderror
                <br>
                <input type="password" name="password" placeholder="Password" autocomplete="off">
                @error('password')
                <div class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ $message }}</div>
                @enderror
                <br>
                @if (session('status'))
                <label class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ session('status') }}</label>
                @endif
                <button type="submit">Login</button>
                <p style="color: white; font-family: 'Open Sans', monospace;">Not have an account yet? <span><a href="{{ route('user.signup') }}">Sign up</a></span></p>
            </div>
        </form>
    </div>
</body>
<!-- include libs -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.min.js')}}"></script>
@yield('_js')
<script src="{{asset('assets/js/main.js')}}"></script>

</html>