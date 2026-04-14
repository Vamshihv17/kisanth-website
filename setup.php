<?php
$host = "localhost";
$username = "root";
$password = "";

try {
    // Connect to MySQL server without selecting a database
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create Database
    $sql = "CREATE DATABASE IF NOT EXISTS farvine_db";
    $conn->exec($sql);
    echo "<p>Database 'farvine_db' created or already exists.</p>";

    // Select the database
    $conn->exec("USE farvine_db");

    // Create Varieties Table
    $varietiesTable = "CREATE TABLE IF NOT EXISTS varieties (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        price_per_kg DECIMAL(10,2) NOT NULL,
        status ENUM('active', 'inactive') DEFAULT 'active'
    )";
    $conn->exec($varietiesTable);
    echo "<p>Table 'varieties' created successfully.</p>";

    // Populate default prices if empty
    $checkVarieties = $conn->query("SELECT COUNT(*) FROM varieties")->fetchColumn();
    if ($checkVarieties == 0) {
        $insert = "INSERT INTO varieties (name, price_per_kg) VALUES 
            ('Alphonso', 30.00),
            ('Mallika', 35.00),
            ('Banganapalli', 40.00),
            ('Kesar', 45.00),
            ('Himampasand', 50.00)";
        $conn->exec($insert);
        echo "<p>Default mango varieties and prices populated.</p>";
    }

    // Create Orders Table
    $ordersTable = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_number VARCHAR(50) NOT NULL UNIQUE,
        customer_name VARCHAR(150) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        address TEXT NOT NULL,
        total_price DECIMAL(10,2) NOT NULL,
        order_status ENUM('Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($ordersTable);
    echo "<p>Table 'orders' created successfully.</p>";

    // Create Order Items Table
    $orderItemsTable = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        variety_name VARCHAR(100) NOT NULL,
        quantity INT NOT NULL,
        price_per_kg DECIMAL(10,2) NOT NULL,
        subtotal DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    )";
    $conn->exec($orderItemsTable);
    echo "<p>Table 'order_items' created successfully.</p>";
    
    // Create Admins Table
    $adminsTable = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($adminsTable);
    echo "<p>Table 'admins' created successfully.</p>";
    
    // Default admin (admin / password)
    $checkAdmins = $conn->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    if($checkAdmins == 0) {
        $hash = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admins (username, password_hash) VALUES (:usr, :pwd)");
        $stmt->execute(['usr' => 'admin', 'pwd' => $hash]);
        echo "<p>Default admin created. Username: admin | Password: password</p>";
    }

    echo "<h3>Setup complete!</h3><a href='./index.html'>Go to Homepage</a>";

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
