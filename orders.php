<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
</head>
<body>
    <link rel="stylesheet" href="style.css">

    <?php
    require("DBconnection.php");

    echo "<h2 class='h2-title'>Order Management</h2>";

    echo "<form method='POST' action='admin_dashboard.php' style='display: inline;'>
            <button class='btn-primary' type='submit'>Home</button>
          </form>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID'])) {
        $CustomerID = intval($_POST['CustomerID']);
        $sql = "SELECT * FROM Orders WHERE CustomerID = $CustomerID";

        echo "<form method='POST' action='customers.php' style='display: inline;'>
                <button class='btn-primary' type='submit'>Back to Customers</button>
              </form>";
    } else {
        $sql = "SELECT * FROM Orders";
    }

    $result = $conn->query($sql);


    echo "<table class='table-style'>";
    echo "<tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Customer ID</th>
            <th>Actions</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['OrderID']}</td>";
        echo "<td>{$row['OrderDate']}</td>";
        echo "<td>{$row['TotalAmount']}</td>";
        echo "<td>{$row['CustomerID']}</td>";
        echo "<td class='action-buttons'>
            <form method='POST' action='delete_order.php' style='display: inline;'>
                <input type='hidden' name='OrderID' value='{$row['OrderID']}'>
                <button class='btn-danger' type='submit' onclick='return confirm(\"Are you sure?\");'>Delete</button>
            </form> | 
            <form method='POST' action='order_detail.php' style='display: inline;'>
                <input type='hidden' name='OrderID' value='{$row['OrderID']}'>
                <button class='btn-secondary' type='submit'>Order Details</button>
            </form> | 
            <form method='POST' action='customers.php' style='display: inline;'>
                <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                <button class='btn-secondary' type='submit'>Customer Details</button>
            </form> | 
            <form method='POST' action='add_review.php' style='display: inline;'>
                <input type='hidden' name='CustomerID' value='{$row['CustomerID']}'>
                <button class='btn-secondary' type='submit'>Add Review</button>
            </form>
           </td>";
        echo "</tr>";
    }
    echo "</table>";

    $conn->close();
    ?>
</body>
</html>
