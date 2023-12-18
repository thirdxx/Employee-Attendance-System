<?php
// Connect to the database
include "../connect.php";

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
    <link rel="stylesheet" type="text/css" href="../css/ad_login.css"> <!-- Linking the external CSS -->
	<script>
        function validateForm() {
            var userCode = document.forms["loginForm"]["user_code"].value;
            var userId = document.forms["loginForm"]["user_id"].value;

            // Regular expression pattern to allow only alphanumeric characters
            var alphanumeric = /^[a-zA-Z0-9]+$/;

            if (!alphanumeric.test(userCode)) {
                alert("Username should only contain alphanumeric characters (no special characters)");
                return false;
            }

            if (userId.length < 8) {
                alert("Password must be at least 8 characters long");
                return false;
            }
        }
    </script>
</head>
<body>
    <!-- <h2>Login</h2>
    <form name="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()">
        <div class="user-box"><input type="text" name="user_code" required><br> <label>Username</label>
       <div class="user-box"><input type="password" name="user_id" minlength="8" required><label>Password</label><br>
        <input type="submit" value="Login">
    </form> -->
    <div class="login-box">
  <h2>Login</h2>
  <form name="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()">
    <div class="user-box">
      <input type="text" name="user_code" required>
      <label>Username</label>
    </div>
    <div class="user-box">
      <input type="password" name="user_id" minlength="8" required>
      <label>Password</label>
    </div>
    <a>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <input class="click" type="submit" value="Login">
    </a>
  </form>
</div>
	

</body>
</html>
	
<!-- <div class="login-box">
  <h2>Login</h2>
  <form name="loginForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()">
    <div class="user-box">
      <input type="text" name="user_code" required>
      <label>Username</label>
    </div>
    <div class="user-box">
      <input type="password" name="user_id" minlength="8" required>
      <label>Password</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Submit
    </a>
  </form>
</div>
	 -->
