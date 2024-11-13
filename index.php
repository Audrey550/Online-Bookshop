<?php 
    //PDO Connection
    include_once(__DIR__ . "/classes/Db.php");
    include_once(__DIR__ . "/classes/Client.php");


    session_start(); //Zo weet de server wie jij bent
        if($_SESSION['loggedin']!== true){
        header('Location: signup.php'); //login.php verandert naar signup.php
    }

    $conn = Db::getConnection();

    $sql = "SELECT * FROM products";

    //SELECT * from genres, om de producten per genre te laten filteren
    $statement = $conn->query("SELECT * FROM genres");
    $genres = $statement->fetchAll(PDO::FETCH_ASSOC);

    //SELECT * from products and fetch as array:
    $statement = $conn->prepare('SELECT * FROM products');
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

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
    
    <!--Dropdown menu om de producten per genre te kunnen filteren-->
    <h2>Bekijk onze boeken</h2>

    <!--De style plaats je als laatste in de tag, bv; form method="" action="post" style=" "-->
    <form method="" action="post">
        <label for="genre" style="">Filter op genre:</label>
        <select name="genre" id="genre" style="color #292b35; background-color: white; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="">Alle genres</option>
            <?php foreach($genres as $genre):?>
            <option value="<?php echo $genre['id']; ?>">
                <?php echo htmlspecialchars($genre['genre_name']); ?>
            </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" style= "background-color: #2a2454; color: white; padding: 6px 10px; border: none; border-radius: 5px; cursor: pointer;">Zoek</button>
    </form>


   <!--De producten op de pagina displayen--> 
    <?php foreach($products as $product): ?>
    <article style="max-width: 500px; display:inline-block;">
        <h2 style="color: #292b35; "><?php echo $product['product_name']?></h2>

        <img src="<?php echo"./".htmlspecialchars($product['product_img']);?>"style="max-width: 150px;">
        
        <h4 style="color:#292b35; font-weight:lighter;"><?php echo $product['product_description']?></h4>
        <h3>€<?php echo $product['product_price']?></h3>

    </article>
    <?php endforeach; ?>
</body>
</html>
