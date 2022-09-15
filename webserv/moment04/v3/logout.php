<?php
session_start();
if(isset($_SESSION["active_user"])){
    unset($_SESSION["active_user"]);
  }

if(isset($_COOKIE["activeuser"])){
  setcookie('activeuser', "", time()-360000);
}


header("location: index.php");

?>