<?php 
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;

    $conn = Db::getConnection();

    //SELECT * from genres, om de producten per genre te laten filteren
    $statement = $conn->query("SELECT * FROM genres");
    $genres = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //Haal alle auteurs op
    $statement = $conn->query("SELECT * FROM authors");
    $authors = $statement->fetchAll(\PDO::FETCH_ASSOC);

    //Logica om de auteurs te verwerken
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_author'])){
        //Haal de waarde van author_name op
        $author_name = htmlspecialchars($_POST['author_name']);

        //var_dump($author_name); Debug: Check wat hier wordt opgehaald
        if(empty($author_name)){
            echo "<p>De naam van de auteur mag niet leeg zijn.</p>";
            exit;
        }

        try{
            //Bereid de query voor
            $sql = "INSERT INTO authors (author_name) VALUES (:author_name)";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':author_name', $author_name);

            //Voer de query uit
            if($statement->execute()){
                //Redirect na een succesvolle toevoeging
                header("Location: admin.php");
                exit;
            }else{
                echo "<p>Er is een fout opgetreden, de auteur kan niet worden toegevoegd.</p>";
            }
        }catch(PDOException $e){
            echo "<p>Er is een fout opgetreden:" . $e->getMessage() . "</p>";
        }
    }

    //Logica om de categorien te verwerken
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])){
        //Haal de waarde van genre_name op
        $genre_name = htmlspecialchars($_POST['genre_name']);

        //var_dump($genre_name); Debug: Check wat hier wordt opgehaald
        if(empty($genre_name)){
            echo "<p>De naam van de categorie mag niet leeg zijn.</p>";
            exit;
        }

        try{
            //Bereid de query voor
            $sql = "INSERT INTO genres (genre_name) VALUES (:genre_name)";
            $statement = $conn->prepare($sql);
            $statement->bindParam(':genre_name', $genre_name);

            //Voer de query uit
            if($statement->execute()){
                //Redirect na een succesvolle toevoeging
                header("Location: admin.php");
                exit;
            }else{
                echo "<p>Er is een fout opgetreden, de categorie kan niet worden toegevoegd.</p>";
            }
        }catch(PDOException $e){
            echo "<p>Er is een fout opgetreden:" . $e->getMessage() . "</p>";
        }
    }

    //Controleer of de gebruiker is ingelogd
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
        //gebruiker is niet ingelogd, redirect naar login.php
        header("Location: login.php");
        exit;
    }

    //Controleert of de geburiker een admin is
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

    <div class="form-container">
        <div class="form-section">
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

        <label for="author">Selecteer een auteur:</label>
        <select name="author" id="author">
            <option value="">Alle auteurs</option>
            <?php foreach($authors as $author): ?>
            <option value="<?php echo $author['id']; ?>">
                <?php echo htmlspecialchars($author['author_name']); ?>
            </option>
            <?php endforeach; ?>
            </select><br><br>
        
        <label for="genre">Selecteer een genre:</label>
        <select name="genre" id="genre">
            <option value="">Alle genres</option>
            <?php foreach($genres as $genre):?>
            <option value="<?php echo $genre['id']; ?>">
                <?php echo htmlspecialchars($genre['genre_name']); ?>
            </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit" class="submit-Btn">Voeg product toe</button> <!--Verander deze kleur naar aquamarine-->
    </form>

    <!--Een nieuwe categorie toevoegen-->
    <h2>Voeg een nieuw genre toe.</h2>
    <form method="POST" class="category_form">
        <label for="genre_name">Genre naam:</label>
        <input type="text" name="genre_name" id="genre_name" required> <br><br> 
        <button type="submit" name="add_category" value="1" class="submit-Btn">Voeg genre toe</button>
    </form>

    <!--Een nieuwe auteur toevoegen-->
    <h2>Voeg een nieuwe auteur toe.</h2>
    <form method="POST" class="category_form">
        <label for="author_name">Naam van de auteur:</label>
        <input type="text" name="author_name" id="author_name" required> <br><br> 
        <button type="submit" name="add_author" value="1" class="submit-Btn">Voeg auteur toe</button>
    </form>
    </div>
    </div>
    
</body>
</html>