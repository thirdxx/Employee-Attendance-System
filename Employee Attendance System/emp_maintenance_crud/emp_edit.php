<?php
$host = 'localhost';
$db = 'EmployeeAttendanceSystem';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
    
    // Fetch the employee's data by ID
    $sql = "SELECT * FROM employee WHERE employee_id = :employee_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->execute();
    $employees = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employees) {
        echo "Employee not found.";
        exit;
    }

    // Handle the form submission to update employee data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve updated data from the form
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Update the employee record
        $updateSql = "UPDATE employee SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, address = :address, email = :email, phone = :phone WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':employee_id', $employee_id);
        $updateStmt->bindParam(':first_name', $first_name);
        $updateStmt->bindParam(':middle_name', $middle_name);
        $updateStmt->bindParam(':last_name', $last_name);
        $updateStmt->bindParam(':address', $address);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->bindParam(':phone', $phone);

        if ($updateStmt->execute()) {
            header('Location: employee_maintenance.php'); // Redirect to the employee list page after updating
            exit;
        } else {
            echo "Error updating employee data.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        form {
            width: 50%;
            margin: 30px auto;
            background-color: #fff;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"] {
            width: 94%;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            
        }

        button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>Edit Employee</h1>
    <form method="post" action="">
        <input type="text" name="first_name" placeholder="First Name" value="<?php echo $employee['first_name']; ?>" required>
        <input type="text" name="middle_name" placeholder="Middle Name" value="<?php echo $employee['middle_name']; ?>">
        <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $employee['last_name']; ?>" required>
        <input type="text" name="address" placeholder="Address" value="<?php echo $employee['address']; ?>" required>
        <input type="text" name="email" placeholder="Email" value="<?php echo $employee['email']; ?>" required>
        <input type="text" name="phone" placeholder="Phone" value="<?php echo $employee['phone']; ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>