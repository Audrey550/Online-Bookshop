<?php 
    namespace App\OnlineBookshop;

    class Product{
          //functie om de 5 meest recent toegevoegde producten op te halen
          public static function getRecentProducts(){
            $conn = Db::getConnection();
            $statement = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 5");
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}