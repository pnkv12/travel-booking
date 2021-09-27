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
            @error('fullname')
            <div class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ $message }}</div>
            @enderror
            <input type="email" name="email" placeholder="Email">
            @error('email')
            <div class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ $message }}</div>
            @enderror
            <input type="text" name="username" placeholder="Username (6-12 characters)">
            @error('username')
            <div class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ $message }}</div>
            @enderror
            <input type="password" name="password" placeholder="Password at least 6 characters">
            @error('password')
            <div class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ $message }}</div>
            @enderror
            <input type="tel" name="phone" placeholder="Phone number">
            @error('phone')
            <div class="text-validation" style="font-family: Arial, Helvetica, sans-serif;">{{ $message }}</div>
            @enderror
            <button type="submit">Signup</button>
            <p style="color: white; font-family: 'Open Sans', monospace;">Already have one? <span><a href="{{ route('user.login') }}">Let's Login!</a></span></p>
            
        </form>
    </div>
</body>

</html>