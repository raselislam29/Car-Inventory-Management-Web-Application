<?php
// add_record.php
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
        $error = "Year and Price must be numeric values.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO cars (make, model, year, color, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$make, $model, $year, $color, $price]);

        echo "<script>alert('Car added successfully!'); window.location.href='mainmenu.php';</script>";
        exit();
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
    <title>Add a New Car</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Add a New Car</h2>
        <form action="add_record.php" method="POST">
            Make: <input type="text" name="make" required><br><br>
            Model: <input type="text" name="model" required><br><br>
            Year: <input type="text" name="year" required><br><br>
            Color: <input type="text" name="color" required><br><br>
            Price ($): <input type="text" name="price" required><br><br>
            <input type="submit" value="Add Car">
        </form>
        <p style="color:red;"> <?php echo htmlspecialchars($error); ?> </p>
        <br>
        <a href="mainmenu.php">Return to Main Menu</a>
    </div>
</body>
</html>


<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
