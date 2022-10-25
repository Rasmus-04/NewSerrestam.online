<?php
session_start();
require_once("databasConnection.php");
date_default_timezone_set("Europe/Stockholm");

function clearSession(){
    # Tömmer hela sessionen
    session_unset();
    session_destroy();
}

function reload($path, $mess=""){
    # Redirectar dig till $path och om $mess har angets så sickar det i en getvariabel med index mess
    if($mess != ""){
        $mess = "?mess=$mess";
    }
    header("location: $path$mess");
    exit();
}

function validateUsername($username){
    # Sätter användarnamnet till bara småbokstäver
    $username = mb_strtolower($username);
    # Kollar om användarnamnet har minst 3 bokstäver och som mest 9 bokstäver
    if(mb_strlen($username) < 3 || mb_strlen($username) > 9){
        reload("index.php", "lengthError#regMsg");
    # Kollar så att användarnamnet inte innehåller mellanslag
    }elseif(str_contains($username, " ")){
        reload("index.php", "illegalCharacter#regMsg");
    }elseif(!ctype_alnum($username)){
        reload("index.php", "illigleChar#regMsg");
    }else{
        # Returnerar användarnamnet
        return $username;
    }
}

function validatePassword($pasw, $path="index.php"){
    # Kollar om lösenordert är minst 3 bokstäver
    if(mb_strlen($pasw) < 3){
        reload($path, "paswLengthError#regMsg");
    }elseif(!ctype_alnum($pasw)){
        reload("index.php", "illigleChar#regMsg");
    }else{
        # Krypterar lösenordert och returnerar det
        return sha1($pasw);
    }
}

function getDatabaseData($what, $from, $where=""){
    global $pdo;
    if($where != ""){
        $where = "WHERE $where";
    }
    $sql = "SELECT $what FROM $from $where";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

function sendDatabaseData($into, $index, $values){
    global $pdo;
    $sql = "INSERT INTO $into ($index) VALUES ($values);";
    $stm = $pdo->prepare($sql);
    $stm->execute();
}

function removeDatabaseData($from, $where){
    global $pdo;
    $where = "WHERE $where";
    $sql = "DELETE FROM $from $where;";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

function updateDatabaseData($what, $set, $where){
    global $pdo;
    $sql = "UPDATE $what SET $set WHERE $where";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

function checkAccounNumber($accountNumber){
    global $pdo;
    $accountNumber = intval($accountNumber);
    # Kollar om konto nummret finns
    $accounts = getDatabaseData("accountNumber", "accounts");
    $accountNumberExist = false;
    foreach($accounts as $aN){
        if($accountNumber == $aN["accountNumber"]){
            $accountNumberExist = true;
        }
    }
    return $accountNumberExist;
}

function generateAccountNummber(){
    # genererar ett konto nummer
    while(true){
        $accountNumber = strval(rand(100000, 999999));
        # Kollar om konto nummret inte redan finns och då breakar ur loopen
        if(!checkAccounNumber($accountNumber)){
            break;
        }
    }
    # Returnar konto nummret
    return $accountNumber;
}

function getAccountNumber($accountName){
    $accounts = getDatabaseData("*", "accounts", "user = '{$_SESSION['activeUser']}'");
    foreach($accounts as $account){
      if($account["accountName"] == $accountName){
        return $account["accountNumber"];
      }
    }
}

function checkUserNameExist($username){
    $users = getDatabaseData("user", "users");
    foreach($users as $user){
        $user = $user["user"];
        if($user == $username){
            return "true";
        }
    }
    return false;
}

function createUser($username, $pasw){
    global $pdo;
    # Skapar användare först så validerar jag användere och lösenord sedan kollar jag om användare finns.
    # Validerar Användarnamn och lösenord
    $username = validateUsername($username);
    $pasw = validatePassword($pasw);

    $userTaken = checkUserNameExist($username);

    if($userTaken){
        reload("index.php", "userTaken#regMsg");
    }else{
        $accountNumber = intval(generateAccountNummber());
        $sql = "INSERT INTO users (user, pasw, locked) VALUES ('$username', '$pasw', 0);";
        $sql .= " INSERT INTO accounts (accountNumber, accountName, user) VALUES ($accountNumber, 'allkonto', '$username');";
        $sql .= " INSERT INTO transactions (amount, accountNumber) VALUES (1000, $accountNumber);";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        reload("index.php", "userCreated#regMsg");
    }
}

function regMsg(){
    # Regristations medelananden
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
            case "illigleChar":
                echo "<p style='color: red;'>Användarnamnet och lösenordert för inte inehålla specialla karaktärer</p>";
                break;
        }
    }
}

function loginMsg(){
    # Login medalanden
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
    # Bank medelanden
    if(isset($_GET["mess"])){
        switch($_GET["mess"]){
            case "ivalidAmount":
                echo "<h4 style='color: red; text-align: center;'>Ogiltlig summa</h4>";
                break;
            case "paswChanged":
                echo "<h4 style='color: green; text-align: center;'>Ditt lösenord har uppdaterats!</h4>";
                break;
            case "wrongPasw":
                echo "<h4 style='color: red; text-align: center;'>Du angav fel lösenord</h4>";
                break;
            case "emtyAccount":
                echo "<h4 style='color: red; text-align: center;'>Kontot måste vara tomt innan du tar bort det</h4>";
                break;
            case "accToAcc":
                echo "<h4 style='color: red; text-align: center;'>Kan inte överföra till samma konto</h4>";
                break;
            case "notEnoughMoney":
                echo "<h4 style='color: red; text-align: center;'>Inte tillräckligt mycket pengar på kontot</h4>";
                break;
            case "invalidAmmount":
                echo "<h4 style='color: red; text-align: center;'>Ogiltiligt summa</h4>";
                break;
            case "transferSucces":
                echo "<h4 style='color: green; text-align: center;'>Överförningen lyckades!</h4>";
                break;
            case "invalidAccountNumber":
                echo "<h4 style='color: red; text-align: center;'>Kontonummret existerar inte</h4>";
                break;
            case "invalidAccount":
                echo "<h4 style='color: red; text-align: center;'>Användaren har inget konto som heter det du angav</h4>";
                break;
        }
    }
}

function validateLogin($username, $pasw){
    # Sätter användarnamnet till småbokstäver och krypterar lösenordet
    $username = mb_strtolower($username);
    $pasw = sha1($pasw);

    $userExsist = checkUserNameExist($username);

    if($userExsist){
        $password = getDatabaseData("pasw", "users", "user = '$username'");
        if($pasw == $password[0]["pasw"]){
            if(getDatabaseData("locked", "users", "user = '$username'")[0]["locked"] == 1){
                reload("index.php", "accessDenied#logIn");
            }
            $_SESSION["activeUser"] = $username;
            $time = date("Y-m-d H:i:s");
            updateDatabaseData("users", "lastLogedin = '$time'", "user = '{$_SESSION['activeUser']}'");
            # Kollar om användaren vill varakvar inloggad och då sparas användarnamnet i din cookie
            if(isset($_POST["keepLoggedIn"])){
                setcookie("activeUser", $username, time()+(3600*24));
            }
            reload("bank.php");
        }
    }
    reload("index.php", "wrongUserOrPasw#logIn");
}

function validateAccess(){
    # Kollar om det finns en active user anars sickas man till login sidan
    if(isset($_SESSION["activeUser"]) && !checkUserNameExist($_SESSION["activeUser"])){
        unset($_SESSION["activeUser"]);
        reload("index.php", "accessDenied");
    }elseif(isset($_SESSION["activeUser"]) && getDatabaseData("locked", "users", "user = '{$_SESSION["activeUser"]}'")[0]["locked"] == 1){
        unset($_SESSION["activeUser"]);
        reload("index.php", "accessDenied");
    }
    elseif(isset($_SESSION["activeUser"])){
        return;
    }else{
        reload("index.php", "accessDenied#logIn");
    }
}

function logout(){
    # Loggar ut från ditt konto
    unset($_SESSION["activeUser"]);
    unset($_SESSION["activeAccount"]);
    unset($_SESSION["activeAccountNumber"]);
    if(isset($_COOKIE["activeUser"])){
      setcookie('activeUser', "", time()-3600);
    }
    reload("index.php");
}

function createUserFile(){
    # Skapar json filen med en tom users array
    $file_out = "users.json";
    $t = array("users" => array(), "accounts" => array());
    $file = fopen($file_out, "w");
    fwrite($file, json_encode($t, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    fclose($file);
}

function changePassword($oldPsw, $newPsw){
    # Validerar ditt nya lösenord och krypterar ditt gamla
    $newPsw = validatePassword($newPsw, "bank.php");
    $oldPsw = sha1($oldPsw);

    $psw = getDatabaseData("pasw", "users", "user = '{$_SESSION['activeUser']}'")[0]["pasw"];

    if($oldPsw == $psw){
        updateDatabaseData("users", "pasw = '$newPsw'", "user = '{$_SESSION['activeUser']}'");
        reload("bank.php", "paswChanged");
    }else{
        reload("bank.php", "wrongPasw");
    }
}

function checkAccountNameExist($accountName){
    $accountNames = getDatabaseData("accountName", "accounts", "user = '{$_SESSION['activeUser']}'");
    foreach($accountNames as $aN){
        if($aN["accountName"] == $accountName){
            return true;
        }
    }
    return false;
}

function validateAccountName($account){
    # Validerar konto namn
    $account = mb_strtolower($account);
    if(mb_strlen($account) < 3 || mb_strlen($account) > 9){
        return("lengthError");
    }elseif(str_contains($account, " ")){
        return("illegalCharacter");
    }elseif(checkAccountNameExist($account)){
        return("acountExist");
    }elseif(!ctype_alnum($account)){
        return("illigleChar");
    }else{
        return $account;
    }
}

function createAccount($account){
    # Skapar ett konto till användaren
    $account = validateAccountName($account);
    switch($account){
        case "lengthError":
            reload("bank.php", "$account#accountCreation");
            break;
        case "illegalCharacter":
            reload("bank.php", "$account#accountCreation");
            break;
        case "acountExist":
            reload("bank.php", "$account#accountCreation");
            break;
        case "illigleChar":
            reload("bank.php", "$account#accountCreation");
        default:
            #Skapar konto
            $accountNumber = generateAccountNummber();
            sendDatabaseData("accounts", "accountNumber, accountName, user", "$accountNumber, '$account', '{$_SESSION['activeUser']}'");
            reload("bank.php", "accountCreated#accountCreation");
            break;
    }
}

function accountCreationsError(){
    if(isset($_GET["mess"]))
    switch($_GET["mess"]){
        case "lengthError":
            echo "<p style='color: red;'>Konto namnet måste vara mellan 3 och 9 bokstäver</p>";
            break;
        case "illegalCharacter":
            echo "<p style='color: red;'>Konto namnet får inte inehålla mellanslag</p>";
            break;
        case "acountExist":
            echo "<p style='color: red;'>Konto namnet existerar redan</p>";
            break;
        case "accountCreated":
            echo "<p style='color: green;'>Kontot har skapats!</p>";
            break;
        case "illigleChar":
            echo "<p style='color: red;'>Konto namnet får inte inehålla speciala bokstäver</p>";
            break;
    }
}

function deposit($amount, $accountNumber, $redirect=true){

    if($amount < 0 || intval($amount) > 9223372036854775806){
        reload("bank.php", "ivalidAmount");
    }
    sendDatabaseData("transactions", "amount, accountNumber", "$amount, $accountNumber");

    if($redirect){
        reload("bank.php#saldo");
    }
}

function withdrawal($amount, $accountNumber, $redirect=true){
    # Tar ut pengar från kontot

    if($amount < 0 || $amount > 9223372036854775806){
        reload("bank.php", "ivalidAmount");
    }elseif($amount > getBalance($accountNumber)){
        reload("bank.php", "notEnoughMoney");
    }
    $amount = -$amount;
    sendDatabaseData("transactions", "amount, accountNumber", "$amount, $accountNumber");
    if($redirect){
        reload("bank.php#saldo");
    }
}

function deleteAccount(){
    # Tar bort användare
    $accounts =getDatabaseData("accountNumber", "accounts", "user = '{$_SESSION['activeUser']}'");

    foreach($accounts as $account){
        removeDatabaseData("transactions", "accountNumber = {$account['accountNumber']}");
    }

    removeDatabaseData("accounts", "user = '{$_SESSION['activeUser']}'");
    removeDatabaseData("users", "user = '{$_SESSION['activeUser']}'");

    unset($_SESSION["activeAccount"]);
    unset($_SESSION["activeAccountNumber"]);
    logout();
}

function removeAccount($account){
    # Tar bort ett konto från användaren
    $accountNumber = getAccountNumber($account);

    if($account == "allkonto"){
        reload("bank.php");
    }
    if(intval(getBalance(intval($accountNumber))) != 0){
        reload("bank.php", "emtyAccount");
    }

    removeDatabaseData("transactions", "accountNumber = $accountNumber");
    removeDatabaseData("accounts", "accountNumber = $accountNumber");

    reload("bank.php");
}

function getBalance($accountnumber){
    # returnar kontonts saldo
    $transactions = getDatabaseData("amount", "transactions", "accountNumber = $accountnumber");

    $balance = 0;
    foreach($transactions as $transaction){
        $balance += $transaction["amount"];
    }

    return $balance;
}

function getTransactionTable($accountNumber){
    # returnar tablen för alla transaktioner
    $output = "<table><thead><tr><th>Nr</th><th>Belopp</th><th>Datum</th><th>Saldo</th></tr></thead><tbody>";
    $balance = intval(getBalance($accountNumber));

    $transactions = array_reverse(getDatabaseData("amount, time", "transactions", "accountNumber = $accountNumber"));
    $i = sizeof($transactions);

    foreach($transactions as $transaction){
        $output .= "\n<tr><td>".$i--."</td><td>{$transaction["amount"]}</td><td>{$transaction["time"]}</td><td>$balance</td></tr>";
        $balance -= $transaction["amount"];
    }
    $output .= "</tbody></table>";
    return $output;
}

function transfer($fromAccount, $toAccount, $ammount){
    # Överför pengar från ett konto till ett annat inom samma användare
    $fromAccountNumber = getAccountNumber($fromAccount);
    $toAccountNumber = getAccountNumber($toAccount);

    if($fromAccount == $toAccount){
        reload("bank.php", "accToAcc");
    }elseif(getBalance($fromAccountNumber) < $ammount){
        reload("bank.php", "notEnoughMoney");
    }elseif($ammount < 0){
        reload("bank.php", "invalidAmmount");
    }else{
        
        withdrawal($ammount, $fromAccountNumber, false);
        deposit($ammount, $toAccountNumber, false);
        reload("bank.php", "transferSucces");
    }   
}

function transferBetweenUsers($fromAccount, $accountNumber, $ammount){
    # Överför pengar från ditt konto till någon annans användares konto
    $fromAccountNumber = getAccountNumber($fromAccount);

    if(getBalance($fromAccountNumber) < $ammount){
        reload("bank.php", "notEnoughMoney");
    }elseif($ammount < 0){
        reload("bank.php", "invalidAmmount");
    }elseif(!checkAccounNumber($accountNumber)){
        reload("bank.php", "invalidAccountNumber");
    }else{
        withdrawal($ammount, $fromAccountNumber, false);
        deposit($ammount, $accountNumber, false);
        
        reload("bank.php", "transferSucces");
    }
}
?>