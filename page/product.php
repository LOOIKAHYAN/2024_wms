<?php
include "../php/db.php";

// Query to fetch all products
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="../css/page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add styles for the image column */
        .product-image {
            width: 100px;
            /* Adjust as needed */
            height: auto;
        }
    </style>
</head>

<body>
    <h3>Product List</h3>

    <!-- Add New Product Icon -->
    <a href="../insert/insert_product.php" class="add-icon" title="Add New Product">
        <i class="fas fa-plus"></i> New Product
    </a>

    <?php
    if ($result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <th>Id</th>
                <th>Image</th>
                <th>Cas_Number</th>
                <th>Name</th>
                <th>Description</th>
                <th>Packaging</th>
                <th>Unit Price</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td>
                        <?php if (!empty($row["image"])): ?>
                            <img src="../upload/<?php echo htmlspecialchars($row["image"]); ?>" alt="Product Image"
                                class="product-image">
                        <?php else: ?>
                            No Image
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row["cas_number"]); ?></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["description"]); ?></td>
                    <td><?php echo htmlspecialchars($row["packaging"]); ?></td>
                    <td><?php echo htmlspecialchars($row["unit_price"]); ?></td>

                    <td class="actions">
                        <!-- Edit and Delete Icons with CSS Classes -->
                        <a href="../edit/edit_product.php?id=<?php echo $row['id']; ?>" title="Edit" class="icon-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="../delete/delete_product.php?id=<?php echo $row['id']; ?>" title="Delete" class="icon-delete"
                            onclick="return confirm('Are you sure you want to delete this product?');">
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