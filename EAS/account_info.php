<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/account_info.css">
    <link rel="stylesheet" href="css/dashboard_employee.css">
    <!-- <link rel="stylesheet" href="css/admin_dashboard.css"> -->
    <script src="clock/calendar.js"></script>
    <title>Account Information</title>
</head>
<body>    

<div class="sidebar">
    <h2>BTS</h2>
    <ul>
        <li><a href="dashboard_employee.php"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="account_info.php"><i class="fa fa-user-circle"></i>Account Information</a></li>
        <li><a href="emp_attendance.php"><i class="fas fa-user-check"></i>Employee Attendance</a></li>
    </ul>
    <a href="login/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>
</body>
</html>
<?php
// Start the session to access session variables
session_start();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_code']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
include "connect.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user_code and user_id from session variables
$user_code = $_SESSION['user_code'];
$user_id = $_SESSION['user_id'];

// Retrieve account information based on user_code and user_id
$sql = "SELECT * FROM employee WHERE user_code = '$user_code' AND user_id = '$user_id'";
$result = $conn->query($sql);

// Check if the user exists in the database
if ($result->num_rows == 1) {
    // Fetch user details
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
    $department = $row['department'];
    $position = $row['position'];

    // Display account information
    echo "<div class='content'>";
	echo "<div class='container'>";
	echo "<h2><i class='fa fa-user-circle' aria-hidden='true'></i> Account Information</h2>";
	echo "<table>";
	echo "<tr><td><strong>User Code</strong></td><td>$user_code</td></tr>";
	echo "<tr><td><strong>User ID</strong></td><td>$user_id</td></tr>";
	echo "<tr><td><strong>Name</strong></td><td>$name</td></tr>";
	echo "<tr><td><strong>Email</strong></td><td>$email</td></tr>";
	echo "<tr><td><strong>Phone</strong></td><td>$phone</td></tr>";
	echo "<tr><td><strong>Address</strong></td><td>$address</td></tr>";
	echo "<tr><td><strong>Department</strong></td><td>$department</td></tr>";
	echo "<tr><td><strong>Position<strong></td><td>$position</td></tr>";
	echo "</table>";
	echo "</div>";
	echo "</div>";
	} else {
    // User not found in the database, handle accordingly (e.g., redirect to login page)
    header("Location: login/login.php");
    exit();
}

// Close the database connection
$conn->close();
?>
