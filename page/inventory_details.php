<?php
include "../php/db.php";

// Query to fetch product quantities grouped by product_id
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);

$sql = "SELECT i.id, i.quantity, i.datetime, i.location, i.remarks, i.product_id, p.name as product_name, i.supplier_id, s.name as supplier_name
        FROM inventory i
        JOIN product p ON i.product_id = p.id JOIN supplier s on i.supplier_id = s.id
        ORDER BY i.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Details</title>
    <link rel="stylesheet" href="../css/page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <h3>Inventory Details</h3>

    <!-- Add New Inventory Icon -->
    <a href="../insert/insert_inventory.php" class="add-icon" title="Add New Inventory">
        <i class="fas fa-plus"></i> New Inventory
    </a>
    <?php
    if ($result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <th>Id</th>
                <th>Quantity</th>
                <th>Datetime</th>
                <th>Location</th>
                <th>Remarks</th>
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Supplier Id</th>
                <th>Supplier Name</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["quantity"]); ?></td>
                    <td><?php echo htmlspecialchars($row["datetime"]); ?></td>
                    <td><?php echo htmlspecialchars($row["location"]); ?></td>
                    <td><?php echo htmlspecialchars($row["remarks"]); ?></td>
                    <td><?php echo htmlspecialchars($row["product_id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["product_name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["supplier_id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["supplier_name"]); ?></td>
                    <td class="actions">
                        <!-- Edit and Delete Icons with CSS Classes -->
                        <a href="../edit/edit_inventory.php?id=<?php echo $row['id']; ?>" title="Edit" class="icon-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="../delete/delete_inventory.php?id=<?php echo $row['id']; ?>" title="Delete" class="icon-delete"
                            onclick="return confirm('Are you sure you want to delete this inventory?');">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    } else {
        echo "0 results";
    }

    // Close connection
    $conn->close();
    ?>
</body>

</html>