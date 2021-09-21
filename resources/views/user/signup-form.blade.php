<!DOCTYPE html>

<head>
    <title>Signup to Admin System</title>
    <link rel="stylesheet" href="assets/css/login-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@100&display=swap" rel="stylesheet">

</head>

<body>
    <div>
        <form class="box" action="{{ route('user.confirmSignUp') }}" method="POST">
            <div class="form-header" style="margin-top: 30px;">
                <h2>Let's start!</h2>
            </div>
            @csrf
            <input type="text" name="fullname" placeholder="Your full name...">
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="username" placeholder="Username about 6-12 characters">
            <input type="password" name="password" placeholder="Password min 6 characters">
            <input type="tel" name="phone" placeholder="Phone number">
            <input type="hidden" name="is_new" value="0">

            <button type="submit">Signup</button>
            <a href="{{ route('user.login') }}">Already have an account? Let's Login!</a>
        </form>
    </div>
</body>

</html>