<?php
// search_employee.php

// MySQL database connection
$host = "localhost";
$dbname = "EmployeeAttendanceSystem";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if search parameter is provided in the URL
    if (isset($_GET['search_employee_id'])) {
        // Get the search parameter from the URL
        $searchEmployeeId = $_GET['search_employee_id'];

        // Fetch employee data from the database based on the search parameter
        $stmt = $pdo->prepare("SELECT * FROM employee WHERE employee_id = :id");
        $stmt->bindParam(":id", $searchEmployeeId);
        $stmt->execute();

        // Display the search results or a message if employee is not found
        echo "<h3>Search Results</h3>";

        if ($stmt->rowCount() > 0) {
            // Employee Table for Search Results
            echo "<table>
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

            while ($employee = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$employee['employee_id']}</td>";
                echo "<td>{$employee['first_name']}</td>";
                echo "<td>{$employee['middle_name']}</td>";
                echo "<td>{$employee['last_name']}</td>";
                echo "<td>{$employee['address']}</td>";
                echo "<td>{$employee['email']}</td>";
                echo "<td>{$employee['phone']}</td>";
                echo "<td class='action-btns'>
                        <a href='employee_maintenance_crud/edit_employee.php?id={$employee['employee_id']}' class='edit-btn'>Edit</a>
                        <a href='employee_maintenance_crud/delete_employee.php?id={$employee['employee_id']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this employee?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            // Display a message when employee is not found
            echo "Employee ID Not Found.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
