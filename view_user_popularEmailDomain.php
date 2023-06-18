<?php
  

  session_start();
  // Connect to Oracle database
  $conn = oci_connect('scott2', '123', '//localhost/XE');
  
  // SQL query to create a view
  $query = "CREATE VIEW popular_email_domains AS 
  SELECT SUBSTR(users.email, INSTR(users.email, '@') + 1) AS domain, COUNT(users.user_id) AS num_users 
  FROM users 
  GROUP BY SUBSTR(users.email, INSTR(users.email, '@') + 1) 
  ORDER BY num_users DESC";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);
  
  // SQL query to fetch data from the view
  $query = "SELECT * FROM popular_email_domains";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);

  echo "<p> <a href = 'customers.php'> Back </a></p> ";
  
  // Display the data in a table
  echo "<table>";
  echo "<tr><th>Domain</th><th>Number of Users</th></tr>";
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['DOMAIN'] . "</td>";
    echo "<td>" . $row['NUM_USERS'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
  
  // Close the Oracle connection
  oci_close($conn);
?>
