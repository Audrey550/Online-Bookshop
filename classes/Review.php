<?php 
   namespace App\OnlineBookshop;
   use App\OnlineBookshop\Db;

   class Review{
        public static function addReview($clientId, $productId, $rating, $comment){
            try{
                $conn = Db::getConnection();
                $query = "INSERT INTO reviews (client_id, product_id, rating, comment) VALUES (:client_id, :product_id, :rating, :comment)";

                $statement = $conn->prepare($query);
                $statement->execute([':client_id' => $clientId, ':product_id' => $productId, ':rating' => $rating, ':comment' => $comment]);
                return true;
            } catch (\PDOException $e){
                return false;
            }
        }

        public static function getReviewsByProductId($productId){
            try{
                $conn = Db::getConnection();
                $query = "SELECT * FROM reviews WHERE product_id = :product_id";

                $statement = $conn->prepare($query);
                $statement->execute([':product_id' => $productId]);
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e){
                return [];
        }
    }

    public static function getReviewsByClientId($clientId){
        try{
            $conn = Db::getConnection();
            $query = "SELECT * FROM reviews WHERE client_id = :client_id";
            $statement = $conn->prepare($query);
            $statement->execute([':client_id' => $clientId]);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e){
            return [];
        }
    }
}