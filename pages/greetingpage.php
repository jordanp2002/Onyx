<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/greeting.css">
    <title>Document</title>
</head>
<header>
    <nav>
        <ul>
            <li><a href="../pages/login.php">login</a></li>
            <li><a href="/support">support</a></li>
        </ul>
    </nav>
</header>
<body>
    <h1>Onyx</h1>
    <h3>Welcome!</h3>
    <div class = "Buttons">
        <div class = "Browse">
            <p>Browse</p>
            <a href = "../pages/SearchPage.php">
                <button class="button" id = "browse-button">Browse</button>
            </a>
        </div>
        <div class = "SignUp">
            <p>Sign up!</p>
            <a href = "../pages/signup.php" >
                <button class="button" id = "signup-button" >Sign up</button>
            </a>
        </div>
        <div class = "Login">
            <p>Login!</p>
            <a href = "../pages/login.php">
                <button class="button" id = "login-button">Login</button>
            </a>
        </div>
    </div>
</body>
</html>