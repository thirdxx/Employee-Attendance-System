<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/emp_attendance.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Employee Attendance</title>
</head>
<body>
    <h1>Employee Attendance System</h1>
	<h1 id="date"></h1>
    <div class="search-container">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#548235" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
        </svg>
		<input type="text" id="employee_id" placeholder="Enter Employee ID">
        <button type="button" onclick="searchEmployee()">Search</button>
        <hr>
        <input type="text" id="employee_name" placeholder="Employee Name" readonly>
        <form method="post" action="employee_attendance/process_attendance.php"> <!-- Form for selecting time -->

            <!-- Modify the action URL based on your requirements -->
            <!-- For Monthly Attendance Report -->
            <input type="hidden" name="redirect_monthly" value="monthly_attendance_report.php">

            <!-- For Daily Attendance Report -->
            <input type="hidden" name="redirect_daily" value="daily_attendance_report.php">

            <input type="hidden" name="employee_id" id="hidden_employee_id" value="<?php echo isset($_GET['employee_id']) ? $_GET['employee_id'] : ''; ?>"> <!-- Hidden field to pass employee ID -->

            <input type="hidden" name="emp_name" id="hidden_emp_name" value=""> <!-- Hidden field to pass employee Name -->

            <label for="am_in">AM In:</label>
            <input type="time" id="am_in" name="am_in" required>

            <label for="am_out">AM Out:</label>
            <input type="time" id="am_out" name="am_out" required>

            <label for="pm_in">PM In:</label>
            <input type="time" id="pm_in" name="pm_in" required>

            <label for="pm_out">PM Out:</label>
            <input type="time" id="pm_out" name="pm_out" required>

            <button type="submit" class="time-submit">Submit</button>
        </form>
    </div>

    <!-- PHP code for retrieving employee details (unchanged) -->
    <?php
        include "connect.php";

        $employee_id = @$_GET["employee_id"];

        if ($employee_id) {
            echo "<h2>$employee_id</h2>";

            $sql = "SELECT *
                    FROM employee
                    WHERE employee_id = '$employee_id'";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo "Error: " . mysqli_error($conn);
                exit;
            }

            $row = mysqli_fetch_assoc($result);

            if ($row) {
                // JavaScript to set the employee name in the hidden field
                echo "<script>document.getElementById('hidden_emp_name').value = '" . $row['first_name'] . " " . $row['last_name'] . "';</script>";
            } else {
                echo "<p>Employee ID Not Found.</p>";
            }
        }
        ?>

    <script>
		const d = new Date();
		document.getElementById("date").innerHTML = d;
	
        // Automatically submit the form when the Employee ID field loses focus
        document.getElementById('employee_id').addEventListener('blur', function() {
            document.getElementById('searchForm').submit();
        });
		
		function searchEmployee() {
		const employeeId = document.getElementById('employee_id').value;
		$.ajax({
			type: "POST",
			url: "employee_attendance/search_employee.php",
			data: { employee_id: employeeId },
			success: function(response) {
				console.log(response);
				document.getElementById('employee_name').value = response;
				
				// Update the hidden_employee_id field with the searched employee ID
				document.getElementById('hidden_employee_id').value = employeeId;
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	}

    </script>
</body>
</html>
