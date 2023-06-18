<!DOCTYPE html>
<html>
<head>
	<title>Add Employee</title>
</head>
<body>
	<h1>Add Employee</h1>
	<!-- <p><a href="view_employee.php">Back to View Employee</a></p> -->

	<?php if (!empty($errors)): ?>
		<ul>
			<?php foreach ($errors as $error): ?>
				<li><?php echo $error; ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<form method="post" action="add_employee_sub.php">
        <label>ID:</label>
		<input type="text" name="employee_id" required>
		<br>
        <label>Name:</label>
		<input type="text" name="name" required>
		<br>
		<label>Email:</label>
			<input type="email" name="email" required>
		<br>
        <label>Hire Date:</label>
		<input type="date" name="hire_date" required>
		<br>
		<label>Salary:</label>
		<input type="number" name="salary" required>
		<br>
		<input type="submit" value="Add Employee">
	</form>
</body>
</html>