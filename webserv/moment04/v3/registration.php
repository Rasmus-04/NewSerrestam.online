<?php
include("functions.php");

$name = mb_strtolower(trim($_POST["user"]));
$pasw = $_POST["password"];

if($name == "admin"){
    header("location: index.php?mess=usertaken");
}else{
    $user_taken = false;
    foreach($_SESSION["users"] as $user){
        if($user["user"] == $name){
            $user_taken = true;
        }
    }

    if(!$user_taken){
        $_SESSION["users"][] = array("user" => $name, "pasw" => $pasw);
        update_users();
        header("location: index.php?mess=regsuccses");
    }else{
        header("location: index.php?mess=usertaken");
    }
}



?>