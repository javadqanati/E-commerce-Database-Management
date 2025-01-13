<?php
require("DBconnection.php");

if ($conn == null) {
    exit("Database connection failure");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductID'])) {
    $ProductID = intval($_POST['ProductID']);

    $productQuery = "SELECT * FROM Products WHERE ProductID = $ProductID";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows === 0) {
        echo "Product not found.";
        exit();
    }

    $product = $productResult->fetch_assoc();

    $supplierQuery = "SELECT SupplierID FROM Supplier_Products WHERE ProductID = $ProductID";
    $supplierResult = $conn->query($supplierQuery);
    $SupplierID = $supplierResult->num_rows > 0 ? $supplierResult->fetch_assoc()['SupplierID'] : null;

    $categoriesQuery = "SELECT CategoryID, CategoryName FROM Categories";
    $categoriesResult = $conn->query($categoriesQuery);

    $suppliersQuery = "SELECT SupplierID, SupplierName FROM Suppliers";
    $suppliersResult = $conn->query($suppliersQuery);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductName'], $_POST['Price'], $_POST['StockQuantity'], $_POST['CategoryID'], $_POST['SupplierID'])) {
    $ProductID = intval($_POST['ProductID']);
    $ProductName = $conn->real_escape_string($_POST['ProductName']);
    $Price = floatval($_POST['Price']);
    $StockQuantity = intval($_POST['StockQuantity']);
    $CategoryID = intval($_POST['CategoryID']);
    $SupplierID = intval($_POST['SupplierID']);

    $updateQuery = "
        UPDATE Products 
        SET ProductName = '$ProductName', Price = $Price, StockQuantity = $StockQuantity, CategoryID = $CategoryID 
        WHERE ProductID = $ProductID";
    $productUpdate = $conn->query($updateQuery);

    $supplierProductQuery = "
        UPDATE Supplier_Products 
        SET SupplierID = $SupplierID 
        WHERE ProductID = $ProductID";
    $supplierUpdate = $conn->query($supplierProductQuery);

    if ($productUpdate && $supplierUpdate) {
        echo "Product updated successfully.";
        echo "<br><a href='products.php'>Back to Products</a>";
    } else {
        echo "Error updating product: " . $conn->error;
    }
    $conn->close();
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <h2 class = 'h2-title'>Update Product</h2>
    
    <form method="POST" action="update_product.php">
        <input type="hidden" name="ProductID" value="<?php echo $product['ProductID']; ?>">

        <label for="ProductName">Product Name:</label>
        <input type="text" id="ProductName" name="ProductName" value="<?php echo $product['ProductName']; ?>" required>
        <br><br>

        <label for="Price">Price:</label>
        <input type="number" id="Price" name="Price" step="0.01" value="<?php echo $product['Price']; ?>" required>
        <br><br>

        <label for="StockQuantity">Stock Quantity:</label>
        <input type="number" id="StockQuantity" name="StockQuantity" value="<?php echo $product['StockQuantity']; ?>" required>
        <br><br>

        <label for="CategoryID">Category:</label>
        <select id="CategoryID" name="CategoryID" required>
            <?php while ($category = $categoriesResult->fetch_assoc()): ?>
                <option value="<?php echo $category['CategoryID']; ?>" <?php echo $product['CategoryID'] == $category['CategoryID'] ? 'selected' : ''; ?>>
                    <?php echo $category['CategoryName']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>

        <label for="SupplierID">Supplier:</label>
        <select id="SupplierID" name="SupplierID" required>
            <?php while ($supplier = $suppliersResult->fetch_assoc()): ?>
                <option value="<?php echo $supplier['SupplierID']; ?>" <?php echo $supplier['SupplierID'] == $SupplierID ? 'selected' : ''; ?>>
                    <?php echo $supplier['SupplierName']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>

        <button class='btn-primary' type="submit">Update Product</button>
    </form>
</body>
</html>
