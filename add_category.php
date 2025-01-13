<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Category</title>
    </head>
    <body>
        <link rel="stylesheet" href="style.css">
        <h1 class = 'h2-title'>Add Category</h1>
        <button class='btn-primary'><a class='back_link' href='categories.php'>Back</a></button><br>
        <br>
            <form method="POST" action="add_category.php">
                Category Name:   <input type="text" name="CategoryName" required><br>
                <br>
                <button class='btn-secondary' type="submit">Add Category</button>
            </form>
            <?php
                require("DBconnection.php");

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CategoryName'])) {

                    $CategoryName = $conn->real_escape_string($_POST['CategoryName']);

                    $sql = "INSERT INTO Categories (CategoryName) VALUES ('$CategoryName')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<p>New Category added successfully!</p>";
                    } else {
                        echo "<p>Error: " . $conn->error . "</p>";
                    }
                }
                $conn->close();
            ?>
        <br>
    </body>
</html>