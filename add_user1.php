<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<h1>Add User</h1>
	<!-- <p><a href="view_user.php">Back to View Users</a></p> -->

	<?php if (!empty($errors)): ?>
		<ul>
			<?php foreach ($errors as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<form method="post" action="add_user_sub.php">
        <label>ID:</label>
		<input type="text" name="user_id" required>
		<br>
        <label>Name:</label>
		<input type="text" name="name" required>
		<br>
		<label>Username:</label>
		<input type="text" name="username" required>
		<br>
		<label>Password:</label>
		<input type="password" name="password" required>
		<br>
		<label>Email:</label>
			<input type="email" name="email" required>
		<br>
		<input type="submit" value="Add User">
	</form>
</body>
</html>