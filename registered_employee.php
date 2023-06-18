<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Employees</title>
</head>
<body>
    <p><a href="admin.php">Back</a></p>

	<table>
		<tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Hire Date</th>
            <th>Salary</th>
            <th>Delete</th>
		    <th>Edit</th>
		</tr>
		<?php
		// Connect to the database
		$conn = oci_connect('scott2', '123', '//localhost/XE');

		// Prepare the SQL statement to retrieve all users from the database
		$sql = "SELECT * FROM employees";
		$statement = oci_parse($conn, $sql);

		// Execute the SQL statement
		oci_execute($statement);

		// Fetch all users from the result set and display them in a table
		while ($employee = oci_fetch_assoc($statement)) {
			echo '<tr>';
            echo '<td>' . $employee['EMPLOYEE_ID'] . '</td>';
            echo '<td>' . $employee['NAME'] . '</td>';
            echo '<td>' . $employee['EMAIL'] . '</td>';
            echo '<td>' . $employee['HIRE_DATE'] . '</td>';
            echo '<td>' . $employee['SALARY'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="delete_user.php">';
            echo '<input type="hidden" name="employee_id" value="' . $employee['EMPLOYEE_ID'] . '">';
            echo '<input type="submit" value="Delete">';
            echo '</form>';
            echo '</td>';
            echo '<td>';
            echo '<a href="edit_employee.php?user_id=' . $employee['EMPLOYEE_ID'] . '">Edit</a>';
            echo '</td>';
            echo '</tr>';
		    }
		?>
	</table>
</body>
</html>
