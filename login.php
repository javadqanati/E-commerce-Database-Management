<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $validUsername = "root";
        $validPassword = "8151@Javad";

        if ($username === $validUsername && $password === $validPassword) {
            $_SESSION["auth"] = "yes";
            $_SESSION["username"] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "<p>Invalid username or password. Please try again.</p>";
            echo "<a href='login.php'>Back to Login</a>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
    <link rel="stylesheet" href="style.css">
        <h2 class = 'h2-title'>Login</h2>
        <form method="POST" action="login.php">
            Username: <input type="text" name="username" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <button class='btn-primary' type="submit">Login</button>
        </form>
    </body>
</html>
