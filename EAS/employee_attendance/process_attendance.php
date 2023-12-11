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

$am_late = '00:00:00';
$pm_late = '00:00:00';
$am_undertime = '00:00:00';
$pm_undertime = '00:00:00';

// Check if the time falls within the working hours (8 AM to 12 PM and 1 PM to 5 PM)
if (
    $am_in >= '08:00:00' && $am_in <= '12:00:00' &&
    $pm_in >= '13:00:00' && $pm_in <= '17:00:00' &&
    $am_out >= '08:00:00' && $am_out <= '12:00:00' &&
    $pm_out >= '13:00:00' && $pm_out <= '17:00:00'
) {
    $am_in_time = new DateTime($am_in);
    $am_out_time = new DateTime($am_out);
    $pm_in_time = new DateTime($pm_in);
    $pm_out_time = new DateTime($pm_out);

    $am_late_interval = $am_in_time->diff(new DateTime('08:00:00'));
    $pm_late_interval = $pm_in_time->diff(new DateTime('13:00:00'));

    $am_undertime_interval = new DateTime('12:00:00');
    $am_undertime_interval->sub($am_out_time->diff($am_in_time));

    $pm_undertime_interval = new DateTime('17:00:00'); // Assuming the end work time is 5:00 PM
    $pm_undertime_interval->sub($pm_out_time->diff($pm_in_time));

    $am_late = $am_late_interval->format("%H:%I:%S");
    $pm_late = $pm_late_interval->format("%H:%I:%S");
    $am_undertime = $am_undertime_interval->format("%H:%I:%S");
    $pm_undertime = $pm_undertime_interval->format("%H:%I:%S");
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
        $update_sql .= "UPDATE atlog SET am_in = '$am_in', am_late = '$am_late' WHERE atlog_id = '$atlog_id';";
    }
    if ($pm_in !== '') {
        $update_sql .= "UPDATE atlog SET pm_in = '$pm_in', pm_late = '$pm_late' WHERE atlog_id = '$atlog_id';";
    }
    if ($am_out !== '') {
        $update_sql .= "UPDATE atlog SET am_out = '$am_out', am_undertime = '$am_undertime' WHERE atlog_id = '$atlog_id';";
    }
    if ($pm_out !== '') {
        $update_sql .= "UPDATE atlog SET pm_out = '$pm_out', pm_undertime = '$pm_undertime' WHERE atlog_id = '$atlog_id';";
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
               VALUES ('$am_in', '$am_out', '$pm_in', '$pm_out', '$emp_id', '$atlog_date', '$am_late', '$am_undertime', '$pm_late', '$pm_undertime')";

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
