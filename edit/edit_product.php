<?php
include "../php/db.php";

// Check if the product ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product details
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Check if the form is submitted for updating the product
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_product'])) {
        $cas_number = $_POST['cas_number'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $packaging = $_POST['packaging'];
        $unit_price = $_POST['unit_price'];
        $image = $product['image']; // Keep the existing image by default

        // Handle file upload if a new image is provided
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $image = $_FILES["image"]["name"];

            // Remove old image if it exists
            if (!empty($product['image'])) {
                $old_image_path = $target_dir . $product['image'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // File upload successful, update the image variable
                } else {
                    echo "<script>alert('Failed to upload image');</script>";
                }
            } else {
                echo "<script>alert('File is not an image');</script>";
            }
        }

        // Update the product details in the database
        $sql = "UPDATE product SET cas_number = ?, name = ?, description = ?, packaging = ?, unit_price = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisi", $cas_number, $name, $description, $packaging, $unit_price, $image, $id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Product successfully updated');
                    window.location.href = '../page/main.php?page=product';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Failed to update product');</script>";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Invalid product ID";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/form.css">
    <style>
        /* Style for the image preview */
        .image-preview {
            max-width: 200px;
            height: auto;
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
    <h3>Edit Product</h3>

    <!-- Form to edit the product -->
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="cas_number" placeholder="CAS Number"
            value="<?php echo htmlspecialchars($product['cas_number']); ?>" required>
        <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($product['name']); ?>"
            required>
        <input type="text" name="description" placeholder="Description"
            value="<?php echo htmlspecialchars($product['description']); ?>" required>
        <input type="text" name="packaging" placeholder="Packaging"
            value="<?php echo htmlspecialchars($product['packaging']); ?>" required>
        <input type="number" step="0.01" name="unit_price" placeholder="Unit Price"
            value="<?php echo htmlspecialchars($product['unit_price']); ?>" required>
        <input type="file" name="image" accept="image/*" onchange="previewImage()">
        <img class="image-preview"
            src="<?php echo !empty($product['image']) ? '../upload/' . htmlspecialchars($product['image']) : ''; ?>"
            alt="Product Image">
        <button type="submit" name="edit_product">Update Product</button>
    </form>

    <ul>
        <li><a href="../page/main.php?page=product">Back to Product List</a></li>
    </ul>
</body>

</html>