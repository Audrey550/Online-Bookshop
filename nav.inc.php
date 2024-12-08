<nav>
    <a href="index.php">Home</a>
    <a href="browse.php">Browse</a>

    <form action="search.php" method="get">
        <input type="text" name="search" placeholder="Zoek op titel of auteur..." value="<?php echo htmlspecialchars($_GET['search']?? ''); ?>">
    </form>

    <div class="nav__logout">
            <!--Controleert of de gebruiker is ingelogd-->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>

            <!--Logout knop--> 
            <a href="logout.php" class="logout">Hallo <?php echo htmlspecialchars($_SESSION['username']); ?>, logout?</a>

            <!--Profiellink afhangend van wat soort gebruiker het is-->
            <a href="<?php echo ($_SESSION['usertype'] == 1)? 'admin.php' : 'clientProfile.php'; ?>"><img src="img/profileIcon.png"></a>
            <?php else: ?>

            <!--Als de gebruiker niet is ingelogd, toon alleen de profiel icon zonder link-->
            <a href="login.php"><img src="img/profileIcon.png"></a>
        <?php endif; ?>

        <!--Winkelmand icoon voor de klanten-->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['usertype'] === 0): ?> 
            <?php //Totaal aantal producten in het winkelmandje berekenen
            $cart_count = isset($_SESSION['cart'])? array_sum($_SESSION['cart']) : 0; ?>
            <a href="cart.php" class="navCartLink">
                <img src="img/shoppingIcon.png">
                <?php if($cart_count > 0): ?>
                    <span class="cart-count"><?php echo $cart_count
                    ?></span>
                <?php endif; ?>
            </a>
        <?php endif; ?>

     <!--Als de gebruiker een admin, word het winkelwagen icoon niet getoont-->
    <?php if(isset($_SESSION['loggedin']) && $_SESSION['usertype'] === 1): ?>
        <a href="#" class="hidden"><img src="img/shoppingIcon.png" alt=""></a>
    <?php endif; ?>
    </div>
</nav>

