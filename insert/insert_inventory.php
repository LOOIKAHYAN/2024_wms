<?php
include "../php/db.php";

// Fetch product and supplier options for the dropdown menus
$product_sql = "SELECT id, name FROM product";
$product_result = $conn->query($product_sql);

$supplier_sql = "SELECT id, name FROM supplier";
$supplier_result = $conn->query($supplier_sql);

// Handle form submission for adding a new inventory record
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_inventory'])) {
    $quantity = $_POST['quantity'];
    $datetime = $_POST['datetime'];
    $location = $_POST['location'];
    $remarks = $_POST['remarks'];
    $product_id = $_POST['product_id'];
    $supplier_id = $_POST['supplier_id'];

    // Insert new inventory record into the database
    $sql = "INSERT INTO inventory (quantity, datetime, location, remarks, product_id, supplier_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssii", $quantity, $datetime, $location, $remarks, $product_id, $supplier_id);

    if ($stmt->execute()) {
        // Success - Show alert and then redirect
        echo "<script>
                alert('New inventory successfully added');
                window.location.href = '../page/main.php?page=inventory_details';
              </script>";
    } else {
        // Failure - Show alert and then redirect
        echo "<script>
                alert('Failed to add new inventory');
                window.location.href = '../page/main.php?page=inventory_details';
              </script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Inventory</title>
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <h3>Add New Inventory</h3>

    <!-- Form to add a new inventory record -->
    <form action="" method="POST">
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="datetime-local" name="datetime" placeholder="Datetime" required>
        <input type="text" name="location" placeholder="Location" required>
        <input type="text" name="remarks" placeholder="Remarks">
        <select name="product_id" required>
            <option value="" disabled selected>Select Product</option>
            <?php
            while ($product = $product_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($product['id']) . "'>" . htmlspecialchars($product['name']) . "</option>";
            }
            ?>
        </select>
        <select name="supplier_id" required>
            <option value="" disabled selected>Select Supplier</option>
            <?php
            while ($supplier = $supplier_result->fetch_assoc()) {
                echo "<option value='" . htmlspecialchars($supplier['id']) . "'>" . htmlspecialchars($supplier['name']) . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="add_inventory">Add Inventory</button>
    </form>

    <ul>
        <li><a href="../page/main.php?page=inventory_details">Back to Inventory List</a></li>
    </ul>
</body>

</html>