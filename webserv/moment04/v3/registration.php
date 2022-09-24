<?php
include("functions.php");

$name = mb_strtolower(trim($_POST["user"]));
$pasw = sha1($_POST["password"]);

if($name == "admin"){
    header("location: index.php?mess=usertaken");
}elseif(str_contains($name, " ")){
    header("location: index.php?mess=nospaces");
}elseif(mb_strlen($name) < 3 || mb_strlen($name) > 9){
    header("location: index.php?mess=lengtherror");
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