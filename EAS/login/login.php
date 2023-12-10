<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EmpAttendanceSystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the timezone to GMT+8:00
date_default_timezone_set('Asia/Singapore');

// Assuming you have a form that submits the user_code and user_id
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_code = $_POST['user_code'];
    $user_id = $_POST['user_id'];

    // Check if the user exists in the database
    $sql = "SELECT * FROM employee WHERE user_code = '$user_code' AND user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // User exists, fetch user details
        $row = $result->fetch_assoc();
        $employee_name = $row['name'];

        // Check if the employee is already marked as "Active"
        $activeCheckSql = "SELECT * FROM employee WHERE name = '$employee_name' AND status = 'Active'";
        $activeCheckResult = $conn->query($activeCheckSql);

        if ($activeCheckResult->num_rows == 0) {
            // Log login activity in real-time
            $login_date = date("Y-m-d");
            $login_time = date("H:i:s");

            // Update the status of the existing employee record
            $updateStatusSql = "UPDATE employee 
                                SET login_date = '$login_date', login_time = '$login_time', status = 'Active'
                                WHERE name = '$employee_name'";
            $conn->query($updateStatusSql);

            // Set session variables
            session_start();
            $_SESSION['user_code'] = $user_code;
            $_SESSION['user_id'] = $user_id;

            // Check if the user is an admin
            if ($row['department'] == 'admin') {
                // Redirect to admin system menu page
                header("Location: ../dashboard.php");
                exit();
            } else {
                // Redirect to employee maintenance page or other pages based on your requirement
                header("Location: ../dashboard_employee.php");
                exit();
            }
        } else {
            // Employee is already marked as "Active", handle accordingly (e.g., show an error message)
            header("Location: login.php?error=AlreadyLoggedIn");
            exit();
        }
    } else {
        // Invalid credentials, redirect to login page or show an error message
        header("Location: login.php?error=InvalidCredentials");
        exit();
    }
}
?>
<!-- HTML form for login -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css"> <!-- Linking the external CSS -->
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Username: <input type="text" name="user_code"><br>
        Password: <input type="text" name="user_id"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
