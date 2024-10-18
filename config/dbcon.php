<?php
// Database connection settings
$servername = "localhost"; // Change this to your database server (e.g., localhost)
$username = "root";        // Change this to your database username
$password = "";            // Change this to your database password
$dbname = "cms";  // Change this to your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set charset to utf8mb4 to support a wider range of characters
mysqli_set_charset($conn, "utf8mb4");
