<?php
include("functions.php");

$old_psw = sha1($_POST["oldpsw"]);
$new_psw = sha1($_POST["password"]);

foreach($_SESSION["users"] as $index => $u){
    if($_SESSION["active_user"] == $u["user"]){
        if($old_psw == $u["pasw"]){
            $_SESSION["users"][$index]["pasw"] =$new_psw;
            update_users();
            header("location: userpage.php?mess=sucsess");
        }else{
            header("location: userpage.php?mess=fail");
        }
    }
}
?>
