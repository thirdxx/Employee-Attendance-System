<?php
include "../connect.php"; // Include the database connection file

if (isset($_GET['id'])) {
    try {
        $emp_id = $_GET['id'];

        if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
            // User confirmed deletion
            $stmt = $conn->prepare("DELETE FROM employee WHERE emp_id = ?");
            $stmt->bind_param("i", $emp_id); // Assuming emp_id is an integer. Change 'i' if it's another type.
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
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Employee ID not provided.";
}
?>
