<?php
$host = 'localhost';
$user = 'root'; // Update as needed
$password = '12345'; // Update as needed
$dbname = 'portal_yms';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
