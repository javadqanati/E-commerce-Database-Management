<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Supplier</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <h1 class = 'h2-title'>Delete Supplier</h1>
    <?php
    require("DBconnection.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['SupplierID'])) {
        $SupplierID = intval($_POST['SupplierID']);

        $conn->begin_transaction();

        try {
            $updateSupplierProductQuery = "UPDATE Supplier_Products SET SupplierID = 10 WHERE SupplierID = $SupplierID";
            $conn->query($updateSupplierProductQuery);

            $deleteSupplierQuery = "DELETE FROM Suppliers WHERE SupplierID = $SupplierID";
            $conn->query($deleteSupplierQuery);

            $conn->commit();
            echo "<p>Supplier and associated relationships updated successfully. Supplier deleted.</p>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }

        echo "<form method='POST' action='suppliers.php'>
                <button class='btn-primary' type='submit'>Back to Suppliers</button>
              </form>";
    } else {
        echo "<p>Invalid request. No SupplierID provided.</p>";
        echo "<form method='POST' action='suppliers.php'>
                <button class='btn-primary' type='submit'>Back to Suppliers</button>
              </form>";
    }

    $conn->close();
    ?>
    <br><br>
</body>
</html>
