<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="css/dashboard_employee.css">
    <!-- <link rel="stylesheet" href="css/admin_dashboard.css"> -->
    <script src="clock/calendar.js"></script>
    <title>Employee Dashboard</title>
</head>
<body>    

<div class="sidebar">
    <h2>BTS</h2>
    <ul>
        <li><a href="dashboard_employee.php"><i class="fas fa-home"></i>Dashboard</a></li>
        <li><a href="account_info.php"><i class="fa fa-user-circle"></i>Account Information</a></li>
        <li><a href="emp_attendance.php"><i class="fas fa-user-check"></i>Employee Attendance</a></li>
    </ul>
    <a href="login/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<div class="content">
    <!-- Container for the colored h1 -->
    <div class="title-container">
        <h1>Welcome User!</h1>
    </div>
     <div class="horizontal-container">
    <div class="card">
      <h1>Employee Attendance System</h1>
      <p>Where minutes are managed, and success is engineered.</p>
    </div>
    
    <div class="card">
      <p id="realTime"></p>
      <p id="realDate"></p>
      <div id="calendar"></div>
    </div>
    <div class="horizontal-container">
    <img src="css/empdash1.png" alt="empdash image">
    <div class="card calendar-card" id="calendar-container"></div>

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
    <!-- Include FullCalendar library -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css"
    />
</div>


</body>
</html>
