<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DC325182 Che Chi Hin</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="#">
                <h2>Join Us</h2>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>Use your email to sign up</span>
                <input type="text" placeholder="Full Name" required />
                <input type="email" placeholder="Email" required />
                <input type="password" placeholder="Create Password" required />
                <button type="submit">REGISTER</button>
            </form>
        </div>

        <div class="form-container sign-in-container">
            <form action="#">
                <h2>Log In</h2>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>Use your account to sign in</span>
                <input type="email" placeholder="Email" required />
                <input type="password" placeholder="Password" required />
                <a href="#">Forgot Password?</a>
                <button type="submit">SIGN IN</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h2>Hello , Again!</h2>
                    <img src="images/website_7376495.png" alt="Profile Icon" class="illustration">
                    <p>Log in to stay connected with us</p>
                    <button class="ghost" id="signIn">SIGN IN</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h2>Welcome!</h2>
                    <img src="images/unsecure_10399884.png" alt="Envelope Icon" class="illustration">
                    <p>Enter your details to start your journey</p>
                    <button class="ghost" id="signUp">SIGN UP</button>
                </div>
            </div>
        </div>
    </div>

    <footer>CISC3003 Web Programming: DC325182 Che Chi Hin 2026</footer>

    <script src="js/script.js"></script>
</body>
</html>