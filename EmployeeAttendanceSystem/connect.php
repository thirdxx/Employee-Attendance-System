<?php
    $database = "activity07";
    $conn = mysqli_connect('localhost', 'root', '', $database);

    if (!$conn) {
        echo "Connect failed";
        return;
    }