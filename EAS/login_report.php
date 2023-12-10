<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Assuming this contains your main styles -->
    <link rel="stylesheet" href="css/login_report.css"> <!-- Link to the separate CSS file -->
    <title>Login Report</title>
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
    <a href="login/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<!-- Content Area -->
<div class="content">
    <h2>Log-in Report</h2>

    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Login Date</th>
                <th>Login Time</th>
				<th>Logout Date</th>
                <th>Logout Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Connect to the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "EmpAttendanceSystem";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch login report data
            $sql = "SELECT * FROM employee";
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result === false) {
                die("Error executing the query: " . $conn->error);
            }

            // Check if any records were found
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['login_date']}</td>";
                    echo "<td>{$row['login_time']}</td>";
                    echo "<td>{$row['logout_date']}</td>";
                    echo "<td>{$row['logout_time']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No login records found</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
