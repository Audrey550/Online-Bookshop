<?php 
  require_once __DIR__ . "/bootstrap.php";
  use App\OnlineBookshop\Db;
  use App\OnlineBookshop\Client;

  //setcookie("login", "", time()-3600);
  session_start(); //Zo weet de server wie jij bent
  session_destroy();
  header('Location: login.php');  
?>