<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="public/css/styles-login.css">
    <title>Document</title>
</head>

<body>
    <div class="container" id="container">

        <div class="form-container register-container">
            <form action="#">
                <h1>Register here.</h1>
                <input type="text" placeholder="Name">
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password">
                <button>Register</button>
                <span>Or use you account</span>
                <div class="social-container">
                    <a href="#" class="social"><i class="lni lni-facebook-fill"></i></a>
                    <a href="#" class="social"><i class="lni lni-google"></i></a>
                    <a href="#" class="social"><i class="lni lni-linkedin-original"></i></a>
                </div>
            </form>
        </div>

        <div class="form-container login-container">
            <form action="#">
                <h1>Login here.</h1>
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Passsword">
                <div class="content">
                    <div class="checbox">
                        <input type="checkbox" name="checkbox" id="checbox">
                        <label>Remember me</label>
                    </div>
                    <div class="pasa-link">
                        <a href="#">Forgot password?</a>
                    </div>
                </div>
                <button>Login</button>
                <span>Or use you account</span>
                <div class="social-container">
                    <a href="#" class="social"><i class="lni lni-facebook-fill"></i></a>
                    <a href="#" class="social"><i class="lni lni-google"></i></a>
                    <a href="#" class="social"><i class="lni lni-linkedin-original"></i></a>
                </div>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="title">Hello <br> Friends</h1>
                    <p>If your have an account, login here and have fun</p>
                    <button class="ghost" id="login">Login
                        <i class="lni lni-arrow-left login"></i>
                    </button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="title">Start your <br> journy now</h1>
                    <p>If you don't have an account, join us and start your journey</p>
                    <button class="ghost" id="register">Register
                        <i class="lni lni-arrow-right login"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script src="public/js/scripts-login.js"></script>

</body>

</html>