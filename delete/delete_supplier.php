<?php
include "../php/db.php";

// Check if the supplier ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Prepare and execute the delete query
        $sql = "DELETE FROM supplier WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Supplier successfully deleted'); window.location.href = '../page/main.php?page=supplier';</script>";
        } else {
            echo "<script>alert('Supplier not found'); window.location.href = '../page/main.php?page=supplier';</script>";
        }

    } catch (mysqli_sql_exception $e) {
        // Check if the error is related to a foreign key constraint
        if ($e->getCode() == 1451) {
            echo "<script>alert('Cannot delete supplier. It is referenced in the inventory.'); window.location.href = '../page/main.php?page=supplier';</script>";
        } else {
            echo "<script>alert('An error occurred'); window.location.href = '../page/main.php?page=supplier';</script>";
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

} else {
    echo "Invalid supplier ID";
    exit();
}
?>