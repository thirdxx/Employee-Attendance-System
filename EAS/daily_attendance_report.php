<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/dashboard_admin.css"> <!-- Assuming this contains your main styles -->
    <link rel="stylesheet" href="css/daily_attendance_report.css">
    <title>Daily Attendance Report</title>
</head>
<body>

<!-- Sidebar -->
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
    <h2>Daily Attendance Report - Date: <?php echo date("Y-m-d"); ?></h2>

    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>AM IN</th>
                <th>AM OUT</th>
                <th>PM IN</th>
                <th>PM OUT</th>
                <th>AM Late</th>
                <th>AM Undertime</th>
                <th>PM Late</th>
                <th>PM Undertime</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // MySQL database connection (Update your credentials here)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "EmpAttendanceSystem";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Fetch daily attendance data for the current date with employee names from employee table
                $currentDate = date("Y-m-d");
                $sql = "SELECT e.name, a.am_in, a.am_out, a.pm_in, a.pm_out, a.am_late, a.am_undertime, a.pm_late, a.pm_undertime 
                        FROM atlog a
                        INNER JOIN employee e ON a.emp_id = e.emp_id 
                        WHERE a.atlog_date = :date";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":date", $currentDate);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['am_in']}</td>";
                    echo "<td>{$row['am_out']}</td>";
                    echo "<td>{$row['pm_in']}</td>";
                    echo "<td>{$row['pm_out']}</td>";
                    echo "<td>{$row['am_late']}</td>";
                    echo "<td>{$row['am_undertime']}</td>";
                    echo "<td>{$row['pm_late']}</td>";
                    echo "<td>{$row['pm_undertime']}</td>";
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