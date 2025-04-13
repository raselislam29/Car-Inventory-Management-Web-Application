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

$error = "";

if (isset($_POST['make'])) {
    $make = sanitize($_POST['make']);
    $model = sanitize($_POST['model']);
    $year = sanitize($_POST['year']);
    $color = sanitize($_POST['color']);
    $price = sanitize($_POST['price']);

    if (!is_numeric($year) || !is_numeric($price)) {
        $error = "Year and Price must be numeric.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO cars (make, model, year, color, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$make, $model, $year, $color, $price]);

        echo "<script>alert('Car added successfully!'); window.location.href='mainmenu.php';</script>";
        exit();
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
    <title>Add a New Car</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #74ebd5 0%, #acb6e5 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 400px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container input[type="text"],
        .form-container input[type="number"] {
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f7f7f7;
        }
        .form-container input[type="submit"] {
            padding: 12px;
            background-color: #6a11cb;
            background-image: linear-gradient(315deg, #6a11cb 0%, #2575fc 74%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
        }
        .form-container input[type="submit"]:hover {
            transform: scale(1.05);
            background-image: linear-gradient(315deg, #2575fc 0%, #6a11cb 74%);
        }
        .form-container a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        .form-container a:hover {
            text-decoration: underline;
            color: #2575fc;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add a New Car</h2>

    <form action="add_record.php" method="POST">
        <input type="text" name="make" placeholder="Make" required>
        <input type="text" name="model" placeholder="Model" required>
        <input type="text" name="year" placeholder="Year" required>
        <input type="text" name="color" placeholder="Color" required>
        <input type="text" name="price" placeholder="Price ($)" required>
        <input type="submit" value="Add Car">
    </form>

    <div class="error">
        <?php echo htmlspecialchars($error); ?>
    </div>

    <a href="mainmenu.php">Return to Main Menu</a>
</div>

</body>
</html>



<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
