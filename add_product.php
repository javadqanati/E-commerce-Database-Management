<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2 class='h2-title'>Add Product</h2>
    <?php
        require("DBconnection.php");

        if ($conn == null) {
            exit();
        }
        $categoriesQuery = "SELECT CategoryID, CategoryName FROM Categories";
        $categoriesResult = $conn->query($categoriesQuery);

        $supplierQuery = "SELECT SupplierID, SupplierName FROM Suppliers";
        $supplierResult = $conn->query($supplierQuery);

        echo "<form method='POST' action='add_product.php'>
            Product Name: <input type='text' name='ProductName' required><br><br>
            Price: <input type='number' name='Price' step='0.01' required><br><br>
            Stock Quantity: <input type='number' name='StockQuantity' required><br><br>
            Category:
            <select name='CategoryID' required>";
            while ($category = $categoriesResult->fetch_assoc()) {
                echo "<option value='{$category['CategoryID']}'>{$category['CategoryName']}</option>";
            }
            echo "</select><br><br>";
            echo "Supplier:
            <select name='SupplierID' required>
                <option value=''>--Select Supplier--</option>";
            while ($supplier = $supplierResult->fetch_assoc()) {
                echo "<option value='{$supplier['SupplierID']}'>{$supplier['SupplierName']}</option>";
            }
            echo "</select><br><br>";

            echo "<button class='btn-primary' type='submit'>Add Product</button></form>";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductName'], $_POST['Price'], $_POST['StockQuantity'], $_POST['CategoryID'], $_POST['SupplierID'])) {


            $ProductName = $conn->real_escape_string($_POST['ProductName']);
            $Price = floatval($_POST['Price']);
            $StockQuantity = intval($_POST['StockQuantity']);
            $CategoryID = intval($_POST['CategoryID']);
            $SupplierID = intval($_POST['SupplierID']);

            $conn->begin_transaction();

            try {
                $insertProductQuery = "
                    INSERT INTO Products (ProductName, Price, StockQuantity, CategoryID)
                    VALUES ('$ProductName', $Price, $StockQuantity, $CategoryID)";
                if ($conn->query($insertProductQuery) === TRUE) {
                    $ProductID = $conn->insert_id;
                    $linkQuery = "INSERT INTO Supplier_Products (SupplierID, ProductID) VALUES ($SupplierID, $ProductID)";
                    $conn->query($linkQuery);
                    $conn->commit();
                    echo "Product added successfully.";
                    echo "<form method='POST' action='products.php' style='display:inline;'>
                    <input type='hidden' name='CategoryID' value='{$CategoryID}'>
                    <button class='btn-primary' type='submit'>Back</button>
                    </form>";
                } else {
                    throw new Exception("Error adding product: " . $conn->error);
                }
            } catch (Exception $e) {
                $conn->rollback();
                echo "Error: " . $e->getMessage();
            }

            $conn->close();
            exit();
        }
    ?>
</body>
</html>
