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

    // Initialize late and undertime variables (in seconds)
    $am_late_seconds = max(0, $amIn - $am_start);
    $am_undertime_seconds = max(0, $am_end - $amOut);
    $pm_late_seconds = max(0, $pmIn - $pm_start);
    $pm_undertime_seconds = max(0, $pm_end - $pmOut);

    // Function to convert seconds to hours and minutes format
    function convertToHoursMinutes($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    // Convert seconds to hours and minutes for late and undertime
    $am_late = convertToHoursMinutes($am_late_seconds);
    $am_undertime = convertToHoursMinutes($am_undertime_seconds);
    $pm_late = convertToHoursMinutes($pm_late_seconds);
    $pm_undertime = convertToHoursMinutes($pm_undertime_seconds);

    // Insert attendance data into the atlog table
    $sql = "INSERT INTO atlog (emp_id, atlog_date, am_in, am_out, pm_in, pm_out, am_late, am_undertime, pm_late, pm_undertime) 
            VALUES (?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    // Assuming these values are correctly retrieved and calculated
    $stmt->bind_param('issssssss', $empId, $_POST["am_in"], $_POST["am_out"], $_POST["pm_in"], $_POST["pm_out"], $am_late, $am_undertime, $pm_late, $pm_undertime);

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
