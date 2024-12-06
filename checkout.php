<?php 
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;
    use App\OnlineBookshop\Product;

    //Controleren of de gebruiker is ingelogd
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        header('Location: login.php');
        exit;
    }

    //Hall de gebruiker op uit de database
    $conn = Db::getConnection();
    $client_id = $_SESSION['id'];
    $statement = $conn->prepare("SELECT credits FROM clients WHERE id = ?");
    $statement->execute([$client_id]);
    $client = $statement->fetch(\PDO::FETCH_ASSOC);

    if(!$client){
        echo "Gebruiker niet gevonden.";
        exit;
    }

    //Bereken het totaalbedrag van de winkelmand
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        echo "Je winkelmand is leeg.";
        exit;
    }
        $product_ids = array_keys($_SESSION['cart']);
        $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
        $statement = $conn->prepare("SELECT id, product_price FROM products WHERE id IN ($placeholders)");
        $statement->execute($product_ids);
        $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $total_price = Product::getTotalPrice($_SESSION['cart'], $products);

        //Variabelen voor het tonen van de bevestiging
        $payement_success = false;
        $error_message = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Heeft de gebruiker voldoende credits?
            if($client['credits'] < $total_price){
                $error_message = "Je hebt niet genoeg credits om af te rekenen.";
            }else{
            //Trek het totaalbedrag af van de credits van de gebruiker
            $new_credits = $client['credits'] - $total_price;
            $statement = $conn->prepare("UPDATE clients SET credits = ? WHERE id = ?");
            $statement->execute([$new_credits, $client_id]);

            //Maak de winkelmand leeg
            unset($_SESSION['cart']);

            //Succesbericht tonen
            $payement_success = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrekenen</title>
    <link rel="stylesheet" type="text/css" href="css/cart.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <div class="checkout-container">
        <?php if($payement_success): ?>
            <h1>Betaling geslaagd</h1>
            <p>Bedankt voor je aankoop! Je nieuwe creditsaldo is: €<?php echo number_format($new_credits, 2); ?></p>
            <a href="index.php" class="button">Ga terug naar de winkel</a>
        <?php else: ?>

            <h2>Bevestig je betaling</h2>
            <?php if(!empty($error_message)): ?>
                <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>

            <div class="credit-info">
                <p>Beschikbare credits: €<?php echo number_format($client['credits'], 2); ?></p>
            </div>

            <div class="cart-summary">
                <p>Totaalbedrag van de winkelmand:</p>
                    €<?php echo isset($total_price) ? number_format($total_price, 2) : '0.00'; ?></p>
            </div>

            <form method="POST" action="checkout.php">
                <button type="submit" class="button">Bevestig betaling</button>
            </form>

            <form method="POST" action="cart.php">
                <button type="submit" class="button">Terug naar de winkelmand</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html> 