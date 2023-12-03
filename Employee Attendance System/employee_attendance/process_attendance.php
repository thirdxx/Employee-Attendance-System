<?php
// Establish database connection (assuming you have a connect.php file with connection code)
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted data
    $empId = $_POST["employee_id"];
    $amIn = strtotime($_POST["am_in"]);
    $amOut = strtotime($_POST["am_out"]);
    $pmIn = strtotime($_POST["pm_in"]);
    $pmOut = strtotime($_POST["pm_out"]);

    // Define time boundaries
    $am_start = strtotime('8:00 AM');
    $am_end = strtotime('12:00 PM');
    $pm_start = strtotime('1:00 PM');
    $pm_end = strtotime('5:00 PM');

    // Initialize late and undertime variables
    $am_late = 0;
    $am_undertime = 0;
    $pm_late = 0;
    $pm_undertime = 0;

    // Calculate AM late and undertime in minutes
    if ($amIn > $am_start) {
        $am_late = round(($amIn - $am_start) / 60); // Late in minutes
    }
    if ($amOut < $am_end) {
        $am_undertime = round(($am_end - $amOut) / 60); // Undertime in minutes
    }

    // Calculate PM late and undertime in minutes
    if ($pmIn > $pm_start) {
        $pm_late = round(($pmIn - $pm_start) / 60); // Late in minutes
    }
    if ($pmOut < $pm_end) {
        $pm_undertime = round(($pm_end - $pmOut) / 60); // Undertime in minutes
    }

    // Insert attendance data into the atlog table
    $sql = "INSERT INTO atlog (emp_id, atlog_date, am_in, am_out, pm_in, pm_out, am_late, am_undertime, pm_late, pm_undertime) 
            VALUES (?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?)"; // Assuming atlog_date is a date field

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('isssiiiii', $empId, $_POST["am_in"], $_POST["am_out"], $_POST["pm_in"], $_POST["pm_out"], $am_late, $am_undertime, $pm_late, $pm_undertime);

    if ($stmt->execute()) {
        // Redirect to a success page or back to emp_attendance.php with success parameter
        header("Location: ../emp_attendance.php?success=1");
        exit();
    } else {
        // Handle insertion failure
        echo "Error: Failed to insert attendance data.";
    }
}
?>
