<html>
    <head>
        <title>Add Customer</title>
    </head>
    <body>
    <link rel="stylesheet" href="style.css">
        <h2 class = 'h2-title'>Add a New Customer</h2>
        <button class='btn-primary'><a class='back_link' href="customers.php">Back</a></button><br><br>
        <form method="POST" action="add_customer.php">
            Name: <input type="text" name="name" required><br>
            Email: <input type="email" name="email" required><br>
            Phone: <input type="text" name="phone" required><br>
            Address: <input type="text" name="address" required><br><br>
            <button class='btn-secondary' type="submit">Add Customer</button>
        </form>
        <?php
            require("DBconnection.php");

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['address'])) {

                $name = $conn->real_escape_string($_POST['name']);
                $email = $conn->real_escape_string($_POST['email']);
                $phone = $conn->real_escape_string($_POST['phone']);
                $address = $conn->real_escape_string($_POST['address']);

                $sql = "INSERT INTO Customers (Name, Email, Phone, Address) VALUES ('$name', '$email', '$phone', '$address')";

                if ($conn->query($sql) === TRUE) {
                    echo "<p>New customer added successfully!</p>";
                } else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
            }
            $conn->close();
        ?>
        <br>
    </body>
</html>