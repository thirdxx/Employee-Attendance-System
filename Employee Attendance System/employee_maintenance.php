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
<div class="content">
<form method="post" action="emp_maintenance_crud/emp_process.php">
        <table>
            <tr>
                <td><input type="text" name="first_name" placeholder="First Name" required></td>
                <td><input type="text" name="middle_name" placeholder="Middle Name"></td>
                <td><input type="text" name="last_name" placeholder="Last Name" required></td>
                <td><input type="text" name="address" placeholder="Address" required></td>
                <td><input type="text" name="email" placeholder="Email" required></td>
                <td><input type="text" name="phone" placeholder="Phone" required></td>
                <td><button type="submit" name="add">Add</button></td>
            </tr>
            <tbody>
                <?php include 'emp_maintenance_crud/emp_add.php'; ?>
            </tbody>
        </table>
    </form>
</div>
</body>
</html>
