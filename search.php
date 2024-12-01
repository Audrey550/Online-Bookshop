<?php
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;

    //Controleer of de zoekterm is ingesteld
    $conn = Db::getConnection();

    if(isset($_GET['search']) && !empty($_GET['search'])){
        $search = $_GET['search'];

        $sql = "SELECT * FROM products WHERE LOWER(product_name) LIKE LOWER(:search) OR author_id IN (SELECT id FROM authors WHERE LOWER(author_name) LIKE LOWER(:search))";
        $statement = $conn->prepare($sql);
        $statement->bindValue(':search', '%' . $search . '%');
        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if($results){
            //Het eerste product in de zoekresultaten
            $firstProduct = $results[0];   

            header('Location: productDetails.php?id=' . $firstProduct['id']);
            exit;
        }else{
            echo "Geen resultaten gevonden";
        }
    }
?>