<?php
$host = 'localhost';
$db = 'EmployeeAttendanceSystem';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['add'])) {
        $first_name = $_POST['first_name'];
        $middle_name = $_POST['middle_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO employee (first_name, middle_name, last_name, address, email, phone) VALUES (:first_name, :middle_name, :last_name, :address, :email, :phone)";
        
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':middle_name', $middle_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);

        $stmt->execute();

        header('Location: employee_maintenance.php');
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>