<?php
session_start();
require_once 'dblogin.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    die("Fatal Error: " . $e->getMessage());
}

$message = "";

if (isset($_POST['delete_id'])) {
    $delete_id = sanitize($_POST['delete_id']);

    $stmt = $pdo->prepare("DELETE FROM cars WHERE car_id = ?");
    $stmt->execute([$delete_id]);

    if ($stmt->rowCount() > 0) {
        $message = "Car deleted successfully.";
    } else {
        $message = "Error deleting car. Maybe the ID doesn't exist.";
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
    <title>Delete a Car</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f7f7f7;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #ff6f61;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #ff3c2f;
            transform: scale(1.05);
        }
        .message {
            margin-top: 15px;
            color: green;
            font-weight: bold;
        }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        a:hover {
            color: #ff6f61;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Delete a Car</h2>
    <form action="delete_record.php" method="POST">
        <input type="text" name="delete_id" placeholder="Enter Car ID to Delete" required><br>
        <input type="submit" value="Delete Car">
    </form>

    <div class="message"><?php echo htmlspecialchars($message); ?></div>

    <a href="mainmenu.php">Return to Main Menu</a>
</div>

</body>
</html>



<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
