<?php
// search_records.php
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
            $search_results .= "<table border='1' cellpadding='10' cellspacing='0'>";
            $search_results .= "<tr><th>ID</th><th>Make</th><th>Model</th><th>Year</th><th>Color</th><th>Price ($)</th></tr>";
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
    <title>Search for a Car</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Search for a Car</h2>
        <form action="search_records.php" method="POST">
            Search by: 
            <select name="field" required>
                <option value="make">Make</option>
                <option value="model">Model</option>
                <option value="year">Year</option>
                <option value="color">Color</option>
            </select><br><br>
            Keyword: <input type="text" name="keyword" required><br><br>
            <input type="submit" value="Search">
        </form>

        <br>
        <?php echo $search_results; ?>
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
