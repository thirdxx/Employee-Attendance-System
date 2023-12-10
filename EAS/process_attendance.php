<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EmpAttendanceSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$emp_id = $_POST['emp_id'];
$am_in = $_POST['am_in'];
$am_out = $_POST['am_out'];
$pm_in = $_POST['pm_in'];
$pm_out = $_POST['pm_out'];

// Perform computations for lateness and undertime based on your business logic
$am_late = computeLate($am_in, '09:00:00'); // Replace '09:00:00' with your expected start time
$pm_late = computeLate($pm_in, '13:00:00'); // Replace '13:00:00' with your expected start time
$am_undertime = computeUndertime($am_out, '12:00:00'); // Replace '12:00:00' with your expected end time
$pm_undertime = computeUndertime($pm_out, '17:00:00'); // Replace '17:00:00' with your expected end time

// Function to calculate late time
function computeLate($actualTime, $expectedTime) {
    $actualTimestamp = strtotime($actualTime);
    $expectedTimestamp = strtotime($expectedTime);

    if ($actualTimestamp > $expectedTimestamp) {
        $lateSeconds = $actualTimestamp - $expectedTimestamp;
        $lateMinutes = round($lateSeconds / 60);
        return $lateMinutes;
    } else {
        return 0; // No late time
    }
}

// Function to calculate undertime
function computeUndertime($actualTime, $expectedTime) {
    $actualTimestamp = strtotime($actualTime);
    $expectedTimestamp = strtotime($expectedTime);

    if ($actualTimestamp < $expectedTimestamp) {
        $undertimeSeconds = $expectedTimestamp - $actualTimestamp;
        $undertimeMinutes = round($undertimeSeconds / 60);
        return $undertimeMinutes;
    } else {
        return 0; // No undertime
    }
}

// Insert data into the database
$sql = "INSERT INTO atlog (emp_id, am_in, am_out, pm_in, pm_out, am_late, pm_late, am_undertime, pm_undertime)
        VALUES ('$emp_id', '$am_in', '$am_out', '$pm_in', '$pm_out', '$am_late', '$pm_late', '$am_undertime', '$pm_undertime')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>