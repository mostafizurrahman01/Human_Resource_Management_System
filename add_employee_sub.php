<?php
// Establish a connection to the database
$conn = oci_connect('scott2', '123', '//localhost/XE');

// Check if the connection is successful
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Get the form data
$employee_id = $_POST['employee_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$hire_date = $_POST['hire_date'];
$salary = $_POST['salary'];

// Insert values into the employees table
$query = "
    INSERT INTO employees (employee_id, name, email, hire_date, salary)
    VALUES (:employee_id, :name, :email, TO_DATE(:hire_date, 'YYYY-MM-DD'), :salary)
";

// Prepare the query
$stmt = oci_parse($conn, $query);

// Bind the values to the placeholders
oci_bind_by_name($stmt, ':employee_id', $employee_id);
oci_bind_by_name($stmt, ':name', $name);
oci_bind_by_name($stmt, ':email', $email);
oci_bind_by_name($stmt, ':hire_date', $hire_date);
oci_bind_by_name($stmt, ':salary', $salary);

// Execute the query
$result = oci_execute($stmt);

// Check if the insertion was successful
if ($result) {
    echo "Employee added successfully.";
} else {
    $e = oci_error($stmt);
    echo "Error adding employee: " . htmlentities($e['message'], ENT_QUOTES);
}

// Close the database connection
oci_close($conn);
?>
