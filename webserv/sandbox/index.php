<?php 
$usernameInput = mb_strtolower(trim($_POST['username']));
$passwordInput = sha1($_POST['password']);

$file = fopen("username.txt", "r");

while(!feof($file)){
  $usernames[] = fgets($file);
}

fclose($file);
echo "<pre>";
print_r(get_defined_vars());
echo "</pre>";
foreach ($usernames as $line) {
  // Skriv ut varje rad för sig.
  echo "$line<br />";
}
echo "<hr>";

$exist = false;

foreach ($usernames as $row) {
    $row = str_replace("\n", "", $row);
        if ($row == $usernameInput) {
            echo "tst";
            $exist = true;
    }
}

if (!$exist) {
    $file = fopen("username.txt", "a");

    fwrite($file, ($usernameInput . PHP_EOL));

    fclose($file);

    $file = fopen("password.txt", "a");

    fwrite($file, ($passwordInput . PHP_EOL));

    fclose($file);
    //header("Location: index.php?m=reg");

} else {
//header("Location: register.php?m=exist");
}
?>