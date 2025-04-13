<?php
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
    <style>
        /* Embedded CSS for the top menu bar */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar img {
            height: 40px;
            margin-right: 20px;
        }
        .nav-links {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            gap: 40px;
        }
        .nav-links a {
            text-decoration: none;
            color: black;
            font-size: 16px;
            font-weight: bold;
        }
        .nav-links a:hover {
            text-decoration: underline;
            color: #007BFF;
        }
        .nav-signout {
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: bold;
        }
        .nav-signout a {
            text-decoration: none;
            color: black;
            font-size: 16px;
        }
        .nav-signout a:hover {
            color: #007BFF;
        }
        .banner {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            margin-top: 10px;
        }
        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<!-- Top Navbar -->
<div class="navbar">
    <img src="logo.png" alt="Logo">
    <div class="nav-links">
        <a href="add_record.php">Add Car</a>
        <a href="list_records.php">List Cars</a>
        <a href="search_records.php">Search Car</a>
        <a href="delete_record.php">Delete Car</a>
    </div>
    <div class="nav-signout">
        <a href="logout.php">Sign Out</a>
        <span>🚗</span>
    </div>
</div>

<!-- Main Page Content -->
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Select an option from the menu above to manage your car inventory.</p>
    <div>
    <img src="car1.jpg" >

    </div>
</div>

</body>
</html>


<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
