<?php

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validate name
    if(empty($name)) {
        $name_error = "Please enter your name.";
    } elseif(!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $name_error = "Name can only contain letters and spaces.";
    }

    // Validate username
    if(empty($username)) {
        $username_error = "Please enter a username.";
    } elseif(!preg_match("/^[a-zA-Z0-9_]+$/",$username)) {
        $username_error = "Username can only contain letters, numbers, and underscores.";
    }

    // Validate email
    if(empty($email)) {
        $email_error = "Please enter your email address.";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format.";
    }

    // Validate password
    if(empty($password)) {
        $password_error = "Please enter a password.";
    } elseif(strlen($password) < 6) {
        $password_error = "Password must be at least 6 characters.";
    } elseif(!preg_match("/[A-Z]+/", $password)) {
        $password_error = "Password must contain at least one uppercase letter.";
    } elseif(!preg_match("/[a-z]+/", $password)) {
        $password_error = "Password must contain at least one lowercase letter.";
    } elseif(!preg_match("/[0-9]+/", $password)) {
        $password_error = "Password must contain at least one digit.";
    }

    // If there are no errors, insert the user into the database
    if (empty($name_error) && empty($username_error) && empty($email_error) && empty($password_error)) {
        $conn = oci_connect('scott2', '123', '//localhost/XE');

        // Prepare the stored procedure call
        $query = "BEGIN register_user(:p_name, :p_username, :p_email, :p_password); END;";
        $stmt = oci_parse($conn, $query);

        // Bind the parameters
        oci_bind_by_name($stmt, ':p_name', $name);
        oci_bind_by_name($stmt, ':p_username', $username);
        oci_bind_by_name($stmt, ':p_email', $email);
        oci_bind_by_name($stmt, ':p_password', $password);

        // Execute the stored procedure
        $result = oci_execute($stmt);

        if ($result) {
            header('Location: login.php');
            exit();
        } else {
            $trigger_error = "Error occurred while registering the user.";
        }

        // Close database connection
        oci_close($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
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

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Human Resource Management System</h1>
    <div class="container">
        <h2>User Registration</h2>
        <form method="post" action="registration.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter a username">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter a password">

            <input type="submit" name="submit" value="Register">
        </form>
        <?php if(isset($trigger_error)) { ?>
            <p class="error"><?php echo $trigger_error; ?></p>
        <?php } ?>
        <p class="error"><?php echo isset($name_error) ? $name_error : ''; ?></p>
        <p class="error"><?php echo isset($username_error) ? $username_error : ''; ?></p>
        <p class="error"><?php echo isset($email_error) ? $email_error : ''; ?></p>
        <p class="error"><?php echo isset($password_error) ? $password_error : ''; ?></p>
    </div>
</body>
</html>
