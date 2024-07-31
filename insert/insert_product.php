<?php
include "../php/db.php";

// Handle form submission for adding a new product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $cas_number = $_POST['cas_number'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $packaging = $_POST['packaging'];
    $unit_price = $_POST['unit_price'];

    // Handle file upload
    $target_dir = "../upload/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $image = $_FILES["image"]["name"];

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert new product into the database
            $sql = "INSERT INTO product (cas_number, name, description, packaging, unit_price, image) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssds", $cas_number, $name, $description, $packaging, $unit_price, $image);

            if ($stmt->execute()) {
                echo "<script>alert('New product successfully added');</script>";
            } else {
                echo "<script>alert('Failed to add new product');</script>";
            }

            // Close statement and connection
            $stmt->close();
        } else {
            echo "<script>alert('Failed to upload image');</script>";
        }
    } else {
        echo "<script>alert('File is not an image');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="../css/form.css">
    <style>
        /* Style for the image preview */
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            display: none;
            /* Hide initially */
            margin-top: 10px;
        }
    </style>
    <script>
        function previewImage() {
            const file = document.querySelector('input[type="file"]').files[0];
            const preview = document.querySelector('.image-preview');
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block'; // Show the image preview
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none'; // Hide if no file is selected
            }
        }
    </script>
</head>

<body>
    <h3>Add New Product</h3>

    <!-- Form to add a new product -->
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="cas_number" placeholder="CAS Number" required>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="description" placeholder="Description" required>
        <input type="text" name="packaging" placeholder="Packaging" required>
        <input type="number" step="0.01" name="unit_price" placeholder="Unit Price" required>
        <input type="file" name="image" accept="image/*" required onchange="previewImage()">
        <img class="image-preview" alt="Image Preview">
        <button type="submit" name="add_product">Add Product</button>
    </form>

    <ul>
        <li><a href="../page/main.php?page=product">Back to Product List</a></li>
    </ul>
</body>

</html>