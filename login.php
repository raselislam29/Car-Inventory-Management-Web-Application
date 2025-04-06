<?php
// login.php
session_start();
require_once 'dblogin.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    die("Fatal Error: " . $e->getMessage());
}

$error = "";

if (isset($_POST['username'])) {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    if (!$row) {
        $error = "Invalid username or password.";
    } else {
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: mainmenu.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}

function sanitize($var)
{
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>User Login</h2>
    <form action="login.php" method="POST">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <p style="color:red;"> <?php echo htmlspecialchars($error); ?> </p>
    <p>Don't have an account? <a href="register.php">Register Here</a></p>
</body>
</html>

<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
