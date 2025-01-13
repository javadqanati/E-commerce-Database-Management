<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleting an Order</title>
</head>
<body>
    <?php
        require("DBconnection.php");

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['OrderID'])) {
            $OrderID = intval($_POST['OrderID']);
            $conn->begin_transaction();

            try {
                $sql1 = "DELETE FROM OrderDetails WHERE OrderID = $OrderID";
                $conn->query($sql1);

                $sql2 = "DELETE FROM Shipping WHERE OrderID = $OrderID";
                $conn->query($sql2);

                $sql3 = "DELETE FROM Orders WHERE OrderID = $OrderID";
                $conn->query($sql3);

                $conn->commit();
                echo "<p>Order and associated records deleted successfully.</p>";
                echo "<form method='POST' action='orders.php'><button type='submit'>Back to Orders</button></form>";
            } catch (Exception $e) {
                $conn->rollback();
                echo "<p>Error deleting order: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>Invalid request. No OrderID provided.</p>";
        }

        $conn->close();
    ?>
</body>
</html>
