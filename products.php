<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <?php
    require("DBconnection.php");

    if ($conn == null) {
        exit();
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CategoryID'])) {
            $CategoryID = intval($_POST['CategoryID']);
            echo "<form method='POST' action='categories.php'>
                <button class='btn-primary' type='submit'>Back to Categories</button>
            </form>";
            echo "<form method='POST' action='add_product.php' style='display:inline;'>
                <input type='hidden' name='CategoryID' value='{$CategoryID}'>
                <button class='btn-primary' type='submit'>Add a Product</button>
            </form>";
            if (isset($_POST['name'])) {
                $name = htmlspecialchars($_POST['name']);
                echo "<h1 class = 'h2-title'>Products in the category: $name</h1>";
            } else {
                echo "<h1 class = 'h2-title'>Products in the Category ID: $CategoryID</h1>";
            }

            $sql = "
                SELECT p.ProductID, p.ProductName, p.Price, p.CategoryID, p.StockQuantity, sp.SupplierID
                FROM Products p
                LEFT JOIN Supplier_Products sp ON p.ProductID = sp.ProductID
                WHERE p.CategoryID = $CategoryID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table-style'>";
                echo "<tr><th>Product ID</th><th>Product Name</th><th>Price</th><th>Category ID</th><th>Stock Quantity</th><th>Supplier ID</th><th>Actions</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ProductID']}</td>";
                    echo "<td>{$row['ProductName']}</td>";
                    echo "<td>{$row['Price']}</td>";
                    echo "<td>{$row['CategoryID']}</td>";
                    echo "<td>{$row['StockQuantity']}</td>";
                    echo "<td>{$row['SupplierID']}</td>";
                    echo "<td>
                        <form method='POST' action='update_product.php' style='display:inline;'>
                            <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                            <input type='hidden' name='ProductName' value='{$row['ProductName']}'>
                            <input type='hidden' name='SupplierID' value='{$row['SupplierID']}'>
                            <button class='btn-secondary' type='submit'>Edit</button>
                        </form> | 
                        <form method='POST' action='delete_product.php' style='display:inline;'>
                            <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                            <input type='hidden' name='CategoryID' value='{$row['CategoryID']}'>
                            <button class='btn-danger' type='submit' onclick='return confirm(\"Are you sure?\");'>Delete</button>
                        </form> |
                        <form method='POST' action='reviews.php' style='display:inline;'>
                            <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                            <input type='hidden' name='ProductName' value='{$row['ProductName']}'>
                            <input type='hidden' name='CategoryID' value='{$row['CategoryID']}'>
                            <button class='btn-secondary' type='submit'>Reviews</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No products found for CategoryID = $CategoryID.";
            }

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SupplierID'])) {
            $SupplierID = intval($_POST['SupplierID']);
            echo "<h1 class = 'h2-title'>Products Supplied by Supplier ID: $SupplierID</h1>";

            $sql = "
                SELECT p.ProductID, p.ProductName, p.Price, p.CategoryID, p.StockQuantity, sp.SupplierID
                FROM Supplier_Products sp
                JOIN Products p ON sp.ProductID = p.ProductID
                WHERE sp.SupplierID = $SupplierID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table-style'>";
                echo "<tr><th>Product ID</th><th>Product Name</th><th>Price</th><th>Category ID</th><th>Stock Quantity</th><th>Supplier ID</th><th>Actions</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['ProductID']}</td>";
                    echo "<td>{$row['ProductName']}</td>";
                    echo "<td>{$row['Price']}</td>";
                    echo "<td>{$row['CategoryID']}</td>";
                    echo "<td>{$row['StockQuantity']}</td>";
                    echo "<td>{$row['SupplierID']}</td>";
                    echo "<td>
                        <form method='POST' action='update_product.php' style='display:inline;'>
                            <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                            <input type='hidden' name='ProductName' value='{$row['ProductName']}'>
                            <input type='hidden' name='SupplierID' value='{$row['SupplierID']}'>
                            <button class='btn-secondary' type='submit'>Edit</button>
                        </form> | 
                        <form method='POST' action='delete_product.php' style='display:inline;'>
                            <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                            <input type='hidden' name='CategoryID' value='{$row['CategoryID']}'>
                            <button class='btn-danger' type='submit' onclick='return confirm(\"Are you sure?\");'>Delete</button>
                        </form> |
                        <form method='POST' action='reviews.php' style='display:inline;'>
                            <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                            <input type='hidden' name='ProductName' value='{$row['ProductName']}'>
                            <input type='hidden' name='CategoryID' value='{$row['CategoryID']}'>
                            <button class='btn-secondary' type='submit'>Reviews</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No products found for SupplierID = $SupplierID.";
            }

        } else {
            echo "<p>CategoryID or SupplierID not provided in the POST request.</p>";
        }
    }
    ?>
</body>
</html>
