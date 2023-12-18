<?php
// Include the database connection file
include "../connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userCode = $_POST['user_code'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $position = $_POST['position'];
    $userId = $_POST['user_id'];

    try {
        // Insert new employee into the database
        $stmt = $conn->prepare("INSERT INTO employee (user_code, name, department, email, phone, address, position, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $userCode, $name, $department, $email, $phone, $address, $position, $userId);
        $stmt->execute();

        // Redirect to employee maintenance page after adding the employee
        header("Location: ../employee_maintenance.php");
        exit();
    } catch (Exception $e) {
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
        <label for="user_code">User Code:</label>
        <input type="text" name="user_code" id="user_code" required><br>
        
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        
        <label for="department">Department:</label>
        <input type="text" name="department" id="department" required><br>
        
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required><br>
        
        <label for="position">Position:</label>
        <input type="text" name="position" id="position" required><br>
        
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" id="user_id" required><br>
        
        <div class="button-container">
            <button type="submit" name="add" class="btn">Add Employee</button>
            <a href="../employee_maintenance.php">
                <button type="button" class="cancel-btn">Cancel</button>
            </a>
        </div>
    </form>
</body>
</html>

