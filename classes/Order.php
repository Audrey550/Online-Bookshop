<?php 
   namespace App\OnlineBookshop;
   use App\OnlineBookshop\Db;

   class Order{

    public static function getOrderByClientId($clientId){
        try{
            $conn = Db::getConnection();

            if (!$conn) {
                error_log("Database verbinding mislukt");
                return false;
            }

            $statement = $conn->prepare("SELECT * FROM orders WHERE client_id = :client_id");
            $statement->execute([':client_id' => $clientId]);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
            var_dump($orders);
            return $orders;
            
        } catch (Exception $e){
            error_log("Fout bij het ophalen van bestellingen: " . $e->getMessage());
            return false;
        }
    }

    public static function getOrderDetails($orderId){
        try{
            $conn = Db::getConnection();
            $query = "SELECT products.product_name, products.product_price, order_items.quantity FROM order_items INNER JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = :order_id";

            $statement = $conn->prepare($query);
            $statement->execute([':order_id' => $orderId]);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);

        } catch (Exception $e){
            error_log("Fout bij het ophalen van besteldetails: " . $e->getMessage());
            return false;
        }
    }
}