<?php
// MySQL database connection
$host = "localhost";
$dbname = "EmpAttendanceSystem";
$username = "root";
$password = "";

if (isset($_GET['id'])) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $emp_id = $_GET['id'];

        if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
            // User confirmed deletion
            $stmt = $pdo->prepare("DELETE FROM employee WHERE emp_id = :id");
            $stmt->bindParam(":id", $emp_id);
            $stmt->execute();

            // Redirect back to the employee maintenance page after deletion
            header("Location: ../employee_maintenance.php");
            exit();
        } else {
            // JavaScript confirmation prompt before deleting
            echo "<script>
                    var confirmed = confirm('Are you sure you want to delete this employee?');
                    if (confirmed) {
                        window.location.href = 'delete_employee.php?id=$emp_id&confirm=yes';
                    } else {
                        window.location.href = '../employee_maintenance.php';
                    }
                  </script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Employee ID not provided.";
}
?>
