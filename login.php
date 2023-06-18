<?php
session_start();

try {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // connect to database
        $conn = oci_connect('scott2', '123', '//localhost/XE');

        // Check connection
        if (!$conn) {
            throw new Exception('Failed to connect to Oracle');
        }

        // prepare SQL statement
        $sql = "BEGIN :result := validate_login(:username, :password); END;";

        $stmt = oci_parse($conn, $sql);

        if (!$stmt) {
            $m = oci_error($conn);
            throw new Exception('Could not parse statement: ' . $m['message']);
        }

        // Bind the result variable
        $result = 0;
        oci_bind_by_name($stmt, ":result", $result, -1, SQLT_INT);

        // Bind the parameters
        oci_bind_by_name($stmt, ":username", $_POST['username']);
        oci_bind_by_name($stmt, ":password", $_POST['password']);

        // Execute the statement
        $r = oci_execute($stmt);
        if (!$r) {
            $m = oci_error($stmt);
            throw new Exception('Could not execute statement: ' . $m['message']);
        }

        // Check the result
        if ($result == 1) {
            echo '<p class="correct">Login successful!</p>';
            $_SESSION['USERNAME'] = $_POST['username'];
            header("Location: admin.php");
            exit();
        } else {
            echo '<p class="error">Invalid username or password.</p>';
        }

        oci_free_statement($stmt);
        oci_close($conn);
    }
} catch (Exception $e) {
    echo '<p class="error">' . $e->getMessage() . '</p>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style type="text/css">
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
		}

		.container {
			margin: 50px auto;
			width: 400px;
			background-color: #fff;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
		}

		h2 {
			margin-top: 0;
			text-align: center;
			color: #555;
		}
		h1 {
			margin-top: 0;
			text-align: center;
			color: #555;
		}

		form {
			display: flex;
			flex-direction: column;
			align-items: center;
		}

		input[type=text], input[type=email], input[type=password] {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			box-sizing: border-box;
			border: 2px solid #ccc;
			border-radius: 4px;
			background-color: #f8f8f8;
			font-size: 16px;
		}

		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			font-size: 16px;
		}

		input[type=submit]:hover {
			background-color: #45a049;
		}
	</style>
</head>
<body>
	<h1>Human Resource Management System</h1>
	<div class="container">
		<h2>Login</h2>
		<form method="post" action="login.php">
			<label for="username">Username:</label>
			<input type="text" id="username" name="username" placeholder="Enter a username">

			<label for="password">Password:</label>
			<input type="password" id="password" name="password" placeholder="Enter a password">

			<input type="submit" name="submit" value="Login">
		</form>
	</div>
</body>
</html>
