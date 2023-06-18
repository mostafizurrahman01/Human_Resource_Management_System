<?php
// Start the session and connect to the database
session_start();
$conn = oci_connect('scott2', '123', '//localhost/XE');

// Check if the user is logged in
if (!isset($_SESSION['USERNAME'])) {
    header('Location: login.php');
    exit;
}

// Check if the user ID was provided
if (!isset($_POST['user_id'])) {
    header('Location: admin.php');
    exit;
}

// Prepare the SQL statement to call the stored procedure for deleting the user
$sql = 'BEGIN delete_user(:user_id); END;';
$statement = oci_parse($conn, $sql);
oci_bind_by_name($statement, ':user_id', $_POST['user_id']);

// Execute the SQL statement
oci_execute($statement);

// Close the statement
oci_free_statement($statement);

// Close the database connection
oci_close($conn);

// Redirect the user back to the admin panel
header('Location: admin.php');
exit;
?>
