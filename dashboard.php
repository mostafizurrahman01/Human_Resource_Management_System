 <?php
// Connect to database
$conn = oci_connect('scott2', '123', '//localhost/XE');

// Check connection
if (!$conn) {
    echo 'Failed to connect to oracle' . "<br>";
    exit();
}

// Query to fetch data
$query = 'SELECT * FROM users';
$stmt = oci_parse($conn, $query);

if (!$stmt) {
    $message = oci_error($conn);
    trigger_error('Could not parse statement: ' . $message['message'], E_USER_ERROR);
}

$r = oci_execute($stmt);
if (!$r) {
    $message = oci_error($stmt);
    trigger_error('Could not execute statement: ' . $message['message'], E_USER_ERROR);
}

// Close the connection after retrieving data
oci_close($conn);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Table with database</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <div class="home_container">
        <h1>Connected successfully!</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
            <?php
            // Retrieving data as a tuple
            while ($row = oci_fetch_array($stmt, OCI_RETURN_NULLS + OCI_ASSOC)) {
                echo '<tr>';
                echo '<td>' . $row['NAME'] . '</td>';
                echo '<td>' . $row['USERNAME'] . '</td>';
                echo '<td>' . $row['EMAIL'] . '</td>';
                echo '<td>' . $row['PASS'] . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</body>

</html>

