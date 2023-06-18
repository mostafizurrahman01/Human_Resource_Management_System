<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Employee</title>
</head>
<body>
    <h1>Search Employee</h1> <p><a href="employees.php">Back</a></p>
    <form method="get" action="">
        <label for="searchTerm">Search:</label>
        <input type="text" name="searchTerm" id="searchTerm">
        <input type="submit" value="Search">
    </form>

    <?php
        if (isset($_GET['searchTerm'])) {
            $searchTerm = $_GET['searchTerm'];
            $conn = oci_connect('scott2', '123', '//localhost/XE');
            $sql = "SELECT * FROM employees WHERE name LIKE '%" . $searchTerm . "%' OR employee_id LIKE '%" . $searchTerm . "%'";
            $statement = oci_parse($conn, $sql);
            oci_execute($statement);
            echo "<h2>Results:</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Hire-Date</th><th>Salary</th></tr>";
            while ($employee = oci_fetch_assoc($statement)) {
                echo "<tr>";
                echo "<td>" . $employee['EMPLOYEE_ID'] . "</td>";
                echo "<td>" . $employee['NAME'] . "</td>";
                echo "<td>" . $employee['EMAIL'] . "</td>";
                echo "<td>" . $employee['HIRE_DATE'] . "</td>";
                echo "<td>" . $employee['SALARY'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        else{
            echo "user not found";
        }
    ?>


</body>
</html>
