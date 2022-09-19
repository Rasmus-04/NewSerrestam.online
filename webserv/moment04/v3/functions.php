<?php 
session_start();

function checkAccess(){
    if(!isset($_SESSION["active_user"])){
        header("location: index.php?mess=acsses denied");
    }
}

function get_users(){
    $file_in = "users.json";
    $users = json_decode(file_get_contents($file_in), true);
    $_SESSION["users"] = $users["users"];
}

function delete_users(){
    $file_out = "users.json";

    $t = array("users" => array());
    if(isset($_COOKIE["activeuser"])){
        setcookie('activeuser', "", time()-3600);
    }
    
    
    $file = fopen($file_out, "w");
    fwrite($file, json_encode($t, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    fclose($file);
}

function update_users(){
    $t = array("users" => array());
    foreach($_SESSION["users"] as $u){
        $t["users"][] = $u;
    }
    $file_out = "users.json";
    $file = fopen($file_out, "w");

    fwrite($file, json_encode($t, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    fclose($file);
}

function login_error($mess){
    switch($mess){
        case "fail":
            echo "<p style='color:red;'>Fel användarnamn eller lösenord</p>";
            break;
        case "acsses denied":
            echo "<p style='color:red;'>Du har ingen återkomst</p>";
            break;
    }
  }
  
function reg_error($mess){
    switch($mess){
        case "usertaken":
            echo "<p style='color:red;'>Användarnamnet du har anget är redan taget</p>";
            break;

        case "regsuccses":
            echo "<p style='color:green;'>Du har skapat en nya användare</p>";
            break;
    }
}

function pswChangeMess($mess){
    switch($mess){
        case "sucsess":
            echo "<p style='color:green;'>Ditt lösenord har uppdaterats!</p>";
            break;

        case "fail":
            echo "<p style='color:red;'>Fel Lössenord!</p>";
            break;
    }
}

function removeUser($usr){
    foreach($_SESSION["users"] as $index => $user){
        if($user["user"] == $usr){
            unset($_SESSION["users"][$index]);
            unset($_SESSION["pasw"][$index]);
            update_users();
            break;
        }
    }
}
?>