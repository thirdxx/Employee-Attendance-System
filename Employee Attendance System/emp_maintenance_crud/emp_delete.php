<?php
$host = 'localhost';
$db = 'EmployeeAttendanceSystem';
$user = 'root';
$password = '';

if (isset($_GET['employee_id'])) {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $employee_id = $_GET['employee_id'];

        // Delete the employee record by ID
        $sql = "DELETE FROM employee WHERE employee_id = :employee_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employee_id', $employee_id);

        if ($stmt->execute()) {
            header('Location: employee_maintenance.php'); // Redirect to the employee list page after deleting
            exit;
        } else {
            echo "Error deleting employee.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid employee ID.";
}
?>