<?php
include "../php/db.php";

// Fetch existing customers
$sql = "SELECT * FROM supplier";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier List</title>
    <link rel="stylesheet" href="../css/page.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

    </style>

</head>

<body>
    <h3>Supplier List</h3>

    <!-- Add New Supplier Icon -->
    <a href="../insert/insert_supplier.php" class="add-icon" title="Add New Supplier">
        <i class="fas fa-plus"></i> New Supplier
    </a>

    <?php
    if ($result->num_rows > 0) {
        ?>
        <table class="cust-tab">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Contact No</th>
                <th>Address</th>
                <th>Actions</th> <!-- New column for actions -->
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo $row["contact_no"]; ?></td>
                    <td><?php echo $row["address"]; ?></td>
                    <td class="actions">
                        <!-- Edit and Delete Icons with CSS Classes -->
                        <a href="../edit/edit_supplier.php?id=<?php echo $row['id']; ?>" title="Edit" class="icon-edit"><i
                                class="fas fa-edit"></i></a>
                        <a href="../delete/delete_supplier.php?id=<?php echo $row['id']; ?>" title="Delete" class="icon-delete"
                            onclick="return confirm('Are you sure you want to delete this supplier?');"><i
                                class="fas fa-trash"></i></a>
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