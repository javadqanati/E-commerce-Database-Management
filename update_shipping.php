<?php
require("DBconnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ShippingID']) && !isset($_POST['ShippingStatus'])) {
    $ShippingID = intval($_POST['ShippingID']);

    $sql = "SELECT * FROM Shipping WHERE ShippingID = $ShippingID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $shipping = $result->fetch_assoc();
    } else {
        echo "<p>No shipping found with ID $ShippingID.</p>";
        echo "<a href='shippings.php'>Back to Shippings</a>";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ShippingID'], $_POST['ShippingStatus'])) {
    $ShippingID = intval($_POST['ShippingID']);
    $ShippingStatus = $conn->real_escape_string($_POST['ShippingStatus']);

    $sql = "UPDATE Shipping SET ShippingStatus = '$ShippingStatus' WHERE ShippingID = $ShippingID";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Shipping updated successfully!</p>";
    } else {
        echo "<p>Error updating shipping: " . $conn->error . "</p>";
    }

    echo "<a href='shippings.php'>Back to Shippings</a>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Shipping</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <h2 class = 'h2-title'>Update Shipping</h2>
    <form method="POST" action="update_shipping.php">
        <input type="hidden" name="ShippingID" value="<?php echo isset($shipping) ? $shipping['ShippingID'] : ''; ?>">
        <label for="ShippingStatus">Shipping Status:</label>
        <select id="ShippingStatus" name="ShippingStatus" required>
            <option value="Pending" <?php if (isset($shipping) && $shipping['ShippingStatus'] === 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Shipped" <?php if (isset($shipping) && $shipping['ShippingStatus'] === 'Shipped') echo 'selected'; ?>>Shipped</option>
            <option value="In Transit" <?php if (isset($shipping) && $shipping['ShippingStatus'] === 'In Transit') echo 'selected'; ?>>In Transit</option>
            <option value="Delivered" <?php if (isset($shipping) && $shipping['ShippingStatus'] === 'Delivered') echo 'selected'; ?>>Delivered</option>
            <option value="Cancelled" <?php if (isset($shipping) && $shipping['ShippingStatus'] === 'Cancelled') echo 'selected'; ?>>Cancelled</option>
        </select>
        <br><br>
        <button class='btn-primary' type="submit">Update Shipping</button>
    </form>
    <form method="POST" action="update_shipping.php">
        <input type="hidden" name="ShippingID" value="<?php echo isset($shipping) ? $shipping['ShippingID'] : ''; ?>">
        <button class='btn-primary' type="submit">Reload Shipping Details</button>
    </form>
    <button class='btn-primary'><a class='back_link' href="shippings.php">Back to Shippings</a></button>
</body>
</html>
