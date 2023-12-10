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
        $update_sql .= "UPDATE atlog SET am_in = '$am_in' WHERE atlog_id = '$atlog_id';";
    }
	if ($am_out !== '') {
        $update_sql .= "UPDATE atlog SET am_out = '$am_out' WHERE atlog_id = '$atlog_id';";
    }
    if ($pm_in !== '') {
        $update_sql .= "UPDATE atlog SET pm_in = '$pm_in' WHERE atlog_id = '$atlog_id';";
    }
	if ($pm_out !== '') {
        $update_sql .= "UPDATE atlog SET pm_out = '$pm_out' WHERE atlog_id = '$atlog_id';";
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
    $insert_sql = "INSERT INTO atlog (am_in, am_out, pm_in, pm_out, emp_id, atlog_date)
                   VALUES ('$am_in', '$am_out', '$pm_in', '$pm_out', '$emp_id', '$atlog_date')";

    if ($conn->query($insert_sql) === TRUE) {
        echo "<script>window.location.href = '../emp_attendance.php';</script>";
    } else {
        echo "Error: " . $insert_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>