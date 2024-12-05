<?php 
    //PDO Connection
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;
    use App\OnlineBookshop\Product;
    
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        $cart_empty = true;
    }else{
        $cart_empty = false;
    }

    //Productgegevens ophalen uit de database
    $conn = Db::getConnection();


    if(!$cart_empty){
    //Maak placeholders aan voor de query
    $product_ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));

    //Haal de productinformatie op uit de database
    $statement = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $statement->execute($product_ids);
    $products = $statement->fetchAll(\PDO::FETCH_ASSOC);
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkeldmand</title>
    <link rel="stylesheet" type="text/css" href="css/cart.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <div class="cart-container">
    <?php if(!$cart_empty): ?>
        <div class="cart-header">
            <h2>Je winkelmand</h2>
        </div>

        <form method="POST" action="update_cart.php">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Aantal</th>
                        <th>Prijs</th>
                        <th>Subtotaal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $product): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($product['product_img']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                <?php echo htmlspecialchars($product['product_name']); ?>
                            </td>
                            <td>
                                <input type="number" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $_SESSION['cart'][$product['id']]; ?>">
                            </td>

                            <td>€<?php echo number_format($product['product_price'], 2); ?></td>
                            <td>€<?php echo number_format($product['product_price'] * $_SESSION['cart'][$product['id']], 2); ?></td>

                            <td>
                                <a href="remove_from_cart.php?product_id=<?php echo $product['id']; ?>">Verwijder</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-actions">
            <button type="submit" name="update_cart">Winkelmand bijwerken</button>
            <a href="checkout.php" class="checkoutBtn">Naar afrekenen</a>
            </div>
        </form>

    <?php else: ?>
        <div class="cart-empty">
            <p>Uw winkelmand is leeg. <a href="index.php">Ga terug naar de winkel</a></p>
        </div>
    <?php endif; ?>
</body>
</html>
