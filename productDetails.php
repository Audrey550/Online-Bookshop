<?php
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;    
    
    $conn = Db::getConnection();

    //Controleer of er een 'id' in de url zit
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $product_id = $_GET['id'];

    //Haal de productgegevens en auteurs op op basis van het product-id
    $statement = $conn->prepare('SELECT p.*, a.author_name FROM products p LEFT JOIN authors a ON p.author_id = a.id WHERE p.id = :id');

    //$statement = $conn->prepare('SELECT * FROM products WHERE id = :id');
    $statement->bindParam(':id', $product_id);
    $statement->execute();
    $product = $statement->fetch(\PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" type="text/css" href="css/browse.css?<?php echo time(); ?>"/>

</head>
<body>
    <?php include_once("nav.inc.php"); ?>
        
        <div class="product-details">

        <div class="product-image">
        <img src="<?php echo './' .htmlspecialchars($product['product_img']); ?>" alt="<?php echo htmlspecialchars($product['product_name']);?>"></div>

        <div class="product-info">
        <h1><?php echo htmlspecialchars($product['product_name']);?></h1>
        <p><?php echo htmlspecialchars($product['author_name']);?></p>
        <p><?php echo htmlspecialchars($product['product_description']); ?></p>
        <p>€<?php echo number_format($product['product_price'], 2, ',','.'); ?></p><!--Zorgt dat de cijfers decimaal zijn-->

        <!--Zorgt dat de cijfers decimaal zijn-->
        <a href="index.php" class="returnToHome">Ga terug naar de homepage</a>

        <?php if($_SESSION['usertype'] == 1): ?>
        <form method="GET" action="adminEditProduct.php">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <button type="submit" class="edit-Btn" style="margin-top: 20px">Bewerk het product</button>
        </form>
        <?php endif ?>

        </div>
    </div>
</body>
</html>