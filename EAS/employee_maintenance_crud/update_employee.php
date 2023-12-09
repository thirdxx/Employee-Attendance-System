<?php
// MySQL database connection
$host = "localhost";
$dbname = "EmpAttendanceSystem"; // Updated database name
$username = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve form data
        $empId = $_POST['emp_id']; // Updated variable name to match the form input name
        $userCode = $_POST['user_code'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        $email = $_POST['email'];
        $position = $_POST['position'];
        $status = $_POST['status'];
        $userId = $_POST['user_id'];

        // Update employee details in the database
        $stmt = $pdo->prepare("UPDATE employee SET user_code = :user_code, name = :name, department = :department, email = :email, position = :position, user_id = :user_id WHERE emp_id = :emp_id");
        $stmt->bindParam(":user_code", $userCode);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":department", $department);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":position", $position);
        $stmt->bindParam(":user_id", $userId);
        $stmt->bindParam(":emp_id", $empId);
        $stmt->execute();

        // Redirect to employee maintenance page after updating the employee
        header("Location: ../employee_maintenance.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
