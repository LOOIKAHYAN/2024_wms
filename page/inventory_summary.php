<?php
include "../php/db.php";

// Query to fetch product quantities grouped by product_id
$sql = "SELECT i.product_id, p.cas_number, p.name, SUM(i.quantity) AS total_quantity
        FROM inventory i
        JOIN product p ON i.product_id = p.id
        GROUP BY i.product_id, p.cas_number, p.name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Summary</title>
    <link rel="stylesheet" href="../css/page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <h3>Inventory Summary</h3>
    <?php
    if ($result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <th>Product Id</th>
                <th>Cas Number</th>
                <th>Name</th>
                <th>Total Quantity</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["product_id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["cas_number"]); ?></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["total_quantity"]); ?></td>
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