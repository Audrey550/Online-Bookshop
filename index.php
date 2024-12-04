<?php 
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;
    use App\OnlineBookshop\Product;

   //Check if user is logged in
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

    //SELECT * from genres, om de producten per genre te laten filteren
    $statement = $conn->query("SELECT * FROM genres");
    $genres = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //SELECT * from products and fetch as array:
    $statement->execute();
    $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //Haal de 5 meest recent toegevoegde producten op
    $recentProducts = Product::getRecentProducts(5);

    //Haalt alle producten op
    $allProducts = $statement->fetchAll(\PDO::FETCH_ASSOC);


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audrey's Bookstore</title>
    <link rel="stylesheet" type="text/css" href="css/index.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
    <img class="headerimg" src="img/headerVisual.png">

    <div class="categoryIcons"> <!--Change img to individual icons for each category-->
        <img src="img/categories.png">
    </div>

    <div class="topPicks"> <!--A mockup of the top 3 listing of the most bought items that week-->
        <h2>Onze bestsellers van deze week</h2>
            <div class="topOne">
                <h1>1</h1>
                <h3>Get A Life, Chloe Brown <br> Talia Hibbert</h3>
            </div>
    </div>

    <!--Dropdown menu om de producten per genre te kunnen filteren. Delete from index later!!--> 
    <h2 class="recent-products-title">Nieuwe boeken, net binnen!</h2>
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

    <!--De recente producten op de pagina displayen-->
    <div class="recent-products-container">
        <?php foreach($recentProducts as $product): ?>
        <article class="recent-product">
            <h2 class="product-name">
            <a href="productDetails.php?id=<?php echo $product['id']; ?>">
                <?php echo $product['product_name']; ?>
            </a> 
            </h2>

            <img src="<?php echo"./".htmlspecialchars($product['product_img']);?>" class="product-img">
            <h4 class="product-description"><?php echo (htmlspecialchars(truncate_text($product['product_description'], $word_limit))); ?>

            <?php if(str_word_count($product['product_description']) > $word_limit): ?>
                <a href="productDetails.php?id=<?php echo $product['id'];?>" class="readMore">Lees meer</a>            
            <?php endif; ?>
            </h4>
            <h3>€<?php echo $product['product_price'];?></h3>

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