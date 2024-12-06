<?php 
    namespace App\OnlineBookshop;

    class Product{
          //functie om de 5 meest recent toegevoegde producten op te halen
          public static function getRecentProducts(){
            $conn = Db::getConnection();
            $statement = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 5");
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Haalt alle producten op
      public static function getProducts(){
          $conn = Db::getConnection();
          $statement = $conn->query("SELECT * products");
          return $statement->fetchAll(\PDO::FETCH_ASSOC);
      }
      
    //Het totaalbedrag berkenen
    public static function getTotalPrice($cart, $products){
        $total_price = 0;
      foreach($products as $product){
        if(isset($cart[$product['id']])){
          $quantity = $cart[$product['id']];
          $total_price += $product['product_price'] * $quantity;
        }
      }
        return $total_price;
    }
}