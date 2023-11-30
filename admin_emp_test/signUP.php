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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $userType = $_POST["user_type"]; // Get the user type from the form

    // ... (validation and database connection code remains the same)

    // Insert the user into the database, including the user type
    $stmt = $pdo->prepare("INSERT INTO employees (first_name, last_name, email, phone, password, user_type) VALUES (:first_name, :last_name, :email, :phone, :password, :user_type)");
    $stmt->bindParam(":first_name", $firstName);
    $stmt->bindParam(":last_name", $lastName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":password", $password); // Note: Password should be hashed for security
    $stmt->bindParam(":user_type", $userType); // Bind the user type

    // Execute the query
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->rowCount() > 0) {
        // Registration successful, redirect the user to a success page or login page
        header("Location: emp_attendance.php");
        exit();
    } else {
        // Registration failed, handle the error (e.g., display an error message)
        echo "Registration failed. Please try again.";
    }
}
?>