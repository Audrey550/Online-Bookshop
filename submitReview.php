<?php 
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;
    use App\OnlineBookshop\Product;
    use App\OnlineBookshop\Order;
    use App\OnlineBookshop\Review;

    header('Content-Type: application/json'); // Zorg dat JSON expliciet is
    error_reporting(E_ALL); // Zet foutmeldingen aan
    ini_set('display_errors', 1); // Zorg dat foutmeldingen worden getoond

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!isset($_SESSION['id'])){
            echo json_encode([
                'status' => 'error',
                'message' => 'Je moet ingelogd zijn om een review te kunnen plaatsen'
            ]);
            exit;
        }

        $clientId = $_SESSION['id'];
        $productId = $_POST['product_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $comment = $_POST['comment'] ?? null;

        if(!$productId || !$rating || !$comment){
            echo json_encode([
                'status' => 'error',
                'message' => 'Niet alle verplichte velden zijn ingevuld'
            ]);
            exit;
        }

        //Probeer een review toe te voegen
        $result = Review::addReview($clientId, $productId, $rating, $comment);

        //Controleert of de review-functie een geldig resultaat retourneert
        if($result === false){
            echo json_encode([
                'status' => 'error',
                'message' => 'Er is iets fout gegaan bij het toevoegen van je review'
            ]);
            exit;
        }

        //Succesvolle JSON output
        echo json_encode([
            'status' => 'success',
            'review' => [
            'rating' => $rating,
            'comment' => htmlspecialchars($comment)
            ]
        ]);
        exit;
    }

