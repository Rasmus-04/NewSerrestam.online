<?php
session_start();

if(!isset($_SESSION["active_user"])){
    header("location: index.php?mess=acsses denied");
}

?>