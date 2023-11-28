<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Assuming this contains your main styles -->
    <link rel="stylesheet" href="css/daily_attendance_report.css">
    <title>Daily Attendance Report</title>
</head>
<body>

<!-- Sidebar -->
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
    <h2>Daily Attendance Report - Date: <?php echo date("Y-m-d"); ?></h2>

    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>AM IN</th>
                <th>AM OUT</th>
                <th>PM IN</th>
                <th>PM OUT</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // MySQL database connection
            $host = "localhost";
            $dbname = "EmployeeAttendanceSystem"; // Replace with your actual database name
            $username = "root"; // Replace with your actual username
            $password = ""; // Replace with your actual password

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Fetch daily attendance data for the current date with employee names from employee table
                $currentDate = date("Y-m-d");
                $stmt = $pdo->prepare("SELECT employee.first_name, employee.last_name, atlog.am_in, atlog.am_out, atlog.pm_in, atlog.pm_out 
                                       FROM atlog 
                                       INNER JOIN employee ON atlog.emp_id = employee.employee_id 
                                       WHERE atlog.atlog_date = :date");
                $stmt->bindParam(":date", $currentDate);
                $stmt->execute();
                $atlogData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($atlogData as $atlog) {
                    $employeeName = $atlog['first_name'] . ' ' . $atlog['last_name'];
                    echo "<tr>";
                    echo "<td>{$employeeName}</td>";
                    echo "<td>{$atlog['am_in']}</td>";
                    echo "<td>{$atlog['am_out']}</td>";
                    echo "<td>{$atlog['pm_in']}</td>";
                    echo "<td>{$atlog['pm_out']}</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

