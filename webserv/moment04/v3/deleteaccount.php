<?php
include("functions.php");

$name = $_SESSION["active_user"];

if(isset($_SESSION["users"])){
    foreach($_SESSION["users"] as $index => $user){
        if($user["user"] == $name){
            unset($_SESSION["users"][$index]);
            unset($_SESSION["pasw"][$index]);
            unset($_SESSION["active_user"]);
            update_users();
            if(isset($_COOKIE["activeuser"])){
                setcookie('activeuser', "", time()-3600);
            }
            
            break;
        }
    }
}
header("location: index.php");
?>