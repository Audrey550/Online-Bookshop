<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="css/signup.css?<?php echo time(); ?>"/>
</head>
<body>
<div class="bookShopSignup">
        <div class="formSignup">
            <form action="" method="post">
                <h2 class="formTitle">Welcome to BookShop! <br> Create an account here
                </h2>

                <?php if(isset($error) ): ?>
                <div class="form-Error">
                    <p>
                        Incorrect email and password. Please try again. 
                    </p>
                </div>
                <?php endif; ?>

                <div class="theForm">
					<label for="Name">Username</label>
					<input type="text" name="name">
				</div>

                <div class="theForm">
					<label for="Email">Email</label>
					<input type="text" name="email">
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