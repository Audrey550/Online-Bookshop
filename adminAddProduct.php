<?php 
     include_once(__DIR__ . "/classes/Db.php");

    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['usertype'] != 1){
        header("Location: index.php");
        exit;
    }
    
    $conn = Db::getConnection();

    if(isset($_POST['product_name'])){
        $product_name = htmlspecialchars($_POST['product_name']);
        $product_description = htmlspecialchars($_POST['product_description']);
        $product_price = $_POST['product_price'];
        $genre_id = $_POST['genre_id'];

        try{ 
            $sql = "INSERT INTO products(product_name, product_description, product_price, genre_id) VALUES (:product_name, :product_description, :product_price, :genre_id)";

            $statement = $conn->prepare($sql);

            $statement->bindParam(':product_name', $product_name);
            $statement->bindParam(':product_description', $product_description);
            $statement->bindParam(':product_price', $product_price);
            //$statement->bindParam(':genre_id', $genre_id);

            if($statement->execute()){
                echo "Product succesvol toegevoegd";
                header("Location: admin.php");
                exit;
            }else{
                echo "Er is een fout opgetreden, kan product niet toevoegen.";
            }
        } catch (Exception $e){
            echo "Er is een fout opgetreden:" . $e->getMessage();
        }
    } else{
        echo "Het formulier is niet correct verzonden";
    }
?>