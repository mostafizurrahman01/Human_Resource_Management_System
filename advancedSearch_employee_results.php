<?php
// Database connection code here
session_start();
$conn = oci_connect('scott2', '123', '//localhost/XE');

// Get search criteria from form
$id = $_POST['id'];
$email = $_POST['email'];


// Build SQL query based on search criteria
$sql = "SELECT * FROM employees WHERE 1=1";
if (!empty($id)) {
    $sql .= " AND employee_id LIKE '%$id%'";
}
if (!empty($email)) {
    $sql .= " AND email LIKE '%$email%'";
}

// Execute query
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);

// Display search results
echo "<h1>Search Results</h1>";
echo "<table border='1'>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Hire-Date</th>
        <th>Salary</th>
    </tr>";
while ($row = oci_fetch_array($stmt, OCI_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row['EMPLOYEE_ID'] . "</td>";
    echo "<td>" . $row['NAME'] . "</td>";
    echo "<td>" . $row['EMAIL'] . "</td>";
    echo "<td>" . $row['HIRE_DATE'] . "</td>";
    echo "<td>" . $row['SALARY'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Close database connection
oci_close($conn);
?>
