<?php 
    /* Om te checken of je databank is geconnecteerd: 
    $conn = $mysqli = new mysqli('localhost', 'root', '', 'bookshop'); 
        if($conn->connect_error){
            echo "ERROR";
        }else{
            echo "Connected";
        }*/

        /* Manier om aan je databank te geraken: 
        $conn = $mysqli = new mysqli('localhost', 'root', '', 'bookshop'); 
        //select * from products and loop

        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        //var_dump($products);*/

        //PDO Connection
        $conn = new PDO('mysql:dbname=bookshop;host=localhost', "root", "");

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
</head>
<body>
    <h1>Online Bookshop</h1>
    <?php foreach($products as $product): ?>
    <article>
        <h2><?php echo $product['title']?>: €<?php echo $product['price']?></h2>
    </article>
    <?php endforeach; ?>
</body>
</html>