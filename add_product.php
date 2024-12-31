<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];
    $target_dir = "uploads/";
    $file_name = uniqid() . "_" . basename($image["name"]);
    $target_file = $target_dir . $file_name;
    // Ensure the directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir);
    }
    // Validate file type
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_type, $allowed_types)) {
        die("Only image files (JPG, JPEG, PNG, GIF) are allowed.");
    }
    // Validate file size
    if ($image["size"] > 5000000) { // Limit to 500 KB
        die("File size exceeds the maximum allowed limit.");
    }
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        echo "File uploaded successfully: " . $file_name;
    } else {
        echo "Failed to upload file.";
    }


    $sql ="INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', $price, '$target_file')";
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <h1>Add Product</h1>
    <input type="text" name="name" placeholder="Product Name" required>
    <textarea name="description" placeholder="Product Description" required></textarea>
    <input type="number" name="price" placeholder="Price" step="0.01" required>
    <input type="file" name="image" required>
    <button type="submit">Add Product</button>
</form>
