<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="login.css">
  </head>
  <body>
    <div class="container">
      <img src="school_logo.png" alt="School Logo">
      <h1>Sign Up</h1>
      <form action="register.php" method="post">
      <div class="error-message" style="display: block;">
                <?php
            session_start(); // Start a session
            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']); // Clear the error message from session
            }
          ?>
        </div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Sign Up</button>
      </form>
      <p>Already have an account? <a href="index.php">Log In</a></p>
    </div>
  </body>
</html>
