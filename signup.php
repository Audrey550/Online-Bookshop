<?php
    require_once __DIR__ . "/bootstrap.php";
    use App\OnlineBookshop\Db;
    use App\OnlineBookshop\Client;

    if(!empty($_POST)){
        try{
            $email = $_POST['email'];

            //Controleer of het emailadres al gebruikt word
            $conn = Db::getConnection();
            $statement = $conn->prepare("SELECT * FROM clients WHERE email = :email");
            $statement->bindValue(':email', $email);
            $statement->execute();
            $existingClient = $statement->fetch();

            if($existingClient){
                $error = "Dit emailadres is al in gebruik. Probeer een ander emailadres.";
            } else{
                
            //Maakt een nieuw Client object aan
            $client = new Client();
            $client->setUsername($_POST['username']);
            $client->setEmail($_POST['email']);
            $client->setPassword($_POST['password']);

            $usertype = isset($_POST['is_admin']) ? 1 : 0;
            $client->setUsertype($usertype);
            $client->save();//Slaagt de gebruiker op
            $succes = "User saved!";

            //Redirect naar de loginpagina nadat de login gelukt is
            header("Location: login.php");
            exit;
        }

        }catch (Exception $e) {
            $error = "Error: " .$e->getMessage();//Haal de foutmelding op 
        }
    }

    $clients = Client::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="css/signup.css?<?php echo time(); ?>"/>
</head>
<body>
    <?php if(isset($error)): ?>
    <div class="error" style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if(isset($succes)): ?>
    <div class="succes"><?php echo $succes; ?></div>
    <?php endif; ?>

<div class="bookShopSignup">
        <div class="formSignup">
            <form action="" method="post">
                <h2 class="formTitle">Welcome to BookShop! <br> Create an account here
                </h2>

                <div class="theForm">
					<label for="Name">Username</label>
					<input type="text" name="username" id="Username">
				</div>

                <div class="theForm">
					<label for="Email">Email</label>
					<input type="text" name="email" id="email">
				</div>
				<div class="theForm">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>

                <!--<div class="theForm"><label for="is_admin">Admin:</label>
                <input type="checkbox" name="is_admin" value="1"><br>
                </div>-->
               
                <div class="theForm">
					<input type="submit" value="Get Started" class="btn">
				</div>

                <h3>Already have an account? <a href="login.php">Login here</a></h3>
            </form>
        </div>
    </div>
</body>
</html>