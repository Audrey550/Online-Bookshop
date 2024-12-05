<?php 
    //PDO Connection
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;
    use App\OnlineBookshop\Product;
    
    //Verwijder actie voor het verwijderen van een product uit de winkelmand
    if(($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['remove_product_id']))){
        $product_id_to_remove = $_GET['remove_product_id'];

        //Verwijder het product uit de winkelmand
        if(isset($_SESSION['cart'][$product_id_to_remove])){
            unset($_SESSION['cart'][$product_id_to_remove]);
        }
            //Controleren of de winkelmand leeg is
            if(empty($_SESSION['cart'])){
                $cart_empty = true;
        }

    header('Location: cart.php');
    exit;
}

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

    //Verwerk de formulierinput voor het bijwerken van de winkelmand
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])){
        foreach($_POST['quantity'] as $product_id => $quantity){
            //Zorgt dat de hoeveelheid groter is dan 0
            if($quantity > 0){
                $_SESSION['cart'][$product_id] = $quantity;
            }else{
                //Verwijder het product als de hoeveelheid 0 is
                unset($_SESSION['cart'][$product_id]);
        }
    }

    //Redirect naar de winkelmandpagina om de bijgewerkte winkelmand te tonen
    header('Location: cart.php');
    exit;
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

        <form method="POST" action="cart.php">
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
                                <a href="cart.php?remove_product_id=<?php echo $product['id']; ?>" class="removeBtn">Verwijder</a>
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
