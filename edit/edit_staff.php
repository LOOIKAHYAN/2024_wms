<?php
include "../php/db.php"; // Include your database connection file

if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Retrieve the current details of the customer
    $sql = "SELECT * FROM staff WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $staff_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $staff = $result->fetch_assoc();
    } else {
        echo "<script>
                alert('Staff not found.');
                window.location.href = '../index.php?page=staff';
              </script>";
        exit();
    }

    $stmt->close();
} else {
    echo "<script>
            alert('No staff ID provided.');
            window.location.href = '../index.php?page=staff';
          </script>";
    exit();
}

// Handle form submission for updating the staff details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_staff'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Update the staff details in the database
    $sql = "UPDATE staff SET name = ?, email = ?, contact_no = ?, username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $email, $contact_no, $username, $password, $staff_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Staff details updated successfully.');
                window.location.href = '../page/main.php?page=staff';
              </script>";
    } else {
        echo "<script>
                alert('Error updating staff details.');
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <h3>Edit Staff</h3>

    <!-- Form to edit the staff details -->
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($staff['name']); ?>"
            required>
        <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($staff['email']); ?>"
            required>
        <input type="text" name="contact_no" placeholder="Contact No"
            value="<?php echo htmlspecialchars($staff['contact_no']); ?>" required>
        <input type="text" name="username" placeholder="Username"
            value="<?php echo htmlspecialchars($staff['username']); ?>" required>
        <input type="password" name="password" placeholder="Password"
            value="<?php echo htmlspecialchars($staff['password']); ?>" required>
        <button type="submit" name="update_staff">Update Staff</button>
    </form>

    <ul>
        <li> <a href="../page/main.php?page=staff">Back to Staff List</a></li>
    </ul>
</body>

</html>