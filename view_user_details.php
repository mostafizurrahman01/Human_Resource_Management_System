<?php
  

  session_start();
  // Connect to Oracle database
  $conn = oci_connect('scott2', '123', '//localhost/XE');
  
  // SQL query to create a view
  $query = "CREATE VIEW user_details AS 
  SELECT users.user_id, users.name, users.email, users_info.address, users_info.phone_number 
  FROM users 
  INNER JOIN users_info 
  ON users.user_id = users_info.user_id";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);
  
  // SQL query to fetch data from the view
  $query = "SELECT * FROM user_details";
  
  // Prepare and execute the query
  $stmt = oci_parse($conn, $query);
  oci_execute($stmt);

  echo "<p> <a href = 'customers.php'> Back </a></p> ";
  
  // Display the data in a table
  echo "<table>";
  echo "<tr><th>User ID</th><th>name</th><th>Email</th><th>Address</th><th>Phone Number</th></tr>";
  while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['USER_ID'] . "</td>";
    echo "<td>" . $row['NAME'] . "</td>";
    echo "<td>" . $row['EMAIL'] . "</td>";
    echo "<td>" . $row['ADDRESS'] . "</td>";
    echo "<td>" . $row['PHONE_NUMBER'] . "</td>";
    echo "</tr>";
  }
  echo "</table>";
  
  // Close the Oracle connection
  oci_close($conn);
?>
