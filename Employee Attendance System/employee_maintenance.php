<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Maintenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Assuming this contains your main styles -->
	<link rel="stylesheet" href="css/emp_maintenance.css">
</head>
<body>

<!-- Sidebar from main.php -->
<div class="sidebar">
    <h2>Logo here</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="employee_maintenance.php"><i class="fas fa-user-cog"></i>Employee Maintenance</a></li>
        <li><a href="login_report.php"><i class="fas fa-file-alt"></i>Log-in report</a></li>
        <li><a href="daily_attendance_report.php"><i class="fas fa-calendar-day"></i>Daily Attendance Report</a></li>
        <li><a href="monthly_attendance_report.php"><i class="far fa-calendar-alt"></i>Monthly Attendance Report</a></li>
    </ul>
    <a href="admin_login.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<!-- Content Area -->
<div class="content">
    <h2>Employee Maintenance</h2>

    <!-- Employee Table -->
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // MySQL database connection
            $host = "localhost";
            $dbname = "EmployeeAttendanceSystem";
            $username = "root";
            $password = "";

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Fetch employee data from the database
                $stmt = $pdo->query("SELECT * FROM employee"); // Replace 'employee' with your actual table name

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['employee_id']}</td>";
                    echo "<td>{$row['first_name']}</td>";
                    echo "<td>{$row['middle_name']}</td>";
                    echo "<td>{$row['last_name']}</td>";
                    echo "<td>{$row['address']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td class='action-btns'>
                            <button onclick='viewEmployee({$row['employee_id']})'>View</button>
                            <button onclick='editEmployee({$row['employee_id']})'>Edit</button>
                            <button onclick='deleteEmployee({$row['employee_id']})'>Delete</button>
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
        function viewEmployee(employeeId) {
            alert(`View Employee ID: ${employeeId}`);
        }

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
