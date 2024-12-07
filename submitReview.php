<?php 
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;
    use App\OnlineBookshop\Product;
    use App\OnlineBookshop\Order;
    use App\OnlineBookshop\Review;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        if(!isset($_SESSION['id'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'Je moet ingelogd zijn om een review te kunnen plaatsen'
            ]);
            exit;
        }

        $clientId = $_SESSION['id'];
        $productId = $_POST['product_id'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        // Debug: Log de ontvangen gegevens
        error_log("Ontvangen gegevens - Client ID: " . $clientId . ", Product ID: " . $productId . ", Rating: " . $rating . ", Comment: " . $comment);

        $result = Review::addReview($clientId, $productId, $rating, $comment);
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }

