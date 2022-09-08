<?php
    session_start();
    if(isset($_POST["action"])){
        if($_POST["user"] == "admin" and $_POST["password"] == "qwerty"){
            $_SESSION["admin"] = "true";
            header('location: admin.php');
        }else{
            header("location: index.php?mess=fail");
        }
    }else{
        header("location: index.php?mess=noinfo");
    }
?>