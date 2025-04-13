<?php
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

function sanitize($var) {
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
    <style>
        /* Embedded CSS for Login Page */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(to right, #d3cce3, #e9e4f0);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
        }
        .login-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        .login-container img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .login-container input[type=\"text\"], 
        .login-container input[type=\"password\"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f2f2f2;
        }
        .login-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Added transition */
        }       
        .login-container input[type="submit"]:hover {
        background-color: #388e3c; /* Even darker green for better effect */
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <img src="user_icon.png" alt="User Icon"> <!-- Add your user icon image here -->
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Login">
    </form>
    <div class="error">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <p><a href="register.php">Don't have an account? Register Here</a></p>
</div>

</body>
</html>


<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
