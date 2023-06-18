<?php
  

  session_start();
  // Connect to Oracle database
  $conn = oci_connect('scott2', '123', '//localhost/XE');
  
  // SQL query to create a view
  $query = "CREATE VIEW user_count_by_city AS
  SELECT ui.address, COUNT(*) AS user_count
  FROM users u
  INNER JOIN users_info ui ON u.user_id = ui.user_id
  GROUP BY ui.address";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);
  
  // SQL query to fetch data from the view
  $query = "SELECT * FROM user_count_by_city";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);

  echo "<p> <a href = 'customers.php'> Back </a></p> ";
  
  // Display the data in a table
  echo "<table>";
  echo "<tr><th>Address</th><th>Count User</tr>";
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['ADDRESS'] . "</td>";
    echo "<td>" . $row['USER_COUNT'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
  
  // Close the Oracle connection
  oci_close($conn);
?>
