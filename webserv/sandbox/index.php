<?php
session_start();


if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "reg":
            $_SESSION["user"] = "RASMUS";
            break;
        case "reset":
            session_unset();
            session_destroy();
            header("location: ?");
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <a href="?action=reg">Register</a>
    <a href="?action=reset">Reset</a>
    <a href="very_important_page_where_you_have_to_be_logged_in.php">Login</a>
    <?php
    if(isset($_GET["mess"])){
        echo "<h1>".$_GET["mess"]."</h1>";
    }
    ?>

    <pre>
  <?php
  print_r(get_defined_vars());
 ?>
</pre>
</body>
</html>