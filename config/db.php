<?php
// ============================================================
//  config/db.php  –  PDO connection + session bootstrap
//  Edit HOST / USER / PASS / DBNAME to match your XAMPP setup
// ============================================================

$host = 'localhost';
$user = 'root';       // default XAMPP user
$pass = '';           // default XAMPP password (empty)
$dbname = 'db_clinic';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("<div style='font-family:sans-serif;padding:20px;color:red;'>
            <h2>Database Connection Failed</h2>
            <p>" . htmlspecialchars($e->getMessage()) . "</p>
            <p>Make sure XAMPP MySQL is running and <code>db_clinic</code> has been imported.</p>
         </div>");
}
