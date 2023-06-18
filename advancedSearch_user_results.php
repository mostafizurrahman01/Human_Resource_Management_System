<?php
session_start();

if (isset($_GET['username']) && isset($_GET['email'])) {
    $username = $_GET['username'];
    $email = $_GET['email'];

    // Connect to the database
    $conn = oci_connect('scott2', '123', '//localhost/XE');

    // Prepare the SQL statement to call the advanced_user_search function
    $sql = "BEGIN :result := advanced_user_search(:username, :email); END;";
    $statement = oci_parse($conn, $sql);

    // Bind the output cursor variable
    $result = oci_new_cursor($conn);
    oci_bind_by_name($statement, ':result', $result, -1, OCI_B_CURSOR);

    // Bind the search term parameters
    oci_bind_by_name($statement, ':username', $username);
    oci_bind_by_name($statement, ':email', $email);

    // Execute the SQL statement
    oci_execute($statement);

    // Fetch the result from the cursor
    oci_execute($result);

    // Display the results
    echo "<h2>Results:</h2>";
    echo "<table>";
    echo "<tr><th>Name</th><th>User Name</th><th>Email</th><th>Password</th><th>User ID</th></tr>";
    while ($user = oci_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $user['NAME'] . "</td>";
        echo "<td>" . $user['USERNAME'] . "</td>";
        echo "<td>" . $user['EMAIL'] . "</td>";
        echo "<td>" . $user['PASS'] . "</td>";
        echo "<td>" . $user['USER_ID'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Close the cursor
    oci_free_statement($result);

    // Close the database connection
    oci_close($conn);
} else {
    echo "User not found";
}
?>