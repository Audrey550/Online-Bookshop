<?php 
    include_once(__DIR__ . "/classes/Db.php");
     session_start();

    //Controleert of de gebruiker is ingelogd en of deze een admin is
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['usertype'] !=1){
        header("Location: index.php");
        exit;
    }

    $conn = Db::getConnection();

    //Haal alle genres op
    $statement = $conn->query("SELECT * FROM genres");
    $statement->execute();
    $genres = $statement->fetchAll(PDO::FETCH_ASSOC);

    //Haal auteurs op
    $statement = $conn->query("SELECT * FROM authors");
    $statement->execute();
    $authors = $statement->fetchAll(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
    //Haal het product_ID op uit de url
    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];

        //Haal de productgegevens op uit de database
        $statement = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
        $statement->bindParam(':product_id', $product_id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$product){
            echo "Product niet gevonden";
            exit;
        }
    }else{
        echo "Geen product geselecteerd";
        exit;
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'POST'){
    //De wijzegingen van het product verwerken
    if(isset($_POST['product_id'], $_POST['product_name'], $_POST['product_description'], $_POST['product_price'], $_POST['genre'])){
        $product_id = $_POST['product_id'];
        $product_name = htmlspecialchars($_POST['product_name']);
        $product_description = htmlspecialchars($_POST['product_description']);
        $product_price = $_POST['product_price'];
        $genre_id = $_POST['genre'];
        $author_id = $_POST['author'];

        try{
            $sql = "UPDATE products SET product_name = :product_name, product_description = :product_description, product_price = :product_price, genre_id = :genre_id WHERE id = :product_id";

            $statement = $conn->prepare($sql);
            $statement->bindParam(':product_id', $product_id);
            $statement->bindParam(':product_name', $product_name);
            $statement->bindParam(':product_description', $product_description);
            $statement->bindParam(':product_price', $product_price);
            $statement->bindParam(':genre_id', $genre_id);
            $statement->bindParam(':author_id', $author_id);

            if($statement->execute()){
                echo "Product is bijgewerkt!";
                header("Location:admin.php");
                exit;
            }else{
                echo "Er is iets fout gegaan bij het bewerken van dit product";
            }
        }catch(Exception $e){
            echo "Fout: " . $e->getMessage();
        }
    }else{
        echo "Ongeldige invoer";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bewerk een product</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <?php if($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
        <h1>Bewerk hier een product.</h1>
        <form action="adminEditProduct.php" method="POST" class="product-form">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">

            <label for="product_name">Productnaam:</label>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>"required> <br><br>

            <label for="product_description" >Product beschrijving:</label>
            <textarea name="product_description" id="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea> <br><br>

            <label for="product_price">Prijs (€):</label>
            <input type="number" id="product_price" name="product_price" step="0.01" value="<?php echo htmlspecialchars($product['product_price']); ?>" required> <br><br>

            <label for="genre">Selecteer een genre:</label>
            <select name="genre" id="genre">
                <option value="">Alle genres</option>
                    <?php foreach($genres as $genre):?>
                <option value="<?php echo $genre['id']; ?>">
                    <?php echo htmlspecialchars($genre['genre_name']); ?>
                </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="author">Selecteer een auteur:</label>
            <select name="author" id="author">
                <option value="">Alle auteurs</option>
                    <?php foreach($authors as $author):?>
                <option value="<?php echo $author['id']; ?>">
                    <?php echo htmlspecialchars($author['author_name']); ?>
                </option>
                <?php endforeach; ?>
            </select><br><br>

            <button type="submit" class="submit-Btn">Wijzigingen opslaan</button>
        </form>
    <?php endif; ?>
</body>
</html>

<!--Kan genres en auteurs niet aanpassen-->