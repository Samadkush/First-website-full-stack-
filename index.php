<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <img src="school_logo.png" alt="School Logo">
        <h1>Login</h1>
        <form action="loginUser.php" method="post">
        <?php
            if (isset($_GET['error'])) {
                echo '<p class="error-message">' . $_GET['error'] . '</p>';
            }
        ?>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
</body>
</html>
