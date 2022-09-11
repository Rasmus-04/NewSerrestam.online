<?php
session_start();
$_SESSION["TEST"] = array("hej", "vab", "daw");

setcookie("hello", json_encode($_SESSION["TEST"]));


$data = json_decode($_COOKIE['hello'], true);


foreach($data as $d){
    echo "<p>".$d."</p>";
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



<pre>
<?php
  print_r(get_defined_vars());
 ?>
</pre>
</body>
</html>