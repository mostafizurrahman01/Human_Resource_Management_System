<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<style>
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
		}

		nav {
			background-color: #333;
			color: #fff;
			padding: 10px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		nav ul {
			margin: 0;
			padding: 0;
			display: flex;
		}

		nav li {
			list-style: none;
			margin-right: 20px;
		}

		nav a {
			color: #fff;
			text-decoration: none;
			font-weight: bold;
			font-size: 16px;
			padding: 10px;
			border-radius: 5px;
			transition: background-color 0.3s ease;
		}

		nav a:hover {
			background-color: #666;
		}
        .container-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            margin: 20px;
        }

        .container {
            background-color: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: box-shadow 0.3s ease;
        }

        .container:hover {
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
        }

        .container h2 {
            margin-bottom: 20px;
            color: #555;
        }

        .container a {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            width: 200px;
            transition: background-color 0.3s ease;
        }

        .container a:hover {
            background-color: #3e8e41;
        }
	</style>
</head>
<body>
    <h1>Customer</h1>
	<nav>
        <ul>
            <li>Welcome, <?php echo $_SESSION['USERNAME']; ?></li>
            <li><a href="admin.php">Back</a></li>
            <li><a href="logout.php">Logout</a></li>
            
        </ul>
    </nav>
        <div class = "container-wrapper">
            <div class="container">
                <h2>Registered Users</h2>
                <a href="registered_user.php">View</a>
            </div>
            <div class="container">
                <h2>Add User</h2>
                <a href="add_user1.php">Add</a>
            </div>
            <div class="container">
                <h2>Search User</h2>
                <a href="search_user.php">Search</a>
            </div>
            <div class="container">
                <h2>Advanced User Search</h2>
                <a href="advancedSearch_user.php">Advanced Search</a>
            </div>
            <div class="container">
                <h2>User Details</h2>
                <a href="view_user_details.php">View Details</a>
            </div>
            <div class="container">
                <h2>Users Without Phone Numbers</h2>
                <a href="view_user_without_phone.php">View List</a>
            </div>
            <div class="container">
                <h2>Popular Email Domain</h2>
                <a href="view_user_popularEmailDomain.php">View</a>
            </div>
            <div class="container">
                <h2>Users with Incomplete Address</h2>
                <a href="view_user_incompleteAddress.php">View List</a>
            </div>
            <div class="container">
                <h2>Users Count by Location</h2>
                <a href="view_user_countByCity.php">View Count</a>
            </div>
        </div>
        
	
</body>
</html>
