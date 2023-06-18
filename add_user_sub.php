<?php
// Connect to the database
$conn = oci_connect('scott2', '123', '//localhost/XE');

// Retrieve the user data from the form submission
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

try {
    // Prepare the SQL statement to call the stored procedure
    $sql = "BEGIN add_user(:name, :username, :email, :password, :user_id); END;";
    $statement = oci_parse($conn, $sql);

    // Bind the values from the form submission to the SQL statement
    oci_bind_by_name($statement, ':name', $name);
    oci_bind_by_name($statement, ':username', $username);
    oci_bind_by_name($statement, ':email', $email);
    oci_bind_by_name($statement, ':password', $password);
    oci_bind_by_name($statement, ':user_id', $user_id, -1, SQLT_INT);

    // Execute the SQL statement
    $result = oci_execute($statement);

    // Check if the user was successfully added to the database
    if ($result) {
        echo "User added successfully";
        header("Location: registered_user.php");
    } else {
        echo "Error adding user";
    }

    // Close the statement
    oci_free_statement($statement);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
oci_close($conn);
?>
