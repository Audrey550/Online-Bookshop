<?php 
    //PDO Connection
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        $cart_empty = true;
    }else{
        $cart_empty = false;
    }

    //Productgegevens ophalen uit de database
    $conn = Db::getConnection();
    $product_ids = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($product_ids), '?'));

    //Haal de productinformatie op uit de database
    $statement = $conn->query("SELECT * FROM products WHERE id IN ($placeholders)");
    $statement->execute($product_ids);
    $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkeldmand</title>
    <link rel="stylesheet" type="text/css" href="css/cart.css?<?php echo time(); ?>"/>
</head>
<body>
    <h2>Winkelmand</h2>

    <?php if(!empty($_SESSION['cart'])): ?>
        <form method="POST" action="update_cart.php">
            <table>
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
            <button type="submit" name="update_cart">Winkelmand bijwerken</button>
        </form>
        <a href="checkout.php">Naar afrekenen</a>

    <?php else: ?>
        <p>Uw winkelmand is leeg</p>
    <?php endif; ?>
</body>
</html>
