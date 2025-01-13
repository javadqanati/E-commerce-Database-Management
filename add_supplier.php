<?php
require("DBconnection.php");

if ($conn == null) {
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $SupplierName = $conn->real_escape_string($_POST['SupplierName']);
    $ProductOption = $_POST['ProductOption'];

    $conn->begin_transaction();

    try {
        $insertSupplierQuery = "INSERT INTO Suppliers (SupplierName) VALUES ('$SupplierName')";
        $conn->query($insertSupplierQuery);
        $SupplierID = $conn->insert_id;

        if ($ProductOption === 'existing') {
            $ProductID = intval($_POST['ProductID']);
            if ($ProductID > 0) {
                $linkQuery = "INSERT INTO Supplier_Products (SupplierID, ProductID) VALUES ($SupplierID, $ProductID)";
                $conn->query($linkQuery);
            } else {
                throw new Exception("No product selected.");
            }
        } elseif ($ProductOption === 'new') {
            $ProductName = $conn->real_escape_string($_POST['ProductName']);
            $Price = floatval($_POST['Price']);
            $StockQuantity = intval($_POST['StockQuantity']);
            $CategoryID = intval($_POST['CategoryID']);

            if (!empty($ProductName) && $Price > 0 && $StockQuantity >= 0 && $CategoryID > 0) {
                $insertProductQuery = "
                    INSERT INTO Products (ProductName, Price, StockQuantity, CategoryID)
                    VALUES ('$ProductName', $Price, $StockQuantity, $CategoryID)";
                $conn->query($insertProductQuery);
                $ProductID = $conn->insert_id;

                $linkQuery = "INSERT INTO Supplier_Products (SupplierID, ProductID) VALUES ($SupplierID, $ProductID)";
                $conn->query($linkQuery);
            } else {
                throw new Exception("Invalid product details for new product.");
            }
        }

        $conn->commit();
        echo "Supplier and product linked successfully.";
        ?>
        <form method="POST" action="suppliers.php">
            <button type="submit">Back to Suppliers</button>
        </form>
        <?php
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
</head>
<body>
    <h2>Add Supplier</h2>
    <form method="POST" action="add_supplier.php">
        Supplier Name: <input type="text" name="SupplierName" required><br><br>

        Product Option:
        <input type="radio" name="ProductOption" value="existing" required> Existing Product
        <input type="radio" name="ProductOption" value="new" required> New Product<br><br>

        <fieldset>
            <legend>Choose Existing Product</legend>
            Select Product:
            <select name="ProductID">
                <option value="">--Select Product--</option>
                <?php
                $productQuery = "SELECT ProductID, ProductName FROM Products";
                $productResult = $conn->query($productQuery);
                while ($product = $productResult->fetch_assoc()) {
                    echo "<option value='{$product['ProductID']}'>{$product['ProductName']}</option>";
                }
                ?>
            </select>
        </fieldset>
        <br>

        <fieldset>
            <legend>Add New Product</legend>
            Product Name: <input type="text" name="ProductName"><br><br>
            Price: <input type="number" name="Price" step="0.01"><br><br>
            Stock Quantity: <input type="number" name="StockQuantity"><br><br>
            Category:
            <select name="CategoryID">
                <?php
                $categoriesQuery = "SELECT CategoryID, CategoryName FROM Categories";
                $categoriesResult = $conn->query($categoriesQuery);
                while ($category = $categoriesResult->fetch_assoc()) {
                    echo "<option value='{$category['CategoryID']}'>{$category['CategoryName']}</option>";
                }
                ?>
            </select>
        </fieldset>
        <br>

        <button class='btn-primary' type="submit">Add Supplier</button>
    </form>
</body>
</html>
