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

$query = "SELECT * FROM cars";
$stmt = $pdo->query($query);
$cars = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of Cars</title>
    <style>
        /* Embedded Vibrant CSS for List Records */
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            background: #ffffff;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            margin-top: 50px;
            width: 90%;
            max-width: 1000px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #66a6ff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f7fa;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #333;
            font-weight: bold;
            text-decoration: none;
        }
        a:hover {
            color: #007BFF;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>List of Available Cars</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Color</th>
            <th>Price ($)</th>
        </tr>
        <?php foreach ($cars as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['car_id']); ?></td>
                <td><?php echo htmlspecialchars($row['make']); ?></td>
                <td><?php echo htmlspecialchars($row['model']); ?></td>
                <td><?php echo htmlspecialchars($row['year']); ?></td>
                <td><?php echo htmlspecialchars($row['color']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="mainmenu.php">Return to Main Menu</a>
</div>

</body>
</html>


<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
