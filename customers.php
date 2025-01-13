<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Management</title>
    </head>
    <body>
    <link rel="stylesheet" href="style.css">
        <?php
            require('DBconnection.php');
            echo "<h2 class = 'h2-title'>Customer Management</h2>";
            echo "<button class='btn-primary'><a class='back_link' href='admin_dashboard.php'>Home</a></button> |
            <button class='btn-primary'><a class='back_link' href='add_customer.php'>Add a customer</a></button>";
        ?>
        <br><br>
        <form class="input" method="POST" action="customers.php">
            <label for="CustomerID">Search Customer by ID:</label>
            <input type="number" name="CustomerID" id="CustomerID">
            <button class='btn-primary' type="submit">Search</button>
        </form>

        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID'])) {
                $CustomerID = intval($_POST['CustomerID']);
                echo " | <button class='btn-primary'><a class='back_link' href='customers.php'>Back to Customers</a></button>";
                $sql = "SELECT * FROM Customers WHERE CustomerID = $CustomerID";
            } else {
                $sql = "SELECT * FROM Customers";
            }
            
            $result = $conn->query($sql);


            echo "<table class='table-style'>";
            echo "<tr><th>Customer ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Address</th><th>Actions</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['CustomerID']}</td>";
                echo "<td>{$row['Name']}</td>";
                echo "<td>{$row['Email']}</td>";
                echo "<td>{$row['Phone']}</td>";
                echo "<td>{$row['Address']}</td>";
                echo "<td>
                    <form method='POST' action='update_customer.php' style='display:inline;'>
                        <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                        <button class='btn-secondary' type='submit'>Edit</button>
                    </form>
                    |
                    <form method='POST' action='delete_customer.php' style='display:inline;' onsubmit='return confirm(\"Are you sure?\");'>
                        <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                        <button class='btn-danger' type='submit'>Delete</button>
                    </form>
                    |
                    <form method='POST' action='add_order.php' style='display:inline;'>
                        <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                        <button class='btn-secondary' type='submit'>Add Order</button>
                    </form>
                    |
                    <form method='POST' action='orders.php' style='display:inline;'>
                        <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                        <button class='btn-secondary' type='submit'>See Orders</button>
                    </form>
                    |
                    <form method='POST' action='add_review.php' style='display:inline;'>
                        <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                        <button class='btn-secondary' type='submit'>Add Review</button>
                    </form>
                    |
                    <form method='POST' action='reviews.php' style='display:inline;'>
                        <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                        <input type='hidden' name='name' value='{$row['Name']}'>
                        <button class='btn-secondary' type='submit'>See Reviews</button>
                    </form>
                    </td>";
                echo "</tr>";
            }
            echo "</table>";
            $conn->close();
        ?>
    </body>
</html>
