<?php
// mainmenu.php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Menu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <img src="car_banner.jpg" alt="Car Banner" class="banner">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <h3>Main Menu</h3>
        <ul>
            <li><a href="list_records.php">List All Cars</a></li>
            <li><a href="add_record.php">Add a New Car</a></li>
            <li><a href="search_records.php">Search for a Car</a></li>
            <li><a href="delete_record.php">Delete a Car</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>

<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
