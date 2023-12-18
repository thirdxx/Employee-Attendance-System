<?php
include "../connect.php"; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data
        $empId = $_POST['emp_id']; 
        $userCode = $_POST['user_code'];
        $name = $_POST['name'];
        $department = $_POST['department'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $position = $_POST['position'];
        $status = $_POST['status'];
        $userId = $_POST['user_id'];

        // Update employee details in the database
        $stmt = $conn->prepare("UPDATE employee SET user_code = ?, name = ?, department = ?, email = ?, phone = ?, address = ?, position = ?, user_id = ? WHERE emp_id = ?");
        $stmt->bind_param("ssssssssi", $userCode, $name, $department, $email, $phone, $address, $position, $userId, $empId);
        $stmt->execute();

        // Redirect to employee maintenance page after updating the employee
        header("Location: ../employee_maintenance.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
