<?php
    $database = "EmployeeAttendanceSystem";
    $conn = mysqli_connect('localhost', 'root', '', $database);

    if (!$conn) {
        echo "Connect failed";
        return;
    }