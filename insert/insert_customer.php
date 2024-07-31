<?php
include "../php/db.php";

// Handle form submission for adding a new customer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];

    // Insert new customer into the database
    $sql = "INSERT INTO customer (name, email, contact_no, address) VALUES ('$name', '$email', '$contact_no', '$address')";
    if ($conn->query($sql) === TRUE) {
        ?>
        <script>alert("New customer successfully added")</script>
        <?php
    } else {
        ?>
        <script>alert("Failed to add new customer")</script>
        <?php
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Customer</title>
    <script src="../javascript/load_content.js"></script>
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <h3>Add New Customer</h3>

    <!-- Form to add a new customer -->
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="contact_no" placeholder="Contact No" required>
        <input type="text" name="address" placeholder="Address" required>
        <button type="submit" name="add_customer">Add Customer</button>
    </form>

    <ul>
        <li><a href="../page/main.php?page=customer">Back to Customer List</a></li>
    </ul>
</body>

</html>