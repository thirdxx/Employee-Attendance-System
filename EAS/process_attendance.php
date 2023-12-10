<?php
// Assuming you have a database connection established

// Retrieve form data
$emp_id = $_POST['emp_id'];
$am_in = $_POST['am_in'];
$am_out = $_POST['am_out'];
$pm_in = $_POST['pm_in'];
$pm_out = $_POST['pm_out'];

// Perform your computations for lateness and undertime based on your business logic
// Example computations (You'll need to adjust these based on your actual requirements)
$am_late = computeLate($am_in, '09:00:00'); // Replace '09:00:00' with your expected start time
$pm_late = computeLate($pm_in, '13:00:00'); // Replace '13:00:00' with your expected start time
$am_undertime = computeUndertime($am_out, '12:00:00'); // Replace '12:00:00' with your expected end time
$pm_undertime = computeUndertime($pm_out, '17:00:00'); // Replace '17:00:00' with your expected end time

// Function to calculate late time
function computeLate($actualTime, $expectedTime) {
    // Convert time strings to Unix timestamps for comparison
    $actualTimestamp = strtotime($actualTime);
    $expectedTimestamp = strtotime($expectedTime);

    if ($actualTimestamp > $expectedTimestamp) {
        // Calculate the difference in seconds
        $lateSeconds = $actualTimestamp - $expectedTimestamp;
        // Convert seconds to minutes for late time
        $lateMinutes = round($lateSeconds / 60);
        return $lateMinutes;
    } else {
        return 0; // No late time
    }
}

// Function to calculate undertime
function computeUndertime($actualTime, $expectedTime) {
    // Convert time strings to Unix timestamps for comparison
    $actualTimestamp = strtotime($actualTime);
    $expectedTimestamp = strtotime($expectedTime);

    if ($actualTimestamp < $expectedTimestamp) {
        // Calculate the difference in seconds
        $undertimeSeconds = $expectedTimestamp - $actualTimestamp;
        // Convert seconds to minutes for undertime
        $undertimeMinutes = round($undertimeSeconds / 60);
        return $undertimeMinutes;
    } else {
        return 0; // No undertime
    }
}

// Insert data into the database
$sql = "INSERT INTO atlog (emp_id, am_in, am_out, pm_in, pm_out, am_late, pm_late, am_undertime, pm_undertime)
        VALUES ('$emp_id', '$am_in', '$am_out', '$pm_in', '$pm_out', '$am_late', '$pm_late', '$am_undertime', '$pm_undertime')";

if (mysqli_query($conn, $sql)) {
    echo "Attendance data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>