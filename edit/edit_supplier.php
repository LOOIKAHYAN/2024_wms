<?php
include "../php/db.php"; // Include your database connection file

if (isset($_GET['id'])) {
    $supplier_id = $_GET['id'];

    // Retrieve the current details of the supplier
    $sql = "SELECT * FROM supplier WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $supplier_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $supplier = $result->fetch_assoc();
    } else {
        echo "<script>
                alert('Supplier not found.');
                window.location.href = '../page/main.php?page=supplier';
              </script>";
        exit();
    }

    $stmt->close();
} else {
    echo "<script>
            alert('No supplier ID provided.');
            window.location.href = '../page/main.php?page=supplier';
          </script>";
    exit();
}

// Handle form submission for updating the supplier details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_supplier'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $address = $_POST['address'];

    // Update the supplier details in the database
    $sql = "UPDATE supplier SET name = ?, email = ?, contact_no = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $contact_no, $address, $supplier_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Supplier details updated successfully.');
                window.location.href = '../page/main.php?page=supplier';
              </script>";
    } else {
        echo "<script>
                alert('Error updating supplier details.');
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
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <h3>Edit Supplier</h3>

    <!-- Form to edit the supplier details -->
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($supplier['name']); ?>"
            required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($supplier['email']); ?>"
            required>
        <input type="text" name="contact_no" placeholder="Contact No"
            value="<?php echo htmlspecialchars($supplier['contact_no']); ?>" required>
        <input type="text" name="address" placeholder="Address"
            value="<?php echo htmlspecialchars($supplier['address']); ?>" required>
        <button type="submit" name="update_supplier">Update Supplier</button>
    </form>

    <ul>
        <li> <a href="../page/main.php?page=supplier">Back to Supplier List</a></li>
    </ul>
</body>

</html>