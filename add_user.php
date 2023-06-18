<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input values from the form submission
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate the input values
    $errors = array();
    if (empty($id)) {
        $errors[] = 'id is required';
    }
    if (empty($name)) {
        $errors[] = 'Name is required';
    }
    if (empty($username)) {
        $errors[] = 'Username is required';
    }
    if (empty($email)) {
        $errors[] = 'Email is required';
    }
    if (empty($password)) {
        $errors[] = 'Password is required';
    }

    // If there are no errors, insert the new user into the database
    if (empty($errors)) {
        // Connect to the database
        $conn = oci_connect('scott2', '123', '//localhost/XE');

        // Prepare the SQL statement to insert the new user into the database
        $sql = "INSERT INTO users (name, username, email, pass, id) VALUES (:name, :username, :email, :pass, :user_id)";
        $statement = oci_parse($conn, $sql);

        // Bind the input values to the SQL statement
        oci_bind_by_name($statement, ':id', $id);
        oci_bind_by_name($statement, ':name', $name);
        oci_bind_by_name($statement, ':username', $username);
        oci_bind_by_name($statement, ':email', $email);
        oci_bind_by_name($statement, ':pass', $password);

        // Execute the SQL statement
        oci_execute($statement);

        // Redirect to the view users page
        header('Location: admin.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<h1>Add User</h1>
	<p><a href="view_users.php">Back to View Users</a></p>

	<?php if (!empty($errors)): ?>
		<ul>
			<?php foreach ($errors as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<form method="post">
        <p>
			<label for="id">ID:</label>
			<input type="text" name="id" id="name">
		</p>
		<p>
			<label for="name">Name:</label>
			<input type="text" name="name" id="name">
		</p>
		<p>
			<label for="username">Username:</label>
			<input type="text" name="username" id="username">
		</p>
		<p>
			<label for="email">Email:</label>
			<input type="email" name="email" id="email">
		</p>
		<p>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password">
		</p>
		<p>
			<input type="submit" value="Add User">
		</p>
	</form>
</body>
</html>
