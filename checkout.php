<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $cart = $_SESSION['cart'];
    $total = 0;

    foreach ($cart as $product_id => $quantity) {
        $sql = "SELECT price FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        $product = $result->fetch_assoc();
        $total += $product['price'] * $quantity;
    }

    // Insert into orders table
    $sql = "INSERT INTO orders (user_id, total) VALUES ($user_id, $total)";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert into order_items table
        foreach ($cart as $product_id => $quantity) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                    VALUES ($order_id, $product_id, $quantity, (SELECT price FROM products WHERE id = $product_id))";
            $conn->query($sql);
        }

        // Clear the cart
        $_SESSION['cart'] = [];
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    exit;
}
?>
<form method="POST">
    <h1>Checkout</h1>
    <button type="submit">Place Order</button>
</form>
