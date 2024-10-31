<?php
    include_once(__DIR__ . "/classes/Client.php");

    if(!empty($_POST)){

        try{
            $client = new Client();
            $client->setUsername($_POST['username']);
            $client->setEmail($_POST['email']);
            $client->setPassword($_POST['password']);

            $client->save();
            $succes = "User saved!";

        }catch (Exception $e) {
            $error = "Error: " .$e->getMessage();
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

                <div class="theForm">
					<input type="submit" value="Get Started" class="btn">
				</div>

                <h3>Already have an account? <a href="login.php">Login here</a></h3>
            </form>
        </div>
    </div>
</body>
</html>