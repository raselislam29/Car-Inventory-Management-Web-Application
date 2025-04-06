<?php
// register.php
session_start();
require_once 'dblogin.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    die("Fatal Error: " . $e->getMessage());
}

// Initialize error message
$error = "";

if (isset($_POST['email'])) {
    // Server-side validation
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($username) < 6) {
        $error = "Username must be at least 6 characters.";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        $error = "Password must be at least 8 characters, with lowercase, uppercase, and a digit.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check for duplicate username
        $stmt = $pdo->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            $error = "Username already taken. Please choose another.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);

            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.php';</script>";
            exit();
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
    <title>Register</title>
    <script>
        function validateForm() {
            let email = document.forms["regForm"]["email"].value;
            let username = document.forms["regForm"]["username"].value;
            let password = document.forms["regForm"]["password"].value;
            let confirm_password = document.forms["regForm"]["confirm_password"].value;

            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Invalid email format.");
                return false;
            }
            if (username.length < 6) {
                alert("Username must be at least 6 characters.");
                return false;
            }
            let passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
            if (!passwordRegex.test(password)) {
                alert("Password must have at least 8 characters, a lowercase letter, an uppercase letter, and a number.");
                return false;
            }
            if (password !== confirm_password) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>User Registration</h2>
    <form name="regForm" action="register.php" method="POST" onsubmit="return validateForm()">
        Email: <input type="email" name="email" required><br><br>
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        Confirm Password: <input type="password" name="confirm_password" required><br><br>
        <input type="submit" value="Register">
    </form>
    <p style="color:red;"> <?php echo htmlspecialchars($error); ?> </p>
    <p>Already have an account? <a href="login.php">Login Here</a></p>
</body>
</html>




<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
