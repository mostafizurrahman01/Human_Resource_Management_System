<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>View Users</title>
</head>
<body>
    <p><a href="admin.php">Back</a></p>

	<table>
		<tr>
            <th>ID</th>
            <th>Name</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Delete</th>
		    <th>Edit</th>
		</tr>
		<?php
		// Connect to the database
		$conn = oci_connect('scott2', '123', '//localhost/XE');

		// Prepare the SQL statement to retrieve all users from the database
		$sql = "SELECT * FROM users";
		$statement = oci_parse($conn, $sql);

		// Execute the SQL statement
		oci_execute($statement);

		// Fetch all users from the result set and display them in a table
		while ($user = oci_fetch_assoc($statement)) {
			echo '<tr>';
            echo '<td>' . $user['USER_ID'] . '</td>';
            echo '<td>' . $user['NAME'] . '</td>';
            echo '<td>' . $user['USERNAME'] . '</td>';
            echo '<td>' . $user['EMAIL'] . '</td>';
            echo '<td>' . $user['PASS'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="delete_user.php">';
            echo '<input type="hidden" name="user_id" value="' . $user['USER_ID'] . '">';
            echo '<input type="submit" value="Delete">';
            echo '</form>';
            echo '</td>';
            echo '<td>';
            echo '<a href="edit_user.php?user_id=' . $user['USER_ID'] . '">Edit</a>';
            echo '</td>';
            echo '</tr>';
		    }
		?>
	</table>
</body>
</html>
