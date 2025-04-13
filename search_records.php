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

$search_results = "";

if (isset($_POST['field']) && isset($_POST['keyword'])) {
    $field = $_POST['field'];
    $keyword = sanitize($_POST['keyword']);

    $allowed_fields = ['make', 'model', 'year', 'color'];

    if (in_array($field, $allowed_fields)) {
        $stmt = $pdo->prepare("SELECT * FROM cars WHERE $field LIKE ?");
        $like_keyword = "%$keyword%";
        $stmt->execute([$like_keyword]);
        $results = $stmt->fetchAll();

        if ($results) {
            $search_results .= "<table><tr><th>ID</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Price ($)</th></tr>";
            foreach ($results as $row) {
                $search_results .= "<tr>";
                $search_results .= "<td>" . htmlspecialchars($row['car_id']) . "</td>";
                $search_results .= "<td>" . htmlspecialchars($row['make']) . "</td>";
                $search_results .= "<td>" . htmlspecialchars($row['model']) . "</td>";
                $search_results .= "<td>" . htmlspecialchars($row['year']) . "</td>";
                $search_results .= "<td>" . htmlspecialchars($row['color']) . "</td>";
                $search_results .= "<td>" . htmlspecialchars($row['price']) . "</td>";
                $search_results .= "</tr>";
            }
            $search_results .= "</table>";
        } else {
            $search_results = "<p>No cars found matching your search.</p>";
        }
    } else {
        $search_results = "<p>Invalid search field.</p>";
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
    <title>Search for a Car</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            margin-top: 50px;
            width: 90%;
            max-width: 800px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 10px;
        }
        select, input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f7f7f7;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #20c997;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #198754;
            transform: scale(1.05);
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #20c997;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
            color: #20c997;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Search for a Car</h2>
    <form action="search_records.php" method="POST">
        <select name="field" required>
            <option value="make">Make</option>
            <option value="model">Model</option>
            <option value="year">Year</option>
            <option value="color">Color</option>
        </select>
        <input type="text" name="keyword" placeholder="Enter Keyword" required>
        <input type="submit" value="Search">
    </form>

    <?php echo $search_results; ?>

    <a href="mainmenu.php">Return to Main Menu</a>
</div>

</body>
</html>





<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->
