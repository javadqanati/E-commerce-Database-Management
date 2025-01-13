<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <?php
    
    echo "<h1 class = 'h2-title'>Order Details</h1><br>";
    require("DBconnection.php");

    if ($conn == null) {
        exit("Database connection failed!");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['OrderID'])) {
        $OrderID = intval($_POST['OrderID']);
        echo "<form method='POST' action='orders.php' style='display: inline;'>
                <button class='btn-primary' type='submit'>View all Orders</button>
              </form> |
              <form method='POST' action='shippings.php' style='display: inline;'>
                <button class='btn-primary' type='submit'>View all Shippings</button>
              </form>";

        $sql = "SELECT * FROM OrderDetails WHERE OrderID = $OrderID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table-style'>";
            echo "<tr>
                    <th>OrderDetailID</th>
                    <th>OrderID</th>
                    <th>ProductID</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['OrderDetailID'] . "</td>";
                echo "<td>" . $row['OrderID'] . "</td>";
                echo "<td>" . $row['ProductID'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "<td>" . $row['Subtotal'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No order details found for OrderID = $OrderID";
        }
    } else {
        echo "<p>Invalid request. OrderID not provided.</p>";
        echo "<form method='POST' action='orders.php'>
                <button type='submit'>Back to Orders</button>
              </form>";
    }

    $conn->close();
    ?>
</body>
</html>
