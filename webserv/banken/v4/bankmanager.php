<?php
include("functions.php");

if(isset($_POST["action"])){
switch($_POST["action"]){
    case "registrera":
        createUser($_POST["user"], $_POST["password"]);
        break;
    case "login":
        validateLogin($_POST["user"], $_POST["password"]);
        break;
    case "deposit":
        deposit($_POST["amount"], $_SESSION["activeAccount"]);
        break;
    case "withdrawal":
        withdrawal($_POST["amount"], $_SESSION["activeAccount"]);
        break;
    case "Change Password":
        changePassword($_POST["oldpsw"], $_POST["password"]);
        break;
    case "Skapa konto":
        createAccount($_POST["kontonamn"]);
        break;
    case "Ta bort konto":
        removeAccount($_POST["konto"]);
        break;
    case "transfer":
        transfer($_POST["fromKonto"], $_POST["toKonto"], $_POST["amount"]);
        break;
    case "transferBetweenUsers":
        transferBetweenUsers($_POST["fromKonto"], $_POST["accountNumber"], $_POST["amount"]);
        break;
}
}
?>
