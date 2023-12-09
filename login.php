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
        $department = $row['department'];

        // Check if the user is an admin
        if ($department == 'admin') {
            // Redirect to admin system menu page
            header("Location: admin_system_menu.php");
            exit();
        } else {
            // Redirect to employee maintenance page or other pages based on your requirement
            header("Location: dashboard_employee.php");
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
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Username: <input type="text" name="user_code"><br>
        Password: <input type="text" name="user_id"><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>