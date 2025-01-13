<?php
require("DBconnection.php");

if ($conn == null) {
    exit();
} else {
    $sql = "SELECT * FROM Shipping";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Shippings</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
<h2 class = 'h2-title'>Shipping Management</h2>
    <form method="POST" action="admin_dashboard.php" style="display:inline;">
        <button class='btn-primary' type="submit">Home</button>
    </form>
    
    <?php
        if ($result->num_rows > 0) {
            echo "<table class='table-style'>";
            echo "<tr>
                    <th>Shipping ID</th>
                    <th>Order ID</th>
                    <th>Shipping Date</th>
                    <th>Shipping Status</th>
                    <th>Actions</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['ShippingID']}</td>";
                echo "<td>{$row['OrderID']}</td>";
                echo "<td>{$row['ShippingDate']}</td>";
                echo "<td>{$row['ShippingStatus']}</td>";
                echo "<td>
                        <form method='POST' action='update_shipping.php' style='display:inline;'>
                            <input type='hidden' name='ShippingID' value='{$row['ShippingID']}'>
                            <button class='btn-secondary' type='submit'>Update</button>
                        </form> | 
                        <form method='POST' action='delete_shipping.php' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this shipping?\");'>
                            <input type='hidden' name='ShippingID' value='{$row['ShippingID']}'>
                            <button class='btn-danger' type='submit'>Delete</button>
                        </form> | 
                        <form method='POST' action='order_detail.php' style='display:inline;'>
                            <input type='hidden' name='OrderID' value='{$row['OrderID']}'>
                            <button class = 'btn-secondary' type='submit'>View Order Details</button>
                        </form>
                    </td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No shippings found.</p>";
        }

        $conn->close();
    ?>
</body>
</html>
