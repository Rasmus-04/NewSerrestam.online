<?php
session_start();

$name = mb_strtolower(trim($_POST["user"]));
$pasw = sha1($_POST["password"]);

$admin_pass = sha1("qwerty");

if($name == "admin" && $pasw == $admin_pass){
    $_SESSION["active_user"] = "admin";
    if(isset($_POST["keepLoggedIn"])){
        setcookie('activeuser', $name, time()+86400);
    }
    header("location: admin.php");
}else{
    $correct_login = false;
    foreach($_SESSION["users"] as $user){
        if($user["user"] == $name && $user["pasw"] == $pasw){
            $_SESSION["active_user"] = $name;
            $correct_login = true;
            if(isset($_POST["keepLoggedIn"])){
                setcookie('activeuser', $name, time()+86400);
            }
            break;
        }
    }

    if(!$correct_login){
        header("location: index.php?mess=fail");
    }else{
        header("location: userpage.php");
    }
}
?>