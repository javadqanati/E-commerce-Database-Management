<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <?php
    require("DBconnection.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductID']) && isset($_POST['CategoryID'])) {
        $ProductID = intval($_POST['ProductID']);
        $CategoryID = intval($_POST['CategoryID']);
        $conn->begin_transaction();

        try {
            $deleteSupplierProductQuery = "DELETE FROM Supplier_Products WHERE ProductID = $ProductID";
            $conn->query($deleteSupplierProductQuery);

            $deleteProductQuery = "DELETE FROM Products WHERE ProductID = $ProductID";
            $conn->query($deleteProductQuery);

            $conn->commit();
            echo "<p>Product and associated supplier relationship deleted successfully.</p>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Error deleting product: " . $e->getMessage() . "</p>";
        }

        echo "<form method='POST' action='products.php'>
                <input type='hidden' name='CategoryID' value='$CategoryID'>
                <button class='btn-primary'  type='submit'>Back to Products</button>
              </form>";
    } else {
        echo "<p>Invalid request. No ProductID or CategoryID provided.</p>";
        echo "<form method='POST' action='products.php'>
                <input type='hidden' name='CategoryID' value='" . (isset($_POST['CategoryID']) ? $_POST['CategoryID'] : '') . "'>
                <button class='btn-primary'  type='submit'>Back to Products</button>
              </form>";
    }

    $conn->close();
    ?>
</body>
</html>
