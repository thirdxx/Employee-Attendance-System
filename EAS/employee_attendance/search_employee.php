<?php
include "../connect.php";

$emp_id = @$_POST["emp_id"];

if (!$emp_id) {
    echo "Employee ID Not Specified";
} else {
    $sql = "SELECT CONCAT(name) AS employee_name
            FROM employee
            WHERE emp_id = '$emp_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['employee_name'];
    } else {
        echo "Employee Not Found";
    }
}
?>
