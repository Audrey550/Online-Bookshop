<?php 
  //setcookie("login", "", time()-3600);
  session_start(); //Zo weet de server wie jij bent
  session_destroy();
  header('Location: login.php');  
?>