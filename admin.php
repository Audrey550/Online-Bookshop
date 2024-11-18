<?php 
     include_once(__DIR__ . "/classes/Db.php");
     include_once(__DIR__ . "/classes/Client.php");

    session_start();
    $conn = Db::getConnection();

    //SELECT * from genres, om de producten per genre te laten filteren
    $statement = $conn->query("SELECT * FROM genres");
    $genres = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
        //gebruiker is niet ingelogd, redirect naar login.php
        header("Location: login.php");
        exit;
    }

    if($_SESSION['usertype'] != 1){
        header("Location: index.php");
        exit;
    } 

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <h2>Voeg hier een nieuw product toe.</h2>
    <form action="adminAddProduct.php" method="POST" class="product-form">
        <label for="product_name">Productnaam:</label>
        <input type="text" name="product_name" id="product_name" required> <br><br>

        <label for="product_description">Product beschrijving:</label>
        <textarea name="product_description" id="product_description" required></textarea><br><br>

        <label for="product_price">Prijs (€):</label>
        <input type="number" name="product_price" id="product_price" step="0.01" required> <br><br>
        
        <!--<label for="product_img">Afbeelding:</label>
        <input type="file" name="product_img" id="product_img" required> <br><br>-->
        
        <label for="genre">Selecteer een genre:</label>
        <select name="genre" id="genre">
            <option value="">Alle genres</option>
            <?php foreach($genres as $genre):?>
            <option value="<?php echo $genre['id']; ?>">
                <?php echo htmlspecialchars($genre['genre_name']); ?>
            </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit" class="submit-Btn">Voeg product toe</button>
    </form>

    <!--Producten kunnen verwijderen (als admin!)-->
    
</body>
</html>