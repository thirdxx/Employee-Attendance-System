<?php
// MySQL database connection
$host = "localhost";
$dbname = "EmployeeAttendanceSystem";
$username = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve form data
        $employeeId = $_POST['employee_id'];
        $firstName = $_POST['first_name'];
        $middleName = $_POST['middle_name'];
        $lastName = $_POST['last_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Update employee details in the database
        $stmt = $pdo->prepare("UPDATE employee SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, address = :address, email = :email, phone = :phone WHERE employee_id = :employee_id");
        $stmt->bindParam(":first_name", $firstName);
        $stmt->bindParam(":middle_name", $middleName);
        $stmt->bindParam(":last_name", $lastName);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":employee_id", $employeeId);
        $stmt->execute();

        // Redirect to employee maintenance page after updating the employee
        header("Location: employee_maintenance.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
