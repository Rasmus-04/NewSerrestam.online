<?php
session_start();
if(isset($_SESSION["users"])){
    foreach($_SESSION["users"] as $index => $u){
        if($_SESSION["active_user"] == $u){
            unset($_SESSION["users"][$index]);
            unset($_SESSION["pasw"][$index]);
            unset($_SESSION["active_user"]);
            break;
        }
    }
}


header("location: index.php");
?>