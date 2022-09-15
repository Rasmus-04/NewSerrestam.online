<?php
include("functions.php");
session_unset();
session_destroy();
delete_users();

if(isset($_COOKIE["activeuser"])){
    setcookie('activeuser', "", time()-3600);
}

header("location: index.php");
?>