<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <!-- <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dashboard_content.css"> -->
    <link rel="stylesheet" href="css/dashboard_admin.css">
    <link rel="stylesheet" href="clock/clock.css">
    <script src="clock/calendar.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
    <linkrel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css"
    /> -->
    <script src="clock/clock.js"></script>
    <title>Admin Dashboard</title>
</head>
<body>

<div class="sidebar">
    <h2>BTS</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="employee_maintenance.php"><i class="fas fa-user-cog"></i>Employee Maintenance</a></li>
        <li><a href="login_report.php"><i class="fas fa-file-alt"></i>  Log-in Report</a></li>
        <li><a href="daily_attendance_report.php"><i class="fas fa-calendar-day"></i>Daily Attendance Report</a></li>
        <li><a href="monthly_attendance_report.php"><i class="far fa-calendar-alt"></i>Monthly Attendance Report</a></li>
    </ul>
    <a href="login/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<div class="content">
    <!-- Container for the colored h1 -->
    <div class="title-container">
        <h1 class="moving-heading">BTS Productions Inc. Employee Attendance System</h1>
    </div>
    <p class="welcomecard">Welcome back Admin!</p>
    <div class="cardtime-container">
        <div class="cardtime">
      <p id="realTime"></p>
      <p id="realDate"></p>
      <div id="calendar"></div>
        </div>
    <!-- </div> -->
    <div class="cardtime calendar-card" id="calendar-container"></div>
    </div>
    <!-- <div class="clock">
    <div id="time"></div>
    <div id="date"></div>
</div> -->
    <div class="cards-container">
        <div class="card" onclick="empMaintenance()">
        <h3 >Employee Maintenace</h3>
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
<div class="count-container">
    
  <h2 class=' empCountTotal'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
</svg> Total Employees: <?php echo getTotalEmployees(); ?></h2>
</div>
<!-- <div class="cardtime">
      <p id="realTime"></p>
      <p id="realDate"></p>
      <div id="calendar"></div>
    </div>
    <div class="cardtime calendar-card" id="calendar-container"></div> -->

    
    <!-- <a href="employee_maintenance_crud/add_employee.php" class="add-btn"></a> -->


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
        </script>
        <script>
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
<?php
    function getTotalEmployees() {
        // MySQL database connection
        $host = "localhost";
        $dbname = "EmpAttendanceSystem";
        $username = "root";
        $password = "";

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch the total number of employees
            $stmt = $pdo->query("SELECT COUNT(*) as totalEmployees FROM employee"); // Replace 'employee' with your actual table name
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['totalEmployees'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }
    
    ?>
    <?php
// Function to get the total count by attendance status
function getTotalCountByStatus($status) {
    // MySQL database connection
    $host = "localhost";
    $dbname = "EmpAttendanceSystem";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the total count based on attendance status
        $stmt = $pdo->prepare("SELECT COUNT(*) as totalCount FROM employee WHERE attendance_status = :status");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['totalCount'];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}

// Function to retrieve and reset attendance status based on am_late and pm_late
function retrieveAndResetAttendanceStatus($date) {
    // MySQL database connection
    $host = "localhost";
    $dbname = "EmpAttendanceSystem";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve attendance status based on am_late and pm_late
        $stmt = $pdo->prepare("SELECT emp_id, am_late, pm_late FROM atlog WHERE atlog_date = :date");
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Process retrieved data and update attendance status
        foreach ($result as $row) {
            $empId = $row['emp_id'];
            $amLate = $row['am_late'];
            $pmLate = $row['pm_late'];

            $attendanceStatus = calculateAttendanceStatus($amLate, $pmLate);

            // Update the attendance status in your employee table
            updateAttendanceStatus($empId, $attendanceStatus);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Function to calculate attendance status based on am_late and pm_late values
function calculateAttendanceStatus($amLate, $pmLate) {
    // Add your logic to determine the attendance status based on am_late and pm_late values
    // Example logic: If either am_late or pm_late is true, mark as 'Late', otherwise 'On Time'
    if ($amLate || $pmLate) {
        return 'Late';
    } else {
        return 'On Time';
    }
}

// Function to update attendance status in your employee table
function updateAttendanceStatus($empId, $attendanceStatus) {
    // MySQL database connection
    $host = "localhost";
    $dbname = "EmpAttendanceSystem";
    $username = "root";
    $password = "";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update the attendance status in your employee table
        $stmt = $pdo->prepare("UPDATE employee SET attendance_status = :status WHERE emp_id = :empId");
        $stmt->bindParam(':status', $attendanceStatus);
        $stmt->bindParam(':empId', $empId);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Call the function for each status
$presentCount = getTotalCountByStatus('Present');
$absentCount = getTotalCountByStatus('Absent');
$lateCount = getTotalCountByStatus('Late');
?>


</body>
</html>
