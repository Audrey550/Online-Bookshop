<nav>
    <a href="index.php">Home</a>
    <a href="#">About</a>
    <a href="browse.php">Browse</a>
    <a href="#">Contact</a>

    <form action="" method="get">
        <input type="text" name="search" placeholder="Search...">
    </form>

    <div class="nav__logout">
            <!--Controleert of de gebruiker is ingelogd-->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <!--Logout knop--> 

            <a href="logout.php" class="logout">Hi <?php echo htmlspecialchars($_SESSION['username']); ?>, logout?</a>

            <!--Profiellink afhangend van wat soort gebruiker het is-->
            <a href="<?php echo ($_SESSION['usertype'] == 1)? 'admin.php' : 'clientProfile.php'; ?>"><img src="img/profileIcon.png"></a>
            <?php else: ?>

            <!--Als de gebruiker niet is ingelogd, toon alleen de profiel icon zonder link-->
            <a href="login.php"><img src="img/profileIcon.png"></a>
        <?php endif; ?>

        <!--Als de gebruiker een admin, word het winkelwagen icoon niet getoont-->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['usertype'] === 0): ?> 
            <a href="#"> <img  class="hidden" src="img/shoppingIcon.png"></a>
        <?php endif; ?>
    </div>
</nav>

