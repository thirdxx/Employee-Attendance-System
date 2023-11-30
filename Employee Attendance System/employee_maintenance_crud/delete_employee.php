<?php
// MySQL database connection
$host = "localhost";
$dbname = "EmployeeAttendanceSystem";
$username = "root";
$password = "";

if (isset($_GET['id'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $employeeId = $_GET['id'];

        if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
            // User confirmed deletion
            $stmt = $pdo->prepare("DELETE FROM employee WHERE employee_id = :id");
            $stmt->bindParam(":id", $employeeId);
            $stmt->execute();

            // Redirect back to the employee maintenance page after deletion
            header("Location: ../employee_maintenance.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // JavaScript confirmation prompt before deleting
    echo "<script>
            if (confirm('Are you sure you want to delete this employee?')) {
                window.location.href = 'delete_employee.php?id=$employeeId&confirm=yes';
            } else {
                window.location.href = 'employee_maintenance.php';
            }
          </script>";
} else {
    echo "Employee ID not provided.";
}
?>
