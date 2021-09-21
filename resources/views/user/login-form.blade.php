<!DOCTYPE html>

<head>
    <title>Login to System</title>
    <link rel="stylesheet" href="assets/css/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100&display=swap" rel="stylesheet">
</head>

<body>
    <div>
        <h1>Welcome to OFL!</h1>
        <form class="box" method="POST" action="{{ route('user.postLogin') }}">
            @csrf
            <div class="form-header" style="margin-top: 30px;">
                <h2>Login</h2>
            </div>
            <div>
                <input type="text" name="username" placeholder="Username"> <br>
                <input type="password" name="password" placeholder="Password"> <br>
                @if (session('status'))
                <label class="text-validation">{{ session('status') }}</label>
                @endif
                <button type="submit">Log In</button>
                <a href="{{ route('user.signup') }}">Not have an account yet? Sign up here</a>
            </div>

        </form>
    </div>
</body>

</html>