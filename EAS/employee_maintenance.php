<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Maintenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Icons -->
    <link rel="stylesheet" href="css/dashboard_admin_test.css">
	<link rel="stylesheet" href="css/employee_maintenance.css">
	<style>
		.add-btn {
			float: right;				
            background-color: #333333;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
			margin-bottom: 30px;
        }
		
		.edit-btn, .delete-btn {
            padding: 5px 10px;
            margin-right: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }

        .edit-btn {
            background-color: #333; /* Edit button color */
        }

        .delete-btn {
            background-color: #333; /* Delete button color */
        }
	</style>
</head>
<body>

<!-- Sidebar from main.php -->
<div class="sidebar">
    <h2>BTS</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="employee_maintenance.php"><i class="fas fa-user-cog"></i>Employee Maintenance</a></li>
        <li><a href="login_report.php"><i class="fas fa-file-alt"></i>Log-in report</a></li>
        <li><a href="daily_attendance_report.php"><i class="fas fa-calendar-day"></i>Daily Attendance Report</a></li>
        <li><a href="monthly_attendance_report.php"><i class="far fa-calendar-alt"></i>Monthly Attendance Report</a></li>
    </ul>
    <a href="login/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<!-- Content Area -->
<div class="content">
    <h2>Employee Maintenance</h2>
    
    <a href="employee_maintenance_crud/add_employee.php" class="add-btn">Add Employee</a>

    <!-- Employee Table -->
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>User Code</th>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Position</th>
                <th>User ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // MySQL database connection
            $host = "localhost";
            $dbname = "EmpAttendanceSystem";
            $username = "root";
            $password = "";

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Fetch employee data from the database
                $stmt = $pdo->query("SELECT * FROM employee"); // Replace 'employee' with your actual table name

                while ($employee = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$employee['emp_id']}</td>";
                    echo "<td>{$employee['user_code']}</td>";
                    echo "<td>{$employee['name']}</td>";
                    echo "<td>{$employee['department']}</td>";
                    echo "<td>{$employee['email']}</td>";
                    echo "<td>{$employee['phone']}</td>";
                    echo "<td>{$employee['address']}</td>";
                    echo "<td>{$employee['position']}</td>";
                    echo "<td>{$employee['user_id']}</td>";
                    echo "<td class='action-btns'>
                            <a href='employee_maintenance_crud/edit_employee.php?id={$employee['emp_id']}' class='edit-btn'>Edit</a>
                            <a href='employee_maintenance_crud/delete_employee.php?id={$employee['emp_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this employee?\")'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
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
