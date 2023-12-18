<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Employee</title>
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

        button.btn,
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
	<h2>Edit Employee</h2>
		<?php
		include "../connect.php"; // Include the database connection file

		if (isset($_GET['id'])) {
			try {
				$employeeId = $_GET['id'];

				// Fetch employee details from the database based on ID
				$stmt = $conn->prepare("SELECT * FROM employee WHERE emp_id = ?");
				$stmt->bind_param("i", $employeeId);
				$stmt->execute();
				$result = $stmt->get_result();
				$employeeDetails = $result->fetch_assoc();

				// Display edit form with pre-filled employee details for editing
				if ($employeeDetails) {
					// Display an HTML form pre-filled with the employee details for editing
					echo "<form action='update_employee.php' method='POST'>
							<input type='hidden' name='emp_id' value='{$employeeDetails['emp_id']}'>
							User Code: <input type='text' name='user_code' value='{$employeeDetails['user_code']}'><br>
							Name: <input type='text' name='name' value='{$employeeDetails['name']}'><br>
							Department: <input type='text' name='department' value='{$employeeDetails['department']}'><br>
							Email: <input type='text' name='email' value='{$employeeDetails['email']}'><br>
							Phone: <input type='text' name='phone' value='{$employeeDetails['phone']}'><br>
							Address: <input type='text' name='address' value='{$employeeDetails['address']}'><br>
							Position: <input type='text' name='position' value='{$employeeDetails['position']}'><br>
							User ID: <input type='text' name='user_id' value='{$employeeDetails['user_id']}'><br>
							<div class='button-container'>
								<button type='submit' name='update' class='btn'>Update</button>
								<button type='button' onclick='cancelEdit()' class='cancel-btn'>Cancel</button>
							</div>
						  </form>";
				} else {
					echo "Employee not found.";
				}
			} catch (Exception $e) {
				echo "Error: " . $e->getMessage();
			}
		} else {
			echo "Employee ID not provided.";
		}
	?>


    <script>
        function cancelEdit() {
            window.location.href = '../employee_maintenance.php';
        }
    </script>
</body>
</html>
