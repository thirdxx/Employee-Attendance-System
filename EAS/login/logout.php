<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_code']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EmpAttendanceSystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user details
$user_code = $_SESSION['user_code'];
$user_id = $_SESSION['user_id'];

// Set the timezone to GMT+8:00
date_default_timezone_set('Asia/Singapore');

// Log logout activity
$logout_date = (new DateTime('now', new DateTimeZone('Asia/Singapore')))->format("Y-m-d");
$logout_time = (new DateTime('now', new DateTimeZone('Asia/Singapore')))->format("H:i:s");

$sql = "UPDATE employee 
        SET logout_date = '$logout_date', logout_time = '$logout_time', status = 'Inactive' 
        WHERE name IN (SELECT name FROM employee WHERE user_code = '$user_code' AND user_id = '$user_id')";
$conn->query($sql);

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page after logout
header("Location: login.php");
exit();
?>
