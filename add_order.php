<!DOCTYPE html>
<html>
<head>
    <title>Add Order</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require("DBconnection.php");
session_start();

if (!isset($_POST['preview']) && !isset($_POST['confirm'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID'])) {
        $CustomerID = intval($_POST['CustomerID']);
        $customerQuery = "SELECT * FROM Customers WHERE CustomerID = $CustomerID";
        $customerResult = $conn->query($customerQuery);

        if ($customerResult->num_rows === 0) {
            echo "<p>Invalid CustomerID. No customer found.</p>";
            echo "<a href='customers.php'>Back to Customers</a>";
        } else {
            $products = $conn->query("SELECT * FROM Products");
            ?>
            <h2 class='h2-title'>Create a New Order for Customer: <?php echo $CustomerID; ?></h2>
            <button class='btn-primary'><a class='back_link' href='customers.php'>Back</a></button>
            
            <form method="POST" action="">
                <input type="hidden" name="customer_id" value="<?php echo $CustomerID; ?>">

                <h3>Select Product Quantities:</h3>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <label for="product_<?php echo $product['ProductID']; ?>">
                        <?php echo $product['ProductName']; ?> (Available: <?php echo $product['StockQuantity']; ?>):
                    </label>
                    <input type="number" id="product_<?php echo $product['ProductID']; ?>" name="products[<?php echo $product['ProductID']; ?>]" value="0" min="0" max="<?php echo $product['StockQuantity']; ?>">
                    <br>
                <?php endwhile; ?>
                <br>
                <button class='btn-primary' type="submit" name="preview">Preview Order</button>
            </form>
            <?php
        }
    } else {
        echo "<p>CustomerID not provided.</p>";
        echo "<a href='customers.php'>Back to Customers</a>";
    }
} elseif (isset($_POST['preview'])) {
    $customer_id = intval($_POST['customer_id']);
    $products = $_POST['products'];
    $customer = $conn->query("SELECT * FROM Customers WHERE CustomerID = $customer_id")->fetch_assoc();

    echo "<h2 class='h2-title'>Order Preview for Customer: {$customer['Name']}</h2>";
    echo "<table class='table-style'>
            <tr><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>";

    $total_amount = 0;
    foreach ($products as $product_id => $quantity) {
        if ($quantity > 0) {
            $product = $conn->query("SELECT * FROM Products WHERE ProductID = $product_id")->fetch_assoc();
            $subtotal = $quantity * $product['Price'];
            $total_amount += $subtotal;

            echo "<tr>
                    <td>{$product['ProductName']}</td>
                    <td>{$quantity}</td>
                    <td>{$product['Price']}</td>
                    <td>{$subtotal}</td>
                  </tr>";
        }
    }

    echo "<tr><td colspan='3'><strong>Total Amount</strong></td><td><strong>$total_amount</strong></td></tr>";
    echo "</table>";

    $_SESSION['order_preview'] = ['customer_id' => $customer_id, 'products' => $products, 'total_amount' => $total_amount];

    echo "<form method='POST' action=''>
            <button class='btn-primary' type='submit' name='confirm'>Confirm Order</button>
          </form>";
} elseif (isset($_POST['confirm'])) {
    $order_preview = $_SESSION['order_preview'];
    $customer_id = $order_preview['customer_id'];
    $products = $order_preview['products'];
    $total_amount = $order_preview['total_amount'];

    $conn->begin_transaction();

    try {
        $order_date = date('Y-m-d H:i:s');
        $conn->query("INSERT INTO Orders (OrderDate, TotalAmount, CustomerID) VALUES ('$order_date', $total_amount, $customer_id)");
        $order_id = $conn->insert_id;

        foreach ($products as $product_id => $quantity) {
            if ($quantity > 0) {
                $product = $conn->query("SELECT Price FROM Products WHERE ProductID = $product_id")->fetch_assoc();
                $price = $product['Price'];
                $subtotal = $quantity * $price;
                $conn->query("INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Subtotal) VALUES ($order_id, $product_id, $quantity, $subtotal)");
                $conn->query("UPDATE Products SET StockQuantity = StockQuantity - $quantity WHERE ProductID = $product_id");
            }
        }

        $conn->query("INSERT INTO Shipping (OrderID, ShippingDate, ShippingStatus) VALUES ($order_id, NOW(), 'Pending')");
        $conn->commit();

        echo "<p>Order added successfully!</p>";
        echo "<button class='btn-primary'><a class='back_link' href='customers.php'>Back to Customers</a></button>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<p>Error adding order: " . $e->getMessage() . "</p>";
    }
}
?>

</body>
</html>
