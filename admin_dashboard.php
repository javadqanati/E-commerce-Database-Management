<?php
    session_start();

    if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== "yes") {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <link rel="stylesheet" href="style.css">
    <div style="display: flex; justify-content: center; align-items: center;">
        <div><img style="width: 100px;" src="./data/logounime.png" alt="Unime"></div>
        <div style="margin-left: 15px; border-left: solid black 2px; padding: 15px;">Database mod. A project by Mohammadjavad Qanati<br><br> mohammadjavad.qanati@studenti.unime.it<br>556711</div>
    </div>

    <div style="margin: 25px 70px; border: dotted gray 2px; padding: 50px 0px">
        <h1 class = 'h2-title'>Admin Dashboard</h1>
        <p style="text-align: center;">Welcome to the Admin Dashboard! Use the links below to manage your data.</p><br>
        <nav style="text-align: center;">
            <button class='btn-primary'><a class='back_link' href="customers.php">Manage Customers</a></button>
            <button class='btn-primary'><a class='back_link' href="orders.php">Manage Orders</a></button>
            <button class='btn-primary'><a class='back_link' href="categories.php">Manage Products</a></button>
            <button class='btn-primary'><a class='back_link' href="suppliers.php">Manage Suppliers</a></button>
            <button class='btn-primary'><a class='back_link' href="shippings.php">Manage Shippings</a></button>
            <button class='btn-primary'><a class='back_link' href="logout.php">Logout</a></button>
        </nav>
    </div>
    
</body>
</html>
