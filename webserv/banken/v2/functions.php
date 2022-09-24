<?php
session_start();

function clearSession(){
    session_unset();
    session_destroy();
}

function reload($path, $mess=""){
    if($mess != ""){
        $mess = "?mess=$mess";
    }
    header("location: $path$mess");
    exit();
}

function update_users(){
    $t = array("users" => array());
    foreach($_SESSION["users"] as $index => $u){
        $t["users"][$index] = $u;
    }
    $file_out = "users.json";
    $file = fopen($file_out, "w");

    fwrite($file, json_encode($t, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    fclose($file);
}

function validateUsername($username){
    # Kollar om användarnamnet har minst 3 bokstäver och som mest 9 bokstäver
    $username = mb_strtolower($username);
    if(mb_strlen($username) < 3 || mb_strlen($username) > 9){
        reload("index.php", "lengthError");
    }elseif(str_contains($username, " ")){
        reload("index.php", "illegalCharacter");
    }else{
        return $username;
    }
}

function validatePassword($pasw, $path="index.php"){
    if(mb_strlen($pasw) < 3){
        reload($path, "paswLengthError");
    }else{
        return sha1($pasw);
    }
    
}

function createUser($username, $pasw){
    $username = validateUsername($username);
    $pasw = validatePassword($pasw);
    if(isset($_SESSION["users"][$username])){
        reload("index.php", "userTaken");
    }else{
        $_SESSION["users"][$username] = array("pasw" => $pasw, "accounts" => array("allkonto" => array(array("1000", date("Y-m-d H:i:s")))));
        update_users();
        reload("index.php", "userCreated");
    }
}

function regMsg(){
    if(isset($_GET["mess"])){
        switch($_GET["mess"]){
            case "userTaken":
                echo "<p style='color: red;'>Användarnament du angav används redan!</p>";
                break;
            case "userCreated":
                echo "<p style='color: green;'>Ditt konto har skapats!</p>";
                break;
            case "illegalCharacter":
                echo "<p style='color: red;'>Användarnamnet får inte inehålla mellanslag</p>";
                break;
            case "lengthError":
                echo "<p style='color: red;'>Användarnament Måste vara minst 3 bokstäver långt och som mest 9 bokstäver</p>";
                break;
            case "paswLengthError":
                echo "<p style='color: red;'>Lösenordet måste vara minst 3 bostäver långt</p>";
                break;
        }
    }
}

function loginMsg(){
    if(isset($_GET["mess"])){
        switch($_GET["mess"]){
            case "wrongUserOrPasw":
                echo "<p style='color: red;'>Fel användarnamn eller lösenord</p>";
                break;
            case "accessDenied":
                echo "<p style='color: red;'>Du har ingen åtkomst</p>";
                break;
        }
    }
}

function bankMess(){
    if(isset($_GET["mess"])){
        switch($_GET["mess"]){
            case "ivalidAmount":
                echo "<h4 style='color: red; text-align: center;'>Du kan inte sätta in ett negativt tal</h4>";
                break;
            case "paswChanged":
                echo "<h4 style='color: green; text-align: center;'>Ditt lösenord har uppdaterats!</h4>";
                break;
            case "wrongPasw":
                echo "<h4 style='color: red; text-align: center;'>Du angav fel lösenord</h4>";
                break;
}
    }
}

function validateLogin($username, $pasw){
    $username = mb_strtolower($username);
    $pasw = sha1($pasw);
    if(isset($_SESSION["users"][$username]) && $_SESSION["users"][$username]["pasw"] == $pasw){
        $_SESSION["activeUser"] = $username;
        if(isset($_POST["keepLoggedIn"])){
            setcookie("activeUser", $username, time()+(3600*24));
        }
        reload("bank.php");
    }else{
        reload("index.php", "wrongUserOrPasw");
    }
}

function validateAccess(){
    if(isset($_SESSION["activeUser"])){
        return;
    }else{
        reload("index.php", "accessDenied");
    }
}

function logout(){
    unset($_SESSION["activeUser"]);
      
    if(isset($_COOKIE["activeUser"])){
      setcookie('activeUser', "", time()-3600);
    }

    reload("index.php");
}

function createUserFile(){
    $file_out = "users.json";
    $t = array("users" => array());
    $file = fopen($file_out, "w");
    fwrite($file, json_encode($t, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    fclose($file);
}

function changePassword($oldPsw, $newPsw){
    $newPsw = validatePassword($newPsw, "bank.php");
    $oldPsw = sha1($oldPsw);
    if($oldPsw == $_SESSION["users"][$_SESSION["activeUser"]]["pasw"]){
        $_SESSION["users"][$_SESSION["activeUser"]]["pasw"] = $newPsw;
        reload("bank.php", "paswChanged");
    }else{
        reload("bank.php", "wrongPasw");
    }
}

function deposit($amount, $account="allkonto"){
    if($amount < 0){
        reload("bank.php", "ivalidAmount");
    }
    $_SESSION["users"][$_SESSION["activeUser"]]["accounts"][$account][] = array($amount, date("Y-m-d H:i:s"));
    update_users();
    reload("bank.php");
}

function withdrawal($amount, $account="allkonto"){
    if($amount < 0){
        reload("bank.php", "ivalidAmount");
    }
    $_SESSION["users"][$_SESSION["activeUser"]]["accounts"][$account][] = array(-$amount, date("Y-m-d H:i:s"));
    update_users();
    reload("bank.php");
}

function deleteAccount(){
    unset($_SESSION["users"][$_SESSION["activeUser"]]);
    update_users();
    logout();
}

function get_users(){
    $file_in = "users.json";
    if(!file_exists($file_in)){
        createUserFile();
    }
    $users = json_decode(file_get_contents($file_in), true);
    $_SESSION["users"] = $users["users"];
}

function getBalance($account="allkonto"){
    $balance = 0;
    foreach($_SESSION["users"][$_SESSION["activeUser"]]["accounts"][$account] as $transaction){
        $balance += intval($transaction[0]);
    }
    return $balance;
}

function getTransactionTable($account="allkonto"){
    $output = "<table><tr><th>Nr</th><th>Belopp</th><th>Datum</th><th>Saldo</th></tr>";
    $i = 1;
    $balance = 0;

    foreach($_SESSION["users"][$_SESSION["activeUser"]]["accounts"][$account] as $transaction){
        $balance += $transaction[0];
        $output .= "\n<tr><td>".$i++."</td><td>{$transaction[0]}</td><td>{$transaction[1]}</td><td>$balance</td></tr>";
    }
    $output .= "</table>";
    return $output;
}

?>