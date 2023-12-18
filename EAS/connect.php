<?php
    $database = "EmpAttendanceSystem";
    $conn = mysqli_connect('localhost', 'root', '', $database);

    if (!$conn) {
        echo "Connection failed: " . mysqli_connect_error();
    }
?>
