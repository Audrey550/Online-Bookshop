<?php 
include_once(__DIR__ . "/classes/Db.php");

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true || $_SESSION['usertype'] != 1){
    header("Location: index.php");
    exit;
}

if(isset($_POST['product_id'])){
    $product_id = $_POST['product_id'];

    $conn = Db::getConnection();

    try{
        $sql = "DELETE FROM products WHERE id = :product_id";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':product_id', $product_id);

        if($statement->execute()){
            echo "Product is verwijderd";
            header("Location: admin.php");
            exit;
        }else{
            echo "Er is iets misgegaan bij het verwijderen van dit product";
        }
    }catch (Exception $e){
        echo "Er is een fout opgetreden: " . $e->getMessage();
    }
}else{
    echo "Er is geen product geselecteerd om te verwijderen";
}
?>