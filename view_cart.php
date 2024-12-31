<?php
session_start();
include 'db.php';

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "Your cart is empty.";
    exit;
}

// Fetch product details from the database
$product_ids = implode(',', array_keys($cart));
$sql = "SELECT * FROM products WHERE id IN ($product_ids)";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $grand_total = 0; ?>
            <?php while ($product = $result->fetch_assoc()): ?>
                <?php 
                $product_id = $product['id'];
                $quantity = $cart[$product_id];
                $total = $product['price'] * $quantity;
                $grand_total += $total;
                ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td>$<?php echo $product['price']; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>$<?php echo $total; ?></td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3">Grand Total</td>
                <td>$<?php echo $grand_total; ?></td>
            </tr>
        </tbody>
    </table>
    <a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
