<?php include 'navbars.php'; ?>
<?php
include 'db.php';


$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional: Link to your CSS file -->
    <link rel="stylesheet" href="navbars.css">
</head>
<body>




<?php $category_id = $_GET['category'] ?? '';
if ($category_id) {
    $sql = "SELECT * FROM products WHERE category_id = $category_id";
} else {
    $sql = "SELECT * FROM products";
}
$result = $conn->query($sql);

$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM products WHERE name LIKE '%$search%'";
$result = $conn->query($sql);

// Add Category Filter Dropdown
$categories = $conn->query("SELECT * FROM categories");
?>
<form method="GET">
    <select name="category" onchange="this.form.submit()">
        <option value="">All Categories</option>
        <?php while ($category = $categories->fetch_assoc()): ?>
            <option value="<?php echo $category['id']; ?>" <?php if ($category_id == $category['id']) echo 'selected'; ?>>
                <?php echo $category['name']; ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>

<br>
    <div class="product-grid">
        <?php
        // Check if products exist
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="product-card">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>Price: ৳<?php echo $row['price']; ?></p>
                    <a href="product_details.php?id=<?php echo $row['id']; ?>" class="btn">View Details</a>
                </div>
                <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
</body>
</html>
