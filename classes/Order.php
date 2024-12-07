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
            $query = "SELECT products.id AS product_id, products.product_name, products.product_price, order_items.quantity FROM order_items INNER JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = :order_id";

            $statement = $conn->prepare($query);
            $statement->execute([':order_id' => $orderId]);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);

        } catch (Exception $e){
            error_log("Fout bij het ophalen van besteldetails: " . $e->getMessage());
            return false;
        }
    }

    public static function createOrder($clientId, $cart){
        try{
            $conn = Db::getConnection();

            //Start een transactie
            $conn->beginTransaction();

            $orderStatement = $conn->prepare("INSERT INTO orders (client_id, order_date) VALUES (:client_id, NOW())");
            $orderStatement->execute([':client_id' => $clientId]);

            //Haal het ID van de toegevoegde bestelling op
            $orderId = $conn->lastInsertId();

            //Voeg producten toe aan de orders_items tabel
            foreach($cart as $productId => $quantity){
                $priceStatement = $conn->prepare("SELECT product_price FROM products WHERE id = :product_id");
                $priceStatement->execute([':product_id' => $productId]);
                $product = $priceStatement->fetch(\PDO::FETCH_ASSOC);

                if (!$product) {
                    error_log("Geen product gevonden voor ID: $productId");
                    throw new Exception("Product met ID $productId bestaat niet.");
                }

                if($product){
                    $productPrice = $product['product_price'];

                    //Voeg het product toe aan de order_items tabel
                    $orderItemStatement = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                    $orderItemStatement->execute([
                        ':order_id' => $orderId, 
                        ':product_id' => $productId, 
                        ':quantity' => $quantity, 
                        ':price' => $productPrice
                    ]);
                }
            }

            //Bevestig de transactie
            $conn->commit();
            return $orderId;
        } catch (Exception $e){
            //Maak de transactie ongedaan
            $conn->rollBack();
            error_log("Fout bij het aanmaken van de bestelling: " . $e->getMessage());
            return false;
        }
    }

    public static function getReviewsByProductId($productId){
        try{
            $conn = Db::getConnection();
            $query = "SELECT r.rating, r.comment, r.created_at FROM reviews r INNER JOIN products p ON r.product_id = p.id WHERE p.id = :product_id";

            $statement = $conn->prepare($query);
            $statement->execute([':product_id' => $productId]);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $e){
            error_log("Fout bij het ophalen van reviews: " . $e->getMessage());
            return false;
        }
    }
}