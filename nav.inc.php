<nav>
    <a href="index.php">Home</a>
    <a href="#">About</a>
    <a href="#">Browse</a>
    <a href="#">Contact</a>

    <form action="" method="get">
        <input type="text" name="search" placeholder="Search...">
    </form>

    <!--INfo specifiek voor admins-->
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <?php if($_SESSION['usertype'] == 1): ?>
            <a href="admin.php">Admin Page</a>
        <?php endif ?>
    <?php endif ?>

    <!--Info specifiek voor gebruikers-->
    <div class="nav__logout">
        <a href="logout.php" class="logout">Hi <?php echo htmlspecialchars($_SESSION['username']); ?>, logout?</a><!--username veranderen--> 
        <a href="#"><img src="img/profileIcon.png"></a>
    </div>

    <div class="nav__shoppingCart">
        <a href="#"> <img src="img/shoppingIcon.png"></a>
    </div>
</nav>

