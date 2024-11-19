<?php
    include_once(__DIR__ . "/classes/Db.php");
    session_start();

    $conn = Db::getConnection();

    //Controleer of er een 'id' in de url zit
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $product_id = $_GET['id'];

    //Haal de productgegevens op op basis van het product-id
    $statement = $conn->prepare('SELECT * FROM products WHERE id = :id');
    $statement->bindParam(':id', $product_id);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);

    //Als het product niet gevonden is, geef dan een foutmelding
    if(!$product){
        echo "Product niet gevonden";
        exit;
    }
}else{
    echo "Geen product geselecteerd";
    exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> Productdetails</title>
    <link rel="stylesheet" type="text/css" href="css/index.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>
        
        <div class="product-details">

        <div class="product-image">
        <img src="<?php echo './' .htmlspecialchars($product['product_img']); ?>" alt="<?php echo htmlspecialchars($product['product_name']);?>"></div>

        <div class="product-info">
        <h1><?php echo htmlspecialchars($product['product_name']);?></h1>
        <p>€<?php echo number_format($product['product_price'], 2, ',','.'); ?></p><!--Zorgt dat de cijfers decimaal zijn-->
        <p><?php echo htmlspecialchars($product['product_description']); ?></p>

        <!--Zorgt dat de cijfers decimaal zijn-->
        <a href="index.php" class="returnToHome">Ga terug naar de homepage</a>
        </div>
    </div>
</body>
</html>