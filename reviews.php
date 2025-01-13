<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reviews</title>
    </head>
    <body>
    <link rel="stylesheet" href="style.css">
        <?php
            require("DBconnection.php");

            if ($conn == null) {
                exit();
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID']) && isset($_POST['name'])) {
                    $CustomerID = intval($_POST['CustomerID']);
                    $name = htmlspecialchars($_POST['name']);
                    echo "<h1  class = 'h2-title'>All Reviews By Customer: $name</h1>";
                    echo "<form method='POST' action='admin_dashboard.php' style='display:inline;'>
                            <button class='btn-primary' type='submit'>Home</button>
                        </form> | 
                        <form method='POST' action='customers.php' style='display:inline;'>
                            <button class='btn-primary' type='submit'>Back to Customers</button>
                        </form>";
                    

                    $sql = "SELECT * FROM Reviews WHERE CustomerID = $CustomerID";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='table-style'>";
                        echo "<tr><th>ReviewID</th><th>ProductID</th><th>CustomerID</th><th>Rating</th><th>Comment</th><th>ReviewDate</th><th>Action</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['ReviewID']}</td>";
                            echo "<td>{$row['ProductID']}</td>";
                            echo "<td>{$row['CustomerID']}</td>";
                            echo "<td>{$row['Rating']}</td>";
                            echo "<td>{$row['Comment']}</td>";
                            echo "<td>{$row['ReviewDate']}</td>";
                            echo "<td>
                                    <form method='POST' action='delete_review.php' style='display:inline;'>
                                        <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                                        <input type='hidden' name='ReviewID' value='{$row['ReviewID']}'>
                                        <button class='btn-danger' type='submit' onclick='return confirm(\"Are you sure?\");'>Delete</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                        echo "</table>";

                        $avgSql = "SELECT AVG(Rating) AS AverageRating FROM Reviews WHERE CustomerID = $CustomerID";
                        $avgResult = $conn->query($avgSql);
                        $avgRow = $avgResult->fetch_assoc();
                        $averageRating = round($avgRow['AverageRating'], 2);
                        echo "<p><strong>Average Rating By Customer:</strong> $averageRating</p>";
                    } else {
                        echo "No reviews found for CustomerID = $CustomerID.";
                    }
                } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ProductName'], $_POST['ProductID'], $_POST['CategoryID'])) {
                    $ProductName = htmlspecialchars($_POST['ProductName']);
                    $ProductID = intval($_POST['ProductID']);
                    $CategoryID = intval($_POST['CategoryID']);
                    echo "<form method='POST' action='products.php' style='display:inline;'>
                            <input type='hidden' name='CategoryID' value='$CategoryID'>
                            <button class='btn-primary' type='submit'>Back to Products</button>
                        </form>";
                    echo "<h1 class = 'h2-title'>Reviews for Product: $ProductName</h1>";

                    $sql = "SELECT * FROM Reviews WHERE ProductID = $ProductID";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo "<table class='table-style'>";
                        echo "<tr><th>ReviewID</th><th>ProductID</th><th>CustomerID</th><th>Rating</th><th>Comment</th><th>ReviewDate</th><th>Action</th></tr>";

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$row['ReviewID']}</td>";
                            echo "<td>{$row['ProductID']}</td>";
                            echo "<td>{$row['CustomerID']}</td>";
                            echo "<td>{$row['Rating']}</td>";
                            echo "<td>{$row['Comment']}</td>";
                            echo "<td>{$row['ReviewDate']}</td>";
                            echo "<td>
                                    <form method='POST' action='delete_review.php' style='display:inline;'>
                                        <input type='hidden' name='ProductID' value='{$row['ProductID']}'>
                                        <input type='hidden' name='ReviewID' value='{$row['ReviewID']}'>
                                        <button class='btn-danger' type='submit' onclick='return confirm(\"Are you sure?\");'>Delete</button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                        echo "</table>";

                        $avgSql = "SELECT AVG(Rating) AS AverageRating FROM Reviews WHERE ProductID = $ProductID";
                        $avgResult = $conn->query($avgSql);
                        $avgRow = $avgResult->fetch_assoc();
                        $averageRating = round($avgRow['AverageRating'], 2);
                        echo "<p><strong>Average Rating for Product:</strong> $averageRating</p>";
                    } else {
                        echo "No reviews found for ProductID = $ProductID.";
                    }
                } else {
                    echo "<p>Invalid or missing parameters in the POST request.</p>";
                }
            }
        ?>
    </body>
</html>
