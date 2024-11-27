<?php 
    require_once __DIR__ . "bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;

    session_start();
   //var_dump($_SESSION);
    //exit;

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
        header("Location: login.php");
        exit;
    }
    //var_dump($_SESSION['email']);

    $client = Client::getByEmail($_SESSION['email']);
    //var_dump($client);
    //exit;

    //$conn = Db::getConnection();
    /*$statement = $conn->prepare("SELECT username, email FROM clients WHERE id = :id");
    $statement->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
    $statement->execute();
    $client = $statement->fetch(PDO::FETCH_ASSOC);*/

    if(!$client){
        echo "Er is een probleem met het ophalen van je gegevens. Probeer opnieuw in te loggen aub.";
        exit;
    }

    //Werwerken van wachtwoord wijzigen
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])){
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if(password_verify($currentPassword, $client->getPassword())){
            if($newPassword === $confirmPassword){
                $client->setPassword(password_hash($newPassword, PASSWORD_DEFAULT));
                if($client->save()){
                    echo "Wachtwoord is gewijzigd";
                }else{
                    echo "Er is iets fout gegaan";
                }
            }else{
                echo "Nieuwe wachtwoord en bevestiging komen niet overeen";
            }
        }else{
            echo "Huidige wachtwoord is niet correct";
        }
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile page</title>
    <link rel="stylesheet" type="text/css" href="css/client.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php include_once("nav.inc.php"); ?>

    <div class="client-details">
        <h1>Welkom <?php echo htmlspecialchars($client->getUsername());?></h1>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($client->getEmail()); ?></p>
        <p><strong>Credits:</strong> <?php echo htmlspecialchars($client->getCredits()); ?></p>
    </div>

    <!--Formulier voor wachtwoord wijzigen-->
    <div class="password-change-form">
        <h2>Wachtwoord wijzigen</h2>
        <form action="" method="POST">
            <label for="current_password">Huidig wachtwoord:</label>
            <input type="password" name="current_password" id="current_password" required><br><br>

            <label for="new_password">Nieuw wachtwoord:</label>
            <input type="password" name="new_password" id="new_password" required><br><br>

            <label for="confirm_password">Bevestig wachtwoord:</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br><br>

            <button type="submit" name="change_password" class="submit-Btn">Verander je wachtwoord</button>
        </form>
    </div>

</body>
</html>