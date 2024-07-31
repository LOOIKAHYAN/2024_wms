<?php
include "../php/db.php";

// Handle form submission for adding a new staff member
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_staff'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Insert new staff member into the database
    $sql = "INSERT INTO staff (name, email, contact_no, username, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $contact_no, $username, $password);

    if ($stmt->execute()) {
        ?>
        <script>alert("New staff successfully added")</script>
        <?php
    } else {
        ?>
        <script>alert("Failed to add new staff")</script>
        <?php
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Staff</title>
    <script src="../javascript/load_content.js"></script>
    <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <h3>Add New Staff</h3>

    <!-- Form to add a new staff -->
    <form action="" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="contact_no" placeholder="Contact No" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add_staff">Add Staff</button>
    </form>

    <ul>
        <li><a href="../page/main.php?page=staff">Back to Staff List</a></li>
    </ul>
</body>

</html>