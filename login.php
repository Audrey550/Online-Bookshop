<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css?<?php echo time(); ?>"/>
</head>
<body>
    <div class="bookShopLogin">
        <div class="formLogin">
            <form action="" method="post">
                <h2 class="formTitle">
                    Welcome to Bookshop! <br> Sign into your account
                </h2>

                <?php if(isset($error) ): ?>
                <div class="form-Error">
                    <p>
                        Incorrect email and password. Please try again. 
                    </p>
                </div>
                <?php endif; ?>

                <div class="theForm">
					<label for="Email">Email</label>
					<input type="text" name="email">
				</div>
				<div class="theForm">
					<label for="Password">Password</label>
					<input type="password" name="password">
				</div>

                <div class="theForm">
					<input type="submit" value="Log In" class="btn">
				</div>

                <h3>Don't have an account? <a href="signup.php">Sign up here</a></h3>
            </form>
        </div>
    </div>
</body>
</html>