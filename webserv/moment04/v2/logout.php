<?php
    session_start();
   if(isset($_SESSION["admin"])){
    unset($_SESSION["admin"]);
    header("location: index.php");
  }

  if(isset($_SESSION["active_user"])){
    unset($_SESSION["active_user"]);
    header("location: index.php");
  }

  if(isset($_COOKIE["admin"])){
    setcookie('admin', "", time()-3600);
  }

  if(isset($_COOKIE["active_user"])){
    setcookie('active_user', "", time()-3600);
  }
?>