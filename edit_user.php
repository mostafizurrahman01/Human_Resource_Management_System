<?php
session_start();

// Connect to the database
$conn = oci_connect('scott2', '123', '//localhost/XE');

// Get the user_id from the query string
$user_id = $_GET['user_id'];

// Prepare the SQL statement to call the stored procedure and retrieve the user with the given ID
$sql = "BEGIN get_user(:user_id, :p_name, :p_username, :p_password, :p_email); END;";
$statement = oci_parse($conn, $sql);

// Bind the user_id parameter to the SQL statement
oci_bind_by_name($statement, ':user_id', $user_id);

// Bind the output variables to retrieve user information from the stored procedure
oci_bind_by_name($statement, ':p_name', $name, 255);
oci_bind_by_name($statement, ':p_username', $username, 255);
oci_bind_by_name($statement, ':p_password', $password, 255);
oci_bind_by_name($statement, ':p_email', $email, 255);

// Execute the SQL statement
oci_execute($statement);

// Check if the user was found
if (empty($name) || empty($username) || empty($password) || empty($email)) {
    // If the user wasn't found, display an error message and exit
    echo "User not found";
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the values from the form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Prepare the SQL statement to call the stored procedure for updating the user
    $sql = "BEGIN update_user(:user_id, :p_name, :p_username, :p_password, :p_email); END;";
    $statement = oci_parse($conn, $sql);

    // Bind the values from the form submission to the SQL statement
    oci_bind_by_name($statement, ':user_id', $user_id);
    oci_bind_by_name($statement, ':p_name', $name);
    oci_bind_by_name($statement, ':p_username', $username);
    oci_bind_by_name($statement, ':p_password', $password);
    oci_bind_by_name($statement, ':p_email', $email);

    // Execute the SQL statement
    $result = oci_execute($statement);

    // Check if the update was successful
    if ($result) {
        // If the update was successful, redirect to the view users page
        header('Location: admin.php');
        exit;
    } else {
        // If the update failed, display an error message
        echo "Error updating user";
    }

    // Close the statement
    oci_free_statement($statement);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form method="post">
        <label>ID:</label>
        <input type="text" name="user_id" value="<?php echo $user_id; ?>" required>
        <br>
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>" required>
        <br>
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $username; ?>" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" value="<?php echo $password; ?>" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>
        <br>
        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
