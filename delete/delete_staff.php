<?php
include "../php/db.php"; // Include your database connection file

if (isset($_GET['id'])) {
  $customer_id = $_GET['id'];

  // Prepare the SQL DELETE statement
  $sql = "DELETE FROM staff WHERE id = ?";
  $stmt = $conn->prepare($sql);

  // Bind the customer ID parameter and execute the statement
  $stmt->bind_param("i", $customer_id);

  if ($stmt->execute()) {
    echo "<script>
        alert('Staff successfully deleted.');
                window.location.href = '../page/main.php?page=staff&message=Staff%20deleted%20successfully';
                </script>";
  } else {
    echo "<script>
        alert('Error deleting staff.');
        window.location.href = '../page/main.php?page=staff&message=Error%20deleting%20staff';
      </script>";
  }

  // Close the statement and connection
  $stmt->close();
  $conn->close();
} else {
  echo "<script>
    alert('No staff ID provided.');
    window.location.href = '../page/main.php?page=staff&message=No%20staff%20ID%20provided';
  </script>";
}

?>