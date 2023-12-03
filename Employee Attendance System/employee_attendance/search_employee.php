<?php
include "../connect.php";

$employee_id = @$_POST["employee_id"];

if (!$employee_id) {
    echo "Employee ID Not Specified";
} else {
    $sql = "SELECT CONCAT(first_name, ' ', last_name) AS employee_name
            FROM employee
            WHERE employee_id = '$employee_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['employee_name'];
    } else {
        echo "Employee Not Found";
    }
}
?>
