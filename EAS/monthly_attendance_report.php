<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/dashboard_Admin.css"> <!-- Assuming this contains your main styles -->
    <link rel="stylesheet" href="css/monthly_attendance_report.css"> <!-- Add your monthly attendance report styles here -->
    <title>Monthly Attendance Report</title>
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
			<?php
			// MySQL database connection
			$host = "localhost";
			$dbname = "EmpAttendanceSystem"; // Replace with your actual database name
			$username = "root"; // Replace with your actual username
			$password = ""; // Replace with your actual password

			try {
				$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				// Fetch monthly attendance data for the current month and year from atlog table
				$currentMonth = date("m");
				$currentYear = date("Y");
				$stmt = $pdo->prepare("SELECT employee.emp_id, employee.name, atlog.atlog_date, atlog.am_in, atlog.am_out, atlog.pm_in, atlog.pm_out, atlog.am_late, atlog.am_undertime, atlog.pm_late, atlog.pm_undertime
                       FROM atlog 
                       INNER JOIN employee ON atlog.emp_id = employee.emp_id
                       WHERE MONTH(atlog.atlog_date) = :month AND YEAR(atlog.atlog_date) = :year
                       ORDER BY employee.emp_id, atlog.atlog_date");

				$stmt->bindParam(":month", $currentMonth);
				$stmt->bindParam(":year", $currentYear);
				$stmt->execute();
				$atlogData = $stmt->fetchAll(PDO::FETCH_ASSOC);

				// Initialize variables to track current employee's name and ID
				$currentEmployeeID = null;
				$employeeName = '';
				
				echo "<h2>Monthly Attendance Report - Month of " . date("F Y") . "</h2>";

				foreach ($atlogData as $atlog) {
					// Check if it's a different employee
					if ($atlog['emp_id'] !== $currentEmployeeID) {
						// Display attendance data for the previous employee (if any)
						if ($currentEmployeeID !== null) {
							echo "</tbody></table>"; // Close previous table
						}

						// Update employee information
						$currentEmployeeID = $atlog['emp_id'];
						$employeeName = $atlog['name'];

						// Display employee name and start a new table
						echo "<p>Employee Name: $employeeName</p>";
						echo "<table>
								<thead>
									<tr>
										<th>Date</th>
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
							<tbody>";
					}

					// Display attendance data
					echo "<tr>";
					echo "<td>{$atlog['atlog_date']}</td>";
					echo "<td>{$atlog['am_in']}</td>";
					echo "<td>{$atlog['am_out']}</td>";
					echo "<td>{$atlog['pm_in']}</td>";
					echo "<td>{$atlog['pm_out']}</td>";
					echo "<td>{$atlog['am_late']}</td>";
					echo "<td>{$atlog['am_undertime']}</td>";
					echo "<td>{$atlog['pm_late']}</td>";
					echo "<td>{$atlog['pm_undertime']}</td>";
					echo "</tr>";
				}

				// Close the last table
				if ($currentEmployeeID !== null) {
					echo "</tbody></table>";
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
