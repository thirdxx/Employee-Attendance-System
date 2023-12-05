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
    <a href="admin_login.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
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
                <th>Logout Time</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Your PHP code to fetch login report data and display in table rows goes here
            // Modify the PHP logic to fetch and display login report data based on your database schema
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
