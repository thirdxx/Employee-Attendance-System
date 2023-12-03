<?php
// MySQL database connection
$host = "localhost";
$dbname = "EmployeeAttendanceSystem";
$username = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $lastName = $_POST['last_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert new employee into the database
        $stmt = $pdo->prepare("INSERT INTO employee (first_name, middle_name, last_name, address, email, phone) VALUES (:first_name, :middle_name, :last_name, :address, :email, :phone)");
        $stmt->bindParam(":first_name", $firstName);
        $stmt->bindParam(":middle_name", $middleName);
        $stmt->bindParam(":last_name", $lastName);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->execute();

        // Redirect to employee maintenance page after adding the employee
        header("Location: employee_maintenance.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Employee</title>
	<style>
      /* CSS for bg and button */
      body {
          font-family: Arial, sans-serif;
          background-color: #f0f0f0;
          margin: 0;
          padding: 0;
      }

      h2 {
          text-align: center;
      }

      /* CSS for form */
      form {
          max-width: 600px;
          margin: 0 auto;
          padding: 20px;
          background-color: #fff;
          border: 1px solid #ccc;
          border-radius: 5px;
      }

      label {
          display: block;
          margin-bottom: 10px;
          font-weight: bold;
      }

      input[type="text"] {
          width: 100%;
          max-width: 580px;
          padding: 10px;
          margin-bottom: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
      }
	   
	   /* CSS for button */
      .button-container {
          text-align: center;
      }

      button.btn {
          display: inline-block;
          margin: 10px;
          padding: 10px 20px;
          background-color: #333333;
          color: #ffffff;
          border: none;
          border-radius: 5px;
          cursor: pointer;
		  font-size: 15px;
      }
	  button.cancel-btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #333333;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <h2>Add Employee</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br>
        
        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" id="middle_name" required><br>
        
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br>
        
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required><br>
        
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br>
        
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required><br>
        
        <div class="button-container">
			<button type="submit" name="add" class="btn">Add Employee</button>
			<a href="../employee_maintenance.php">
				<button type="button" class="cancel-btn">Cancel</button>
			</a>
		</div>
    </form>
</body>
</html>
