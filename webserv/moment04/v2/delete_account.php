<?php
session_start();
if(isset($_SESSION["users"])){
    foreach($_SESSION["users"] as $index => $u){
        if($_SESSION["active_user"] == $u){
            unset($_SESSION["users"][$index]);
            unset($_SESSION["pasw"][$index]);
            unset($_SESSION["active_user"]);
            
              if(isset($_COOKIE["active_user"])){
                setcookie('active_user', "", time()-3600);
              }

              if(isset($_COOKIE["users"])){
                setcookie('users', "", time()-3600);
                setcookie('pasw', "", time()-3600);
              }


              if(isset($_COOKIE["users"])){
                foreach($_COOKIE["users"] as $cookie) { 
                    if($cookie == $u){
                        setcookie($cookie, '', time()-3600);
                    }
                }

                foreach($_COOKIE["pasw"] as $cookie) { 
                    if($cookie == $u){
                        setcookie($cookie, '', time()-3600);
                    }
                }
              }
            break;
        }
    }
}


header("location: index.php");
?>