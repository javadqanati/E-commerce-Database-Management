<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deleting a Shipping</title>
</head>
<body>
    <?php
    require("DBconnection.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ShippingID'])) {
        $ShippingID = intval($_POST['ShippingID']);
        $conn->begin_transaction();

        try {
            $orderQuery = "SELECT OrderID FROM Shipping WHERE ShippingID = $ShippingID";
            $orderResult = $conn->query($orderQuery);

            if ($orderResult->num_rows === 0) {
                throw new Exception("No Order associated with this Shipping ID.");
            }

            $orderRow = $orderResult->fetch_assoc();
            $OrderID = $orderRow['OrderID'];

            $detailsQuery = "SELECT ProductID, Quantity FROM OrderDetails WHERE OrderID = $OrderID";
            $detailsResult = $conn->query($detailsQuery);

            while ($detail = $detailsResult->fetch_assoc()) {
                $ProductID = $detail['ProductID'];
                $Quantity = $detail['Quantity'];

                $updateStockQuery = "UPDATE Products SET StockQuantity = StockQuantity + $Quantity WHERE ProductID = $ProductID";
                $conn->query($updateStockQuery);
            }

            $deleteDetailsQuery = "DELETE FROM OrderDetails WHERE OrderID = $OrderID";
            $conn->query($deleteDetailsQuery);

            $deleteShippingQuery = "DELETE FROM Shipping WHERE ShippingID = $ShippingID";
            $conn->query($deleteShippingQuery);

            $deleteOrdersQuery = "DELETE FROM Orders WHERE OrderID = $OrderID";
            $conn->query($deleteOrdersQuery);

            $conn->commit();
            echo "<p>Shipping and associated records deleted successfully. Product quantities have been updated.</p>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Error deleting shipping: " . $e->getMessage() . "</p>";
        }

        echo "<form method='POST' action='shippings.php'>
                <button type='submit'>Back to Shippings</button>
              </form>";
    } else {
        echo "<p>Invalid request. No ShippingID provided.</p>";
        echo "<form method='POST' action='shippings.php'>
                <button type='submit'>Back to Shippings</button>
              </form>";
    }

    $conn->close();
    ?>
</body>
</html>
