<?php
    session_start();

    $user = strtolower(trim($_POST["user"]));
    $pasw = $_POST["password"];

    function validate_login(){
        if(isset($_POST["action"])){
            if(isset($_SESSION["users"])){
                $user_exsist = false;
                $user = strtolower(trim($_POST["user"]));
                $pasw = $_POST["password"];

                foreach($_SESSION["users"] as $index => $u){
                    if($user == $u and $pasw == $_SESSION["pasw"][$index]){
                        $_SESSION["active_user"] = $user;
                        $user_exsist = true;
                        break;
                    }
                }
                if(!$user_exsist){
                    header("location: index.php?mess=fail");
                }else{
                    if(isset($_POST["keepLoggedIn"])){
                        setcookie('active_user', $user);
                    }

                    header("location: userpage.php");
                }
            }else{
                header("location: index.php?mess=fail");
            }
        }else{
            header("location: index.php?mess=noinfo");
        }
    }

    if(isset($_POST["action"])){
        if($user == "admin" and $pasw == "qwerty"){
            if(isset($_POST["keepLoggedIn"])){
                setcookie('admin', "true");
            }

            $_SESSION["admin"] = "true";
            header('location: admin.php');
        }else{
            validate_login();
        }
    }else{
        header("location: index.php?mess=noinfo");
    }
?>