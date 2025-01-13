<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <?php
        require('DBconnection.php');
        echo "<h1 class = 'h2-title'>Product Categories</h1>";
        echo "<form method='POST' action='admin_dashboard.php'><button class='btn-primary' type='submit'>Home</button></form> <form method='POST' action='add_category.php'><button class='btn-primary' type='submit'>Add a category</button></form>";


        $sql = "SELECT * FROM Categories";
        $result = $conn->query($sql);

        echo "<table class='table-style'>";
        echo "<tr><th>Category ID</th><th>Category Name</th><th>Actions</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['CategoryID']}</td>";
            echo "<td>{$row['CategoryName']}</td>";
            echo "<td>
                <form method='POST' action='products.php' style='display:inline;'>
                    <input type='hidden' name='CategoryID' value='{$row['CategoryID']}'>
                    <input type='hidden' name='name' value='{$row['CategoryName']}'>
                    <button class='btn-secondary' type='submit'>See products</button>
                </form>
                |
                <form method='POST' action='delete_category.php' style='display:inline;' onsubmit=\"return confirm('If you delete the category, all the products of this category will be assigned to the Default category. Are you sure?');\">
                    <input type='hidden' name='CategoryID' value='{$row['CategoryID']}'>
                    <button class='btn-danger' type='submit'>Delete</button>
                </form>
            </td>";
            echo "</tr>";
        }

        echo "</table>";
        $conn->close();
    ?>
</body>
</html>
