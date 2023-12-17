<!-- admin_system_menu.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Admin System Menu</title>
</head>
<body>
    <h1>Welcome Admin!</h1>
    
    <!-- Buttons for redirection -->
    <button onclick="window.location.href = 'employee_maintenance.php'">Employee Maintenance</button>
    <button onclick="window.location.href = 'login_report.php'">Login Report</button>
    <button onclick="window.location.href = 'daily_attendance.php'">Daily Attendance</button>
    <button onclick="window.location.href = 'monthly_attendance.php'">Monthly Attendance</button>

    <!-- Logout Button -->
    <form action="logout.php">
        <input type="submit" value="Logout">
    </form>
</body>
</html>