<?php
// delete_record.php
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
        $message = "Error deleting car.";
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
    <title>Delete a Car</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Delete a Car</h2>
        <form action="delete_record.php" method="POST">
            Enter Car ID to Delete: <input type="text" name="delete_id" required><br><br>
            <input type="submit" value="Delete">
        </form>
        <p style="color:green;"> <?php echo htmlspecialchars($message); ?> </p>
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
