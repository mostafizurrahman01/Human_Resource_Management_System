<?php

// Create connection to Oracle
$conn = oci_connect('scott2', '123', '//localhost/XE');

if (!$conn) {
  
$m = oci_error();
  
echo $m['message'], "\n";
 
exit;

}

// Close the Oracle connection

oci_close($conn);
?>
