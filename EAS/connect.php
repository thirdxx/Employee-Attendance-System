<?php
    $database = "EmpAttendanceSystem";
    $conn = mysqli_connect('localhost', 'root', '', $database);

    if (!$conn) {
        echo "Connect failed";
        return;
    }