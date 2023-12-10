<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/emp_attendance.css">
    <!-- <link rel="stylesheet" href="css/employee_dashboard.css"> -->
    <script src="clock/calendar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Employee Attendance</title>
</head>
<body>
    <h1>Employee Attendance System</h1>
     <div class="card">
      <p id="realTime"></p>
      <p id="realDate"></p>
      <div id="calendar"></div>
    </div>
    <div class="search-container">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#548235" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
        </svg>
        <div>
        <input type="text" id="emp_id" placeholder="Enter Employee ID">
        <button type="button" onclick="searchEmployee()">Search</button>
        <hr>
        <input type="text" id="employee_name" placeholder="Employee Name" readonly>
        <form id="attendanceForm" method="post" action="employee_attendance/process_attendance.php"> <!-- Form for selecting time -->
        <div class="button-group">
            <!-- Hidden fields to store time data -->
            <input type="hidden" name="am_in" id="am_in">
            <input type="hidden" name="am_out" id="am_out">
            <input type="hidden" name="pm_in" id="pm_in">
            <input type="hidden" name="pm_out" id="pm_out">

            <!-- Modify the action URL based on your requirements -->
            <!-- For Monthly Attendance Report -->
            <input type="hidden" name="redirect_monthly" value="monthly_attendance_report.php">

            <!-- For Daily Attendance Report -->
            <input type="hidden" name="redirect_daily" value="daily_attendance_report.php">

            <input type="hidden" name="emp_id" id="hidden_employee_id" value="<?php echo isset($_GET['emp_id']) ? $_GET['emp_id'] : ''; ?>"> <!-- Hidden field to pass employee ID -->

            <input type="hidden" name="emp_name" id="hidden_emp_name" value=""> <!-- Hidden field to pass employee Name -->

            <button type="button" onclick="submitSpecificAction('am_in')">AM In</button>

            <button type="button" onclick="submitSpecificAction('am_out')">AM Out</button>

            <button type="button" onclick="submitSpecificAction('pm_in')">PM In</button>

            <button type="button" onclick="submitSpecificAction('pm_out')">PM Out</button>
        </form>
        </div>
        <!-- <div class="card">
      <p id="realTime"></p>
      <p id="realDate"></p>
      <div id="calendar"></div>
    </div> -->
    </div>

    <script>
        // Function to submit the current time to the respective input field and then submit the form
        function submitSpecificAction(fieldId) {
            const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            document.getElementById(fieldId).value = currentTime;

            // Submit the form
            document.getElementById('attendanceForm').submit();
        }

        function searchEmployee() {
            const employeeId = document.getElementById('emp_id').value;
            $.ajax({
                type: "POST",
                url: "employee_attendance/search_employee.php",
                data: { emp_id: employeeId },
                success: function (response) {
                    console.log(response);
                    document.getElementById('employee_name').value = response;

                    // Update the hidden_employee_id field with the searched employee ID
                    document.getElementById('hidden_employee_id').value = employeeId;
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
         // Real-time clock
      function updateClock() {
        const now = new Date();
        const formattedTime = now.toLocaleTimeString("en-US", {
          hour: "2-digit",
          minute: "2-digit",
          second: "2-digit",
          hour12: true,
        });
        document.getElementById("realTime").innerText = formattedTime;
      }

      // Real date calendar
      function updateDate() {
        const now = new Date();
        const options = {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
        };
        const formattedDate = now.toLocaleDateString("en-US", options);
        document.getElementById("realDate").innerText = formattedDate;
      }

      // Calendar widget
      function initializeCalendar() {
        const calendarContainer = document.getElementById("calendar");
        const calendar = new FullCalendar.Calendar(calendarContainer, {
          initialView: "dayGridMonth",
          events: [],
        });
        calendar.render();
      }

      // Update time and date every second
      setInterval(() => {
        updateClock();
        updateDate();
      }, 1000);

      // Initialize calendar
      initializeCalendar();

      // Initial update
      updateClock();
      updateDate();
    </script>
</body>
</html>