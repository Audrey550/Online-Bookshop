<?php 
     include_once(__DIR__ . "/classes/Db.php");
     include_once(__DIR__ . "/classes/Client.php");

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

    <div class="user-details">
        <h1>Welkom, <?php echo htmlspecialchars($client->getUsername());?></h1>
        <p><strong>Email:</strong><?php echo htmlspecialchars($client->getEmail()); ?></p>
    </div>

</body>
</html>

<!--FIX DEZE PAGINA: 
    - Gebruiker logt in en geraakt op de index.php, maar als deze op het profielicoontje klikt word die 1) geherleid naar de login pagina OF 2) als ik een vardump doe, verschijnen de gevraagde gegevens bovenaan MAAR met de echo "Er is een probleem met het ophalen van je gegevens. Probeer opnieuw in te loggen aub" ernaast -->