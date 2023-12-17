<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Maintenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Icons -->
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/emp_maintenance.css">
    <style>
        /* Your existing styles */
    </style>
</head>
<body>

<!-- Sidebar from main.php -->
<?php include('main.php'); ?>

<!-- Content Area -->
<div class="content">
    <h2>Employee Maintenance</h2>

    <a href="employee_maintenance_crud/add_employee.php" class="add-btn">Add Employee</a>

    <!-- Employee Table -->
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Position</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include your database connection code here or in a separate file
            $servername = "your_servername";
            $username = "your_username";
            $password = "your_password";
            $dbname = "EmpAttendanceSystem";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch employee data from the 'employee' table
            $sql = "SELECT * FROM employee";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["emp_id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["department"] . "</td>";
                    echo "<td>" . $row["position"] . "</td>";
                    echo "<td class='action-btns'>
                            <a href='employee_maintenance_crud/edit_employee.php?id=" . $row["emp_id"] . "' class='edit-btn'>Edit</a>
                            <a href='employee_maintenance_crud/delete_employee.php?id=" . $row["emp_id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this employee?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <!-- JavaScript functions to handle actions (view, edit, delete) -->
    <script>
        function editEmployee(employeeId) {
            alert(`Edit Employee ID: ${employeeId}`);
        }

        function deleteEmployee(employeeId) {
            alert(`Delete Employee ID: ${employeeId}`);
        }
    </script>
</div>

</body>
</html>