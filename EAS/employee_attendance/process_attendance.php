<?php
// Get the posted form data
$am_in = $_POST['am_in'];
$am_out = $_POST['am_out'];
$pm_in = $_POST['pm_in'];
$pm_out = $_POST['pm_out'];
$emp_id = $_POST['emp_id'];

// Get the current date
$atlog_date = date('Y-m-d'); // Format: YYYY-MM-DD

// Establish a connection to your MySQL database (Replace these variables with your actual database credentials)
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

// Get the time ranges
$start_am_in = strtotime("08:00:00"); // 8:00 AM
$end_am_out = strtotime("12:00:00"); // 12:00 PM
$start_pm_in = strtotime("13:00:00"); // 1:00 PM
$end_pm_out = strtotime("17:00:00"); // 5:00 PM

// Convert user inputs to timestamps for comparison
$am_in_time = strtotime($am_in);
$am_out_time = strtotime($am_out);
$pm_in_time = strtotime($pm_in);
$pm_out_time = strtotime($pm_out);

// Function to calculate time difference in HH:MM:SS format
function calculateTimeDifference($start, $end)
{
    $diff = $end - $start;
    $hours = floor($diff / 3600);
    $minutes = floor(($diff % 3600) / 60);
    $seconds = $diff % 60;

    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

// Calculate AM Late and Undertime
if ($am_in !== '' && $am_out !== '') {
    $am_late = calculateTimeDifference($start_am_in, $am_in_time);
    $am_undertime = calculateTimeDifference($am_out_time, $end_am_out);
} else {
    $am_late = '';
    $am_undertime = '';
}

// Calculate PM Late and Undertime
if ($pm_in !== '' && $pm_out !== '') {
    $pm_late = calculateTimeDifference($start_pm_in, $pm_in_time);
    $pm_undertime = calculateTimeDifference($pm_out_time, $end_pm_out);
} else {
    $pm_late = '';
    $pm_undertime = '';
}

// Check if an entry already exists for the same emp_id on the same date
$sql_check = "SELECT * FROM atlog WHERE emp_id = '$emp_id' AND atlog_date = '$atlog_date'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Update the existing entry if found
    $row = $result_check->fetch_assoc();
    $atlog_id = $row['atlog_id']; // Assuming you have a column 'atlog_id' as the primary key

    // Update the existing record's AM OUT and PM OUT values if provided
    $update_sql = "";
	if ($am_in !== '') {
		$update_sql .= "UPDATE atlog SET am_in = '$am_in', am_late = '$am_late', am_undertime = '$am_undertime' WHERE atlog_id = '$atlog_id';";
	}
	if ($am_out !== '') {
		$update_sql .= "UPDATE atlog SET am_out = '$am_out', am_late = '$am_late', am_undertime = '$am_undertime' WHERE atlog_id = '$atlog_id';";
	}
	if ($pm_in !== '') {
		$update_sql .= "UPDATE atlog SET pm_in = '$pm_in', pm_late = '$pm_late', pm_undertime = '$pm_undertime' WHERE atlog_id = '$atlog_id';";
	}
	if ($pm_out !== '') {
		$update_sql .= "UPDATE atlog SET pm_out = '$pm_out', pm_late = '$pm_late', pm_undertime = '$pm_undertime' WHERE atlog_id = '$atlog_id';";
	}

    // Execute the update queries
    if ($update_sql !== "") {
        if ($conn->multi_query($update_sql) === TRUE) {
            echo "<script>window.location.href = '../emp_attendance.php';</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No updates performed";
    }
} else {
    // Insert a new entry if no existing entry found
    $insert_sql = "INSERT INTO atlog (am_in, am_out, pm_in, pm_out, emp_id, atlog_date, am_late, am_undertime, pm_late, pm_undertime)
               VALUES ('$am_in', '$am_out', '$pm_in', '$pm_out', '$emp_id', '$atlog_date', '$am_late', '$am_undertime', '$pm_late', '$pm_undertime')";


    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>window.location.href = '../emp_attendance.php';</script>";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>