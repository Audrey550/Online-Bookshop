<?php 
     include_once(__DIR__ . "/classes/Db.php");
     include_once(__DIR__ . "/classes/Client.php");

    session_start();
    $conn = Db::getConnection();

    //SELECT * from genres, om de producten per genre te laten filteren
    $statement = $conn->query("SELECT * FROM genres");
    $genres = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){ //zet in commentaar als je de admin page wil zien
        //gebruiker is niet ingelogd, redirect naar login.php
        header("Location: login.php");
        exit;
    }

    if($_SESSION['usertype'] != 1){
        header("Location: index.php");
        exit;
    } 
    
    echo "<h1>Welkom, Admin!</h1>";

    

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="css/index.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <h2>Voeg een nieuw product toe</h2>
    <form action="adminAddProduct.php" method="POST">
        <label for="product_name">Productnaam:</label>
        <input type="text" name="product_name" id="product_name" required> <br><br>

        <label for="product_description">Productnaam:</label>
        <textarea name="product_description" id="product_description" required></textarea><br><br>

        <label for="product_price">Prijs (€):</label>
        <input type="number" name="product_price" id="product_price" step="0.01" required> <br><br>
        
        <!--<label for="product_img">Afbeelding:</label>
        <input type="file" name="product_img" id="product_img" required> <br><br>-->
        
        <label for="genre" style="">Selecteer een genre:</label>
        <select name="genre" id="genre" style="color #292b35; background-color: white; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="">Alle genres</option>
            <?php foreach($genres as $genre):?>
            <option value="<?php echo $genre['id']; ?>">
                <?php echo htmlspecialchars($genre['genre_name']); ?>
            </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Voeg product toe</button>
    </form>

</body>
</html>