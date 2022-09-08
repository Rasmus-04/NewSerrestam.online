<?php
    session_start();
    session_unset();
    session_destroy();

    if(isset($_COOKIE["admin"])){
        setcookie('admin', "", time()-3600);
      }
    
    if(isset($_COOKIE["active_user"])){
    setcookie('active_user', "", time()-3600);
    }

    if(isset($_COOKIE["users"])){
        setcookie('users', "", time()-3600);
        setcookie('pasw', "", time()-3600);
      }

    header("location: index.php");
?>