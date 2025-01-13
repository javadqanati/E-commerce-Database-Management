<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Supplier</title>
    </head>
    <body>
        <h1 class = 'h2-title'>Suppliers</h1>
        <link rel="stylesheet" href="style.css">
        <?php
            require('DBconnection.php');
            $sql = "SELECT * from Suppliers";
            $result = $conn->query($sql);
        ?>
        
        <form method="POST" action="admin_dashboard.php" style="display:inline;">
            <button class='btn-primary' type="submit">Home</button>
        </form>
        <form method="POST" action="add_supplier.php" style="display:inline;">
            <button class='btn-primary' type="submit">Add a supplier</button>
        </form>
        
        <table class='table-style'>
            <tr>
                <th>SupplierID</th>
                <th>Name</th>
                <th>ContactInfo</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['SupplierID']; ?></td>
                    <td><?php echo $row['SupplierName']; ?></td>
                    <td><?php echo $row['ContactInfo']; ?></td>
                    <td>
                        <form method="POST" action="products.php" style="display:inline;">
                            <input type="hidden" name="SupplierID" value="<?php echo $row['SupplierID']; ?>">
                            <button class='btn-secondary' type="submit">Products</button>
                        </form> | 
                        <form method="POST" action="delete_supplier.php" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="SupplierID" value="<?php echo $row['SupplierID']; ?>">
                            <button class='btn-danger' type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        
        <?php $conn->close(); ?>
    </body>
</html>
