<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete a Customer</title>
</head>
<body>
    <?php
        require("DBconnection.php");

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID'])) {
            $CustomerID = intval($_POST['CustomerID']);

            $sql = "DELETE FROM Customers WHERE CustomerID = $CustomerID";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Customer with customer ID $CustomerID deleted successfully!</p>";
                echo "<form method='POST' action='admin_dashboard.php'><button type='submit'>Back to customers</button></form>";
            } else {
                echo "<p>Error deleting the customer: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Invalid Request. No customer ID provided.</p>";
        }

        $conn->close();
    ?>
</body>
</html>
