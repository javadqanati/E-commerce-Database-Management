<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer</title>
</head>
<body>
    <link rel="stylesheet" href="style.css">
    <h2 class="h2-title">Update Customer</h2>
    <form method="POST" action="customers.php" style="display:inline;">
        <button class="btn-primary" type="submit">Back</button>
    </form>
    <br><br>
    <?php
        require("DBconnection.php");

        if ($conn == null) {
            die("Database connection failure");
        } 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID']) && !isset($_POST['name'])) {
            $CustomerID = intval($_POST['CustomerID']);
            $sql = "SELECT * FROM Customers WHERE CustomerID = $CustomerID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <form method="POST" action="update_customer.php">
                    <input type="hidden" name="CustomerID" value="<?php echo $row['CustomerID']; ?>">
                    Name: <input type="text" name="name" value="<?php echo $row['Name']; ?>" required><br>
                    Email: <input type="email" name="email" value="<?php echo $row['Email']; ?>" required><br>
                    Phone: <input type="text" name="phone" value="<?php echo $row['Phone']; ?>" required><br>
                    Address: <input type="text" name="address" value="<?php echo $row['Address']; ?>" required><br>
                    <br><button class="btn-primary" type="submit">Update Customer</button>
                </form>
                <?php
            } else {
                echo "<p>No customer found with ID $CustomerID.</p>";
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['CustomerID'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'])) {
            $CustomerID = intval($_POST['CustomerID']);
            $name = $conn->real_escape_string($_POST['name']);
            $email = $conn->real_escape_string($_POST['email']);
            $phone = $conn->real_escape_string($_POST['phone']);
            $address = $conn->real_escape_string($_POST['address']);

            $sql = "UPDATE Customers SET Name='$name', Email='$email', Phone='$phone', Address='$address' WHERE CustomerID=$CustomerID";
            if ($conn->query($sql) === true) {
                echo "<p>Customer with ID $CustomerID updated successfully!</p>";
            } else {
                echo "<p>Error updating customer: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Invalid request. Please ensure all required fields are provided.</p>";
        }

        $conn->close();
    ?>
</body>
</html>
