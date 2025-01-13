<?php
require("DBconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID'])) {
    $CustomerID = intval($_POST['CustomerID']);

    $customerQuery = "SELECT * FROM Customers WHERE CustomerID = $CustomerID";
    $customerResult = $conn->query($customerQuery);

    if ($customerResult->num_rows === 0) {
        echo "<p>Invalid CustomerID. No customer found.</p>";
        echo "<form method='POST' action='customers.php'><button class='btn-primary' type='submit'>Back to Customers</button></form>";
        exit();
    }

    $productsQuery = "
        SELECT DISTINCT p.ProductID, p.ProductName
        FROM Products p
        JOIN OrderDetails od ON p.ProductID = od.ProductID
        JOIN Orders o ON od.OrderID = o.OrderID
        WHERE o.CustomerID = $CustomerID";
    $productsResult = $conn->query($productsQuery);

    if (!$productsResult || $productsResult->num_rows === 0) {
        echo "<p>No products found for this customer.</p>";
        echo "<form method='POST' action='customers.php'><button class='btn-primary' type='submit'>Back to Customers</button></form>";
        exit();
    }
} else {
    echo "<p>CustomerID not provided.</p>";
    echo "<form method='POST' action='customers.php'><button class='btn-primary' type='submit'>Back to Customers</button></form>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductID'], $_POST['Rating'])) {
    $ProductID = intval($_POST['ProductID']);
    $Rating = intval($_POST['Rating']);
    $Comment = $conn->real_escape_string($_POST['Comment']);
    $ReviewDate = date('Y-m-d H:i:s');

    $insertReviewQuery = "
        INSERT INTO Reviews (CustomerID, ProductID, Rating, Comment, ReviewDate)
        VALUES ($CustomerID, $ProductID, $Rating, '$Comment', '$ReviewDate')";

    if ($conn->query($insertReviewQuery) === TRUE) {
        echo "<p>Review added successfully!</p>";
        echo "<form method='POST' action='customers.php'><button class='btn-primary' type='submit'>Back to Customers</button></form>";
        exit();
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>
</head>
<body>
    <link rel="stylesheet" href="style.css">
    <button class='btn-primary'><a class='back_link' href="customers.php">Back to Customers</a></button><br><br>
    <form method="POST" action="add_review.php">
        <input type="hidden" name="CustomerID" value="<?php echo $CustomerID; ?>">
        <label for="ProductID">Select Product:</label>
        <select name="ProductID" id="ProductID" required>
            <option value="">--Select Product--</option>
            <?php while ($product = $productsResult->fetch_assoc()): ?>
                <option value="<?php echo $product['ProductID']; ?>">
                    <?php echo $product['ProductName']; ?>
                </option>
            <?php endwhile; ?>
        </select>
        <br><br>

        <label for="Rating">Rating (1-5):</label>
        <input type="number" id="Rating" name="Rating" min="1" max="5" required>
        <br><br>

        <label for="Comment">Comment (optional):</label>
        <textarea id="Comment" name="Comment" rows="4" cols="50"></textarea>
        <br><br>

        <button class='btn-primary'  type="submit">Submit Review</button>
    </form>
</body>
</html>
