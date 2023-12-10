<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dashboard_content.css">
    <link rel="stylesheet" href="clock/clock.css">
    <script src="clock/clock.js"></script>
    <title>Main Page</title>
</head>
<body>

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

<div class="content">
    <!-- Container for the colored h1 -->
    <div class="title-container">
        <h1>Welcome Admin!</h1>
    </div>
    <!-- <div class="clock">
    <div id="time"></div>
    <div id="date"></div>
</div> -->
    <div class="cards-container">
        <div class="card" onclick="empMaintenance()">
        <h3>Employee Maintenace</h3>
    </div>
    <div class="card" onclick="loginReport()">
        <h3>Log-in Report</h3>
    </div>
    <div class="card" onclick="dailyAttendance()">
        <h3>Daily Attendance <br> Report</h3>
    </div>
    <div class="card" onclick="monthlyAttendance()">
        <h3>Monthly Attendance <br> Report</h3>
    </div>
</div>

<!-- JavaScript to handle the redirection -->
<script>
    function empMaintenance() {
        window.location.href = 'employee_maintenance.php';
    }
      function loginReport() {
        window.location.href = 'login_report.php';
    }
     function dailyAttendance() {
        window.location.href = 'daily_attendance_report.php';
    }
     function monthlyAttendance() {
        window.location.href = 'monthly_attendance_report.php';
    }
    </script>
    <!-- <div class="clock">
    <div id="time"></div>
    <div id="date"></div> -->
  </div>
    </div>
</div>

</body>
</html>
