<?php
include("functions.php");


switch($_POST["action"]){
    case "registrera":
        createUser($_POST["user"], $_POST["password"]);
        break;
    case "login":
        validateLogin($_POST["user"], $_POST["password"]);
        break;
    case "deposit":
        deposit($_POST["amount"]);
        break;
    case "withdrawal":
        withdrawal($_POST["amount"]);
        break;
    case "Change Password":
        changePassword($_POST["oldpsw"], $_POST["password"]);
        break;
}
?>



<pre>
    <?php
    print_r(get_defined_vars());
    ?>
</pre>