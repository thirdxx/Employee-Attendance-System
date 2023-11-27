<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/emp_attendance.css">
    <title>Employee Attendance</title>
</head>
<body>
<h1>Employee Attendance System</h1>
<div class="search-container">
    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#548235" class="bi bi-person-fill" viewBox="0 0 16 16">
  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
</svg>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- <label for="emp_id">Employee ID:</label> -->
        <input type="text" id="emp_id" name="emp_id" placeholder="Employee ID" required>
        <button type="submit">Search</button>
    </form>
    <hr>
    <input type="text" id="name" placeholder="Enter Name">

<button onclick="('AM', 'IN')" class="time" >AM IN</button>
<button onclick="('AM', 'OUT')" class="time">AM OUT</button>
<button onclick="('PM', 'IN')" class="time">PM IN</button>
<button onclick="('PM', 'OUT')" class="time">PM OUT</button>
</div>

<?php
include "connect.php";

$emp_id = @$_GET["emp_id"];

if (!$emp_id) {
    echo "<p>Employee ID Not Specified.</p>";
} else {
    echo "<h2>$emp_id</h2>";

    $sql = "SELECT *
            FROM employee
            WHERE emp_id = '$emp_id'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "<p>Employee ID Not Found.</p>";
    } else {
        echo "<p>Employee ID Found.</p>";
        // Display employee details
        echo "<div class='employee-details'>";
        echo "<p>First Name: " . $row['first_name'] . "</p>";
        echo "<p>Last Name: " . $row['last_name'] . "</p>";
        echo "<p>Middle Name: " . $row['middle_name'] . "</p>";
        echo "<p>Middle Initial: " . $row['middle_initial'] . "</p>";
        echo "<p>Address: " . $row['address'] . "</p>";
        echo "<p>Phone: " . $row['phone'] . "</p>";
        echo "<p>Email: " . $row['email'] . "</p>";
        echo "</div>";
    }
}

?>

</body>
</html>
