<?php
include "../php/db.php";

// Check if the inventory ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current inventory details
    $sql = "SELECT * FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $inventory = $result->fetch_assoc();

    // Fetch product and supplier options for the dropdown menus
    $product_sql = "SELECT id, name FROM product";
    $product_result = $conn->query($product_sql);

    $supplier_sql = "SELECT id, name FROM supplier";
    $supplier_result = $conn->query($supplier_sql);

    // Check if the form is submitted for updating the inventory
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_inventory'])) {
        $quantity = $_POST['quantity'];
        $datetime = $_POST['datetime'];
        $location = $_POST['location'];
        $remarks = $_POST['remarks'];
        $product_id = $_POST['product_id'];
        $supplier_id = $_POST['supplier_id'];

        // Update the inventory details in the database
        $sql = "UPDATE inventory SET quantity = ?, datetime = ?, location = ?, remarks = ?, product_id = ?, supplier_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssiii", $quantity, $datetime, $location, $remarks, $product_id, $supplier_id, $id);

        if ($stmt->execute()) {
            // Success - Show alert and then redirect
            echo "<script>
                    alert('Inventory successfully updated');
                    window.location.href = '../page/main.php?page=inventory_details';
                  </script>";
        } else {
            // Failure - Show alert and then redirect
            echo "<script>
                    alert('Failed to update inventory');
                    window.location.href = '../page/main.php?page=inventory_details';
                  </script>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

        exit();
    }
} else {
    echo "<script>alert('Invalid inventory ID'); window.location.href = '../page/main.php?page=inventory_details';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventory</title>
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <h3>Edit Inventory</h3>

    <!-- Form to edit the inventory record -->
    <form action="" method="POST">
        <input type="number" name="quantity" placeholder="Quantity"
            value="<?php echo htmlspecialchars($inventory['quantity']); ?>" required>
        <input type="datetime-local" name="datetime" placeholder="Datetime"
            value="<?php echo htmlspecialchars($inventory['datetime']); ?>" required>
        <input type="text" name="location" placeholder="Location"
            value="<?php echo htmlspecialchars($inventory['location']); ?>" required>
        <input type="text" name="remarks" placeholder="Remarks"
            value="<?php echo htmlspecialchars($inventory['remarks']); ?>">
        <select name="product_id" required>
            <option value="" disabled>Select Product</option>
            <?php
            while ($product = $product_result->fetch_assoc()) {
                $selected = ($product['id'] == $inventory['product_id']) ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($product['id']) . "' $selected>" . htmlspecialchars($product['name']) . "</option>";
            }
            ?>
        </select>
        <select name="supplier_id" required>
            <option value="" disabled>Select Supplier</option>
            <?php
            while ($supplier = $supplier_result->fetch_assoc()) {
                $selected = ($supplier['id'] == $inventory['supplier_id']) ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($supplier['id']) . "' $selected>" . htmlspecialchars($supplier['name']) . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="edit_inventory">Update Inventory</button>
    </form>

    <ul>
        <li><a href="../page/main.php?page=inventory_details">Back to Inventory List</a></li>
    </ul>
</body>

</html>