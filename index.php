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

    //var_dump($products);

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

    <div class="categoryIcons">
        <img src="img/categories.png">
    </div>

    <div class="topPicks">
        <h2>Bekijk onze topkeuzes</h2>
    </div>
    
    <div class="topDeals">
        <h2>Bekijk onze topdeals</h2>
        <img src="img/booksalesIcon.png">
    </div>

    <?php foreach($products as $product): ?>
    <article>
        <h2><?php echo $product['title']?>: €<?php echo $product['price']?></h2>
    </article>
    <?php endforeach; ?>
</body>
</html>
