<?php
include "../connect.php"; // Include the database connection file

if (isset($_GET['search_employee_id'])) {
    $searchEmployeeId = $_GET['search_employee_id'];

    $stmt = $conn->prepare("SELECT * FROM employee WHERE employee_id = ?");
    $stmt->bind_param("i", $searchEmployeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h3>Search Results</h3>";

    if ($result->num_rows > 0) {
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

        while ($employee = $result->fetch_assoc()) {
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
        echo "Employee ID Not Found.";
    }
}
?>
