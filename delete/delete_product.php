<?php
include "../php/db.php";

// Check if the product ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if the product is referenced in the inventory table
    $check_sql = "SELECT COUNT(*) as count FROM inventory WHERE product_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();

    if ($check_row['count'] > 0) {
        echo "<script>
                alert('Cannot delete product. It is referenced in the inventory.');
                window.location.href = '../page/main.php?page=product&message=Cannot%20delete%20product%20because%20it%20is%20referenced%20in%20the%20inventory';
              </script>";
    } else {
        // Prepare and execute the delete query
        $sql = "DELETE FROM product WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Product successfully deleted.');
                    window.location.href = '../page/main.php?page=product&message=Product%20deleted%20successfully';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to delete product.');
                    window.location.href = '../page/main.php?page=product&message=Failed%20to%20delete%20product';
                  </script>";
        }

        // Close statement and connection
        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();

} else {
    echo "Invalid product ID";
    exit();
}
?>