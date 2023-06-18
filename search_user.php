<?php
session_start();

if (isset($_GET['searchTerm'])) {
    $searchTerm = $_GET['searchTerm'];
    $conn = oci_connect('scott2', '123', '//localhost/XE');

    // Prepare the SQL statement to call the user_search function
    $sql = "BEGIN :result := user_search(:searchTerm); END;";
    $statement = oci_parse($conn, $sql);

    // Bind the output cursor variable
    $result = oci_new_cursor($conn);
    oci_bind_by_name($statement, ':result', $result, -1, OCI_B_CURSOR);

    // Bind the search term parameter
    oci_bind_by_name($statement, ':searchTerm', $searchTerm);

    // Execute the SQL statement
    oci_execute($statement);

    // Fetch the result from the cursor
    oci_execute($result);

    // Display the results
    echo "<h2>Results:</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>User Name</th><th>Email</th><th>Password</th></tr>";
    while ($user = oci_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $user['USER_ID'] . "</td>";
        echo "<td>" . $user['NAME'] . "</td>";
        echo "<td>" . $user['USERNAME'] . "</td>";
        echo "<td>" . $user['EMAIL'] . "</td>";
        echo "<td>" . $user['PASS'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Close the cursor
    oci_free_statement($result);
} else {
    echo "User not found";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search User</title>
</head>
<body>
    <h1>Search User</h1>
    <form method="get" action="">
        <label for="searchTerm">Search:</label>
        <input type="text" name="searchTerm" id="searchTerm">
        <input type="submit" value="Search">
    </form>

    <p><a href="customers.php">Back</a></p>

</body>
</html>
