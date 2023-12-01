<?php
$host = "localhost";
$dbname = "EmployeeAttendanceSystem";
$username = "root";
$password = "";

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$validUser = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST["user_type"]; // Assuming a form field named "user_type" distinguishes between admin and employee logins

    $email = $_POST["email"];
    $password = $_POST["password"];

    $tableName = ($userType === "admin") ? "admin" : "employees"; // Table name for respective user type

    // Query the database to validate the email and password
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE email = :email AND password = :password");
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    // If a row is returned, the user is valid
    if ($stmt->rowCount() > 0) {
        $validUser = true;
        
        // Start a session and set relevant session variables if necessary
        session_start();
        $_SESSION['authenticated'] = true; // Set a session variable to denote authentication

        if ($userType === "admin") {
            // Redirect the admin user to the dashboard page (dashboard.php)
            header('Location: dashboard.php');
            exit();
        } else {
            // Redirect the employee user to the employee attendance page (employee_attendance.php)
            header('Location: Employee Attendance System/employee_attendance.php');
            exit();
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>