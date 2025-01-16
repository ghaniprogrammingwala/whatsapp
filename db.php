<?php
$host = 'localhost';
$username = 'uexh5jsi8shpy';
$password = 'ird9wggh5yg5';
$database = 'db12chut6rilvm';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>
