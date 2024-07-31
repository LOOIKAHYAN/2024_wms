<?php
include "../php/db.php"; // Include your database connection file

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Retrieve the current details of the customer
    $sql = "SELECT * FROM customer WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        echo "<script>
                alert('Customer not found.');
                window.location.href = '../page/main.php?page=customer';
              </script>";
        exit();
    }

    $stmt->close();
} else {
    echo "<script>
            alert('No customer ID provided.');
            window.location.href = '../page/main.php?page=customer';
          </script>";
    exit();
}

// Handle form submission for updating the customer details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_customer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];

    // Update the customer details in the database
    $sql = "UPDATE customer SET name = ?, email = ?, contact_no = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $contact_no, $address, $customer_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Customer details updated successfully.');
                window.location.href = '../page/main.php?page=customer';
              </script>";
    } else {
        echo "<script>
                alert('Error updating customer details.');
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <h3>Edit Customer</h3>

    <!-- Form to edit the customer details -->
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($customer['name']); ?>"
            required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($customer['email']); ?>"
            required>
        <input type="text" name="contact_no" placeholder="Contact No"
            value="<?php echo htmlspecialchars($customer['contact_no']); ?>" required>
        <input type="text" name="address" placeholder="Address"
            value="<?php echo htmlspecialchars($customer['address']); ?>" required>
        <button type="submit" name="update_customer">Update Customer</button>
    </form>

    <ul>
        <li> <a href="../page/main.php?page=customer">Back to Customer List</a></li>
    </ul>
</body>

</html>