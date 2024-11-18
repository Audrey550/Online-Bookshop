<nav>
    <a href="index.php">Home</a>
    <a href="#">About</a>
    <a href="#">Browse</a>
    <a href="#">Contact</a>

    <form action="" method="get">
        <input type="text" name="search" placeholder="Search...">
    </form>

    <div class="nav__logout">
            <!--INfo specifiek voor admins-->
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
            <?php if($_SESSION['usertype'] == 1): ?>
                <a href="admin.php">Admin pagina</a>
            <?php endif ?>
                <!--Info specifiek voor gebruikers-->
                <a href="logout.php" class="logout">Hi <?php echo htmlspecialchars($_SESSION['username']); ?>, logout?</a><!--username veranderen--> 
            <?php endif ?>
                <a href="#"><img src="img/profileIcon.png"></a>
                <a href="#"> <img src="img/shoppingIcon.png"></a>
    </div>
    <!--<a href="#"> <img src="img/shoppingIcon.png"></a>-->    
</nav>

