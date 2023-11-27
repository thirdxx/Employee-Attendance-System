<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
	<link rel="stylesheet" href="css/dashboard.css"> <!-- Assuming this contains your main styles -->
	<link rel="stylesheet" href="css/monthly_attendance_report.css"> <!-- Add your monthly attendance report styles here -->
    <title>Monthly Attendance Report</title>
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
    <?php
    // MySQL database connection
    $host = "localhost";
    $dbname = "EmployeeAttendanceSystem"; // Replace with your actual database name
    $username = "root"; // Replace with your actual username
    $password = ""; // Replace with your actual password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch monthly attendance data for the current month and year
        $currentMonth = date("m");
        $currentYear = date("Y");
        $stmt = $pdo->prepare("SELECT * FROM monthly WHERE MONTH(attendance_date) = :month AND YEAR(attendance_date) = :year");
        $stmt->bindParam(":month", $currentMonth);
        $stmt->bindParam(":year", $currentYear);
        $stmt->execute();
        $monthlyData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h2>Monthly Attendance Report - Month of <?php echo date("F Y"); ?></h2>
        <table>
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Date</th>
                    <th>AM IN</th>
                    <th>AM OUT</th>
                    <th>PM IN</th>
                    <th>PM OUT</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($monthlyData as $monthly) {
                    echo "<tr>";
                    echo "<td>{$monthly['employee_name']}</td>";
                    echo "<td>{$monthly['attendance_date']}</td>";
                    echo "<td>{$monthly['am_in']}</td>";
                    echo "<td>{$monthly['am_out']}</td>";
                    echo "<td>{$monthly['pm_in']}</td>";
                    echo "<td>{$monthly['pm_out']}</td>";
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
