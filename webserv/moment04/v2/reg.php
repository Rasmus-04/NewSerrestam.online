<?php
    session_start();


    $user = strtolower(trim($_POST["user"]));
    $pasw = $_POST["password"];
    $run = true;

    $user_taken = false;

    if($user == "admin"){
        header("location: index.php?mess=usertaken");
        $run = false;
    }

    if($run){

    if(isset($_COOKIE["users"])){
        $_SESSION["users"] = $_COOKIE["users"];
        $_SESSION["pasw"][] = $$_COOKIE["pasw"];
    }


    if(isset($_SESSION["users"])){
        foreach($_SESSION["users"] as $u){
            if($user == $u){
                $user_taken = true;
                break;
            }
        }
        if($user_taken){
            header("location: index.php?mess=usertaken");
        }else{
            $_SESSION["users"][] = $user;
            $_SESSION["pasw"][] = $pasw;
            $_COOKIE["users"][] = $user;
            $_COOKIE["pasw"][] = $pasw;
            header("location: index.php?mess=userreg");
        } 

    }else{
        $_SESSION["users"] = array();
        $_SESSION["pasw"] = array();

        setcookie('users', array());
        setcookie('pasw', array());

        $_SESSION["users"][] = $user;
        $_SESSION["pasw"][] = $pasw;

        $_COOKIE["users"][] = $user;
        $_COOKIE["pasw"][] = $pasw;

        header("location: index.php?mess=userreg");
    }}
?>
