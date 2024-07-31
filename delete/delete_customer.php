<?php
include "../php/db.php"; // Include your database connection file

if (isset($_GET['id'])) {
  $customer_id = $_GET['id'];

  // Prepare the SQL DELETE statement
  $sql = "DELETE FROM customer WHERE id = ?";
  $stmt = $conn->prepare($sql);

  // Bind the customer ID parameter and execute the statement
  $stmt->bind_param("i", $customer_id);

  if ($stmt->execute()) {
    echo "<script>
        alert('Customer successfully deleted.');
                window.location.href = '../page/main.php?page=customer&message=Customer%20deleted%20successfully';
                </script>";
  } else {
    echo "<script>
        alert('Error deleting customer.');
        window.location.href = '../page/main.php?page=customer&message=Error%20deleting%20customer';
      </script>";
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();
} else {
  echo "<script>
    alert('No customer ID provided.');
    window.location.href = '../page/main.php?page=customer&message=No%20customer%20ID%20provided';
  </script>";
}

?>