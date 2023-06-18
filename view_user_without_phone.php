<?php
  

  session_start();
  // Connect to Oracle database
  $conn = oci_connect('scott2', '123', '//localhost/XE');
  
  // SQL query to create a view
  $query = "CREATE VIEW users_without_phone AS
  SELECT name, username, email
  FROM users
  WHERE user_id NOT IN (
      SELECT user_id
      FROM users_info
      WHERE phone_number IS NOT NULL
  )";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);
  
  // SQL query to fetch data from the view
  $query = "SELECT * FROM users_without_phone";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);

  echo "<p> <a href = 'customers.php'> Back </a></p> ";
  
  // Display the data in a table
//   echo "<table>";
//   echo "<tr><th>Name</th><th>Username</th><th>Email</th></tr>";
//   while ($row = oci_fetch_assoc($stmt)) {
//     echo "<tr>";
//     echo "<td>" . $row['NAME'] . "</td>";
//     echo "<td>" . $row['USERNAME'] . "</td>";
//     echo "<td>" . $row['EMAIL'] . "</td>";
//     echo "</tr>";
//   }
//   echo "</table>";
if (oci_fetch_all($stmt, $data, null, null, OCI_FETCHSTATEMENT_BY_ROW) == 0) {
    echo "No data found.";
} else {
    // Display the data in a table
    echo "<table>";
    echo "<tr><th>Name</th><th>Username</th><th>Email</th></tr>";
    foreach ($data as $row) {
        echo "<tr>";
        echo "<td>" . $row['NAME'] . "</td>";
        echo "<td>" . $row['USERNAME'] . "</td>";
        echo "<td>" . $row['EMAIL'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
  
  // Close the Oracle connection
  oci_close($conn);
?>
