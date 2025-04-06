<?php
// setupDB.php

// Include database login info
require_once 'dblogin.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    die("Fatal Error: " . $e->getMessage());
}

// Create users table if not exists
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    username VARCHAR(50) NOT NULL PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)");

// Create cars table if not exists
$pdo->exec("CREATE TABLE IF NOT EXISTS cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    color VARCHAR(30) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    INDEX(make),
    INDEX(model)
)");

// Insert some initial car records if table is empty
$stmt = $pdo->query("SELECT COUNT(*) FROM cars");
$count = $stmt->fetchColumn();

if ($count == 0) {
    $pdo->exec("INSERT INTO cars (make, model, year, color, price) VALUES
        ('Toyota', 'Camry', 2020, 'White', 24000.00),
        ('Honda', 'Civic', 2019, 'Black', 20000.00),
        ('Ford', 'Mustang', 2021, 'Red', 35000.00),
        ('Chevrolet', 'Malibu', 2018, 'Blue', 18000.00),
        ('Nissan', 'Altima', 2022, 'Silver', 26000.00)");
}

echo "Setup completed successfully.";
?>

<!--
Integrity Statement:
I certify that this submission is my own original work.
Name: Rasel Islam
-->