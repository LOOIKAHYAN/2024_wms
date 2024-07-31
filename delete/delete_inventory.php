<?php
include "../php/db.php";

// Check if the inventory ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Inventory record successfully deleted.');
                window.location.href = '../page/main.php?page=inventory_details&message=Inventoryf%20deleted%20successfully';
                </script>";
    } else {
        echo "<script>alert('Failed to delete inventory record'); window.location.href = '../page/main.php?page=inventory_details&message=Inventoryf%20deleted%20successfully';
                </script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the inventory list page
    // header("Location: ../page/main.php?page=inventory_details");
    exit();
} else {
    echo "Invalid inventory ID";
    exit();
}
?>