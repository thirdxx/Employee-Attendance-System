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

// Define work schedule constants (you can adjust these according to your company's policies)
$am_in_time = strtotime('08:00:00'); // Assuming AM work starts at 8:00 AM
$am_out_time = strtotime('12:00:00'); // Assuming AM work ends at 12:00 PM
$pm_in_time = strtotime('13:00:00'); // Assuming PM work starts at 1:00 PM
$pm_out_time = strtotime('17:00:00'); // Assuming PM work ends at 5:00 PM

// Convert user-inputted time strings to UNIX timestamps for comparison
$am_in_timestamp = strtotime($am_in);
$am_out_timestamp = strtotime($am_out);
$pm_in_timestamp = strtotime($pm_in);
$pm_out_timestamp = strtotime($pm_out);

// Calculate lateness and undertime for AM shift
if ($am_in_timestamp > $am_in_time && $am_in_timestamp < $am_out_time) {
    $am_late = $am_in_timestamp - $am_in_time; // Late arrival in seconds
} else {
    $am_late = 0; // Reset late if no late for AM shift
}

if ($am_out_timestamp < $am_out_time && $am_out_timestamp > $am_in_time) {
    $am_undertime = $am_out_time - $am_out_timestamp; // Undertime in seconds
} else {
    $am_undertime = 0; // Reset undertime if no undertime for AM shift
} 

// Calculate lateness and undertime for PM shift
if ($pm_in_timestamp > $pm_in_time && $pm_in_timestamp < $pm_out_time) {
    $pm_late = $pm_in_timestamp - $pm_in_time; // Late arrival in seconds
} else {
    $pm_late = 0; // Reset late if no late for PM shift
}

if ($pm_out_timestamp < $pm_out_time && $pm_out_timestamp > $pm_in_time) {
    $pm_undertime = $pm_out_time - $pm_out_timestamp; // Undertime in seconds
} else {
    $pm_undertime = 0; // Reset undertime if no undertime for PM shift
}

// Convert seconds to human-readable format (HH:MM:SS)
function formatTime($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $seconds = $seconds % 60;

    return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
}

// Apply the formatted late and undertime to the query
$am_late_formatted = formatTime($am_late);
$am_undertime_formatted = formatTime($am_undertime);
$pm_late_formatted = formatTime($pm_late);
$pm_undertime_formatted = formatTime($pm_undertime);

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
        $update_sql .= "UPDATE atlog SET am_in = '$am_in', am_late = '$am_late_formatted' WHERE atlog_id = '$atlog_id';";
    }
    if ($am_out !== '') {
        $update_sql .= "UPDATE atlog SET am_out = '$am_out', am_undertime = '$am_undertime_formatted' WHERE atlog_id = '$atlog_id';";
    }
    if ($pm_in !== '') {
        $update_sql .= "UPDATE atlog SET pm_in = '$pm_in', pm_late = '$pm_late_formatted' WHERE atlog_id = '$atlog_id';";
    }
    if ($pm_out !== '') {
        $update_sql .= "UPDATE atlog SET pm_out = '$pm_out', pm_undertime = '$pm_undertime_formatted' WHERE atlog_id = '$atlog_id';";
    }

    // Execute the update queries
    if ($update_sql !== "") {
        if ($conn->multi_query($update_sql) === TRUE) {
            // Redirect to a page after successful update
            header("Location: ../emp_attendance.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No updates performed";
    }
} else {
    // Insert a new entry if no existing entry found
    $insert_sql = "INSERT INTO atlog (am_in, am_out, pm_in, pm_out, emp_id, atlog_date, am_late, am_undertime, pm_late, pm_undertime)
               VALUES ('$am_in', '$am_out', '$pm_in', '$pm_out', '$emp_id', '$atlog_date', '$am_late_formatted', '$am_undertime_formatted', '$pm_late_formatted', '$pm_undertime_formatted')";

    if ($conn->query($insert_sql) === TRUE) {
        // Redirect to a page after successful insertion
        header("Location: ../emp_attendance.php");
        exit();
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
