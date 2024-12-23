<?php 
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;


    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['usertype'] != 1){
        header("Location: index.php");
        exit;
    }
    
    $conn = Db::getConnection();

    if(isset($_POST['product_name'])){
        $product_name = htmlspecialchars($_POST['product_name']);
        $product_description = htmlspecialchars($_POST['product_description']);
        $product_price = $_POST['product_price'];
        //$product_img = $_POST['product_img'];
        $genre_id = $_POST['genre'];
        $author_id = $_POST['author'];

        try{ 
            $sql = "INSERT INTO products(product_name, product_description, product_price, genre_id, author_id) VALUES (:product_name, :product_description, :product_price, :genre_id, :author_id)";

            $statement = $conn->prepare($sql);

            $statement->bindParam(':product_name', $product_name);
            $statement->bindParam(':product_description', $product_description);
            $statement->bindParam(':product_price', $product_price);
            //$statement->bindParam(':product_img', $product_img);
            $statement->bindParam(':genre_id', $genre_id);
            $statement->bindParam(':author_id', $author_id);

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