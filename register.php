<?php
session_start();
require_once 'dblogin.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    die("Fatal Error: " . $e->getMessage());
}

$error = "";

if (isset($_POST['email'])) {
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($username) < 6) {
        $error = "Username must be at least 6 characters.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d).{8,}$/', $password)) {
        $error = "Password must be at least 8 characters, with a lowercase, uppercase, and a digit.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $pdo->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = "Username already taken. Please choose another.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);

            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
            exit();
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
    <title>Register</title>
    <style>
        /* Embedded CSS for Register Page */
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
        .register-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
            width: 400px;
            text-align: center;
        }
        .register-container img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }
        .register-container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .register-container input[type="text"], 
        .register-container input[type="email"], 
        .register-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: #f2f2f2;
        }
        .register-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .register-container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <img src="user_icon.png" alt="User Icon"> <!-- Add your user icon here -->
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="email" name="email" placeholder="Email Address" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <input type="submit" value="Register">
    </form>
    <div class="error">
        <?php echo htmlspecialchars($error); ?>
    </div>
    <p><a href="login.php">Already have an account? Login Here</a></p>
</div>

</body>
</html>





<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
