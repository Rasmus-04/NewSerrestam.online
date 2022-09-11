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
            
            header("location: index.php?mess=userreg");
        } 

    }else{
        $_SESSION["users"] = array();
        $_SESSION["pasw"] = array();

        $_SESSION["users"][] = $user;
        $_SESSION["pasw"][] = $pasw;

        header("location: index.php?mess=userreg");
    }}
?>
