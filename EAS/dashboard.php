<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <!-- <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/dashboard_content.css"> -->
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="stylesheet" href="clock/clock.css">
    <script src="clock/calendar.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
    <linkrel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css"
    /> -->
    <script src="clock/clock.js"></script>
    <title>Main Page</title>
</head>
<body>

<div class="sidebar">
    <h2>Logo here</h2>
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
        <h1>Welcome Admin!</h1>
    </div>
    <p class="welcomecard">Welcome back Admin! <br><span> Your day will start now!</span></p>
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
  <h2 class='empCountPresent'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-check" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4"/>
</svg> Total Present: <?php echo getTotalCountByStatus('Present'); ?></h2>
  <h2 class='empCountAbsent'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-x" viewBox="0 0 16 16">
  <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4"/>
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708"/>
</svg> Total Absent: <?php echo getTotalCountByStatus('Absent'); ?></h2>
  <h2 class='empCountLate'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-dash" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M11 12h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1 0-1m0-7a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4"/>
</svg> Total Late Comers: <?php echo getTotalCountByStatus('Late'); ?></h2>
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
     <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
    <linkrel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css"
    />
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
?>


</body>
</html>
