<?php 
    //PDO Connection
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;
    use App\OnlineBookshop\Product;

    if($_SESSION['loggedin']!== true){
        header('Location: signup.php'); //login.php verandert naar signup.php
    }

    //Aantal woorden dat ik wil tonen in de productbeschrijving
    $word_limit = 35;

    //Verkort de tekstfunctie
    function truncate_text($text, $limit){
        $words = explode(' ', $text);
        if(count($words) > $limit){
            return implode(' ', array_slice($words, 0, $limit)) . '...';
        }
        return $text;
    }

    $conn = Db::getConnection();

    $sql = "SELECT * FROM products";

    //SELECT * from genres, om de producten per genre te laten filteren
    $statement = $conn->query("SELECT * FROM genres");
    $genres = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['genre']) && !empty($_POST['genre'])){
        $genre_id = $_POST['genre'];
        $statement = $conn->prepare('SELECT * FROM products WHERE genre_id = :genre_id');
        $statement->bindParam(':genre_id', $genre_id);
    }else{
        $statement = $conn->prepare('SELECT * FROM products');
    }

    //SELECT * from products and fetch as array:
    $statement->execute();
    $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //Toevoegen aan winkelmandje
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])){
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'] ?? 1;

        //Controleer of de winkelmand al bestaat
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }

        //Voeg het product toe aan de winkelmand
        if(isset($_SESSION['cart'][$product_id])){
            $_SESSION['cart'][$product_id] += $quantity;
        }else{
            $_SESSION['cart'][$product_id] = $quantity;
        }

        $_SESSION['feedback'] = "Product is toegevoegd aan de winkelmand!";
        header('Location: browse.php');
        exit;
    }
    
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Products</title>
    <link rel="stylesheet" type="text/css" href="css/browse.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <!--Feedback aan de gebruiker tonen-->
    <?php if(isset($_SESSION['feedback'])): ?>
        <p class="feedbackMsg"><?php echo htmlspecialchars($_SESSION['feedback']); ?></p>
        <?php unset($_SESSION['feedback']); ?>
    <?php endif; ?>

    <!--Dropdown menu om de producten per genre te kunnen filteren-->
    <h2 class="genre-h2">Bekijk ons gans assortiment!</h2>
    <form method="POST" action="">
        <label for="genre" class="genre-title">Filter op genre:</label>
        <select name="genre" id="genre" class="genre-select">
            <option value="">Alle genres</option>
            <?php foreach($genres as $genre):?>
            <option value="<?php echo $genre['id']; ?>">
                <?php echo htmlspecialchars($genre['genre_name']); ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="search-Btn">Zoek</button>
    </form>

   <!--De producten op de pagina displayen--> 
   <div class="product-container">
        <?php foreach($products as $product): ?>
    <article class="product">
        <h2 class="product-name">
        <a href="productDetails.php?id=<?php echo $product['id']; ?>">
            <?php echo $product['product_name']; ?>
            <img src="<?php echo"./".htmlspecialchars($product['product_img']);?>" class="product-img">
        </a> 
        </h2>

        
        <!--Beperkt de beschrijving tot een bepaald aantal woorden-->
        <h4 class="product-description"><?php echo (htmlspecialchars(truncate_text($product['product_description'], $word_limit))); ?>

        <!--Als de beschrijving te lang is, word er een "lees meer" link getoond-->
        <?php if(str_word_count($product['product_description']) > $word_limit): ?>
            <a href="productDetails.php?id=<?php echo $product['id'];?>" class="readMore">Lees meer</a>            
        <?php endif; ?>
        </h4>
        <h3>€<?php echo $product['product_price'];?></h3>

        <!--Producten kunnen toevoegen aan winkelmandje-->
        <?php if($_SESSION['usertype'] == 0): ?>
        <form method="POST" action="browse.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <label for="quantity-<?php echo $product['id']; ?>">Aantal:</label>
            <input type="number" id="quantity-<?php echo $product['id']; ?>" name="quantity" value="1">
            <button type="submit" name="add_to_cart" class="add_to_cartBtn">Voeg toe aan het winkelmandje</button>
        </form>
        <?php endif ?>

        <!--Producten kunnen bewerken (als admin)-->
        <?php if($_SESSION['usertype'] == 1): ?>
        <form method="GET" action="adminEditProduct.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="edit-Btn">Bewerk het product</button>
        </form>

        <!--Producten kunnen verwijderen (als admin!)-->
        <form method="POST" action="adminDeleteProduct.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="delete-Btn">Verwijder dit product</button>
        </form>
        <?php endif ?>
    </article>
    <?php endforeach; ?>
    </div>
</body>
</html>

<!--Make it so you show ALL your products here!-->