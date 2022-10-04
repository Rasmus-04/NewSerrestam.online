<?php
session_start();

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

function update_users($lista){
    # Updaterar json filen med den nya listan som sickas in som en parameter
    $file_out = "users.json";
    $file = fopen($file_out, "w");
    fwrite($file, json_encode($lista, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    fclose($file);
}

function validateUsername($username){
    # Sätter användarnamnet till bara småbokstäver
    $username = mb_strtolower($username);
    # Kollar om användarnamnet har minst 3 bokstäver och som mest 9 bokstäver
    if(mb_strlen($username) < 3 || mb_strlen($username) > 9){
        reload("index.php", "lengthError");
    # Kollar så att användarnamnet inte innehåller mellanslag
    }elseif(str_contains($username, " ")){
        reload("index.php", "illegalCharacter");
    }else{
        # Returnerar användarnamnet
        return $username;
    }
}

function validatePassword($pasw, $path="index.php"){
    # Kollar om lösenordert är minst 3 bokstäver
    if(mb_strlen($pasw) < 3){
        reload($path, "paswLengthError");
    }else{
        # Krypterar lösenordert och returnerar det
        return sha1($pasw);
    }
}

function getJsonList(){
    # hätar datan från json filen och returnar den som en lista
    $file_in = "users.json";
    return json_decode(file_get_contents($file_in), true);
}

function checkAccounNumber($accountNumber){
    # Kollar om konto nummret finns
    $list = getJsonList();
    return isset($list["accounts"][$accountNumber]);
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

function createUser($username, $pasw){
    # Skapar användare först så validerar jag användere och lösenord sedan kollar jag om användare finns.
    # Validerar Användarnamn och lösenord
    $username = validateUsername($username);
    $pasw = validatePassword($pasw);
    $lista = getJsonList();
    # Kollar om användarnamnet redan finns
    if(isset($lista["users"][$username])){
        reload("index.php", "userTaken");
    }else{
        # Om användarnamnet inte finns så genereras ett konto nummer till ditt allkonto
        $accountNumber = strval(generateAccountNummber());
        # användaren och allkontot läggs till i users listan
        $lista["users"][$username] = array("pasw" => $pasw, "accounts" => array("allkonto" => $accountNumber));
        # Kontot läggs till i accounts listan
        $lista["accounts"][$accountNumber] = array(array("1000", date("Y-m-d H:i:s")));
        # Jsong filen updateras
        update_users($lista);
        reload("index.php", "userCreated");
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
                echo "<h4 style='color: red; text-align: center;'>Du kan inte sätta in ett negativt tal</h4>";
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
    $lista = getJsonList();
    # Kollar om användarnmnet finns och om lösenorden matchar
    if(isset($lista["users"][$username]) && $lista["users"][$username]["pasw"] == $pasw){
        $_SESSION["activeUser"] = $username;
        # Kollar om användaren vill varakvar inloggad och då sparas användarnamnet i din cookie
        if(isset($_POST["keepLoggedIn"])){
            setcookie("activeUser", $username, time()+(3600*24));
        }
        reload("bank.php");
    }else{
        reload("index.php", "wrongUserOrPasw");
    }
}

function validateAccess(){
    # Kollar om det finns en active user anars sickas man till login sidan
    if(isset($_SESSION["activeUser"])){
        return;
    }else{
        reload("index.php", "accessDenied");
    }
}

function logout(){
    # Loggar ut från ditt konto
    unset($_SESSION["activeUser"]);
    unset($_SESSION["activeAccount"]);
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
    $lista = getJsonList();
    # Kolla så lösenordet du gav matchar det gammla och om det gör så updateras ditt lösenord
    if($oldPsw == $lista["users"][$_SESSION["activeUser"]]["pasw"]){
        $lista["users"][$_SESSION["activeUser"]]["pasw"] = $newPsw;
        update_users($lista);
        reload("bank.php", "paswChanged");
    }else{
        reload("bank.php", "wrongPasw");
    }
}

function validateAccountName($account){
    # Validerar konto namn
    $account = mb_strtolower($account);
    $lista = getJsonList();
    if(mb_strlen($account) < 3 || mb_strlen($account) > 9){
        return("lengthError");
    }elseif(str_contains($account, " ")){
        return("illegalCharacter");
    }elseif(isset($lista["users"][$_SESSION["activeUser"]]["accounts"][$account])){
        return("acountExist");
    }else{
        return $account;
    }
}

function createAccount($account){
    # Skapar ett konto till användaren
    $account = validateAccountName($account);
    $lista = getJsonList();
    switch($account){
        case "lengthError":
            reload("bank.php", $account);
            break;
        case "illegalCharacter":
            reload("bank.php", $account);
            break;
        case "acountExist":
            reload("bank.php", $account);
            break;
        default:
            #Skapar konto
            $accountNumber = generateAccountNummber();
            $lista["users"][$_SESSION["activeUser"]]["accounts"][$account] = $accountNumber;
            $lista["accounts"][$accountNumber] = array();
            update_users($lista);
            reload("bank.php", "accountCreated");
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
    }
}

function deposit($amount, $account="allkonto", $redirect=true, $accountNumber=""){
    # Lägger in pengar på ditt konto
    $lista = getJsonList();
    if($accountNumber == ""){
        $user = $_SESSION["activeUser"];
        $accountNumber = $lista["users"][$user]["accounts"][$account];
    }

    if($amount < 0){
        reload("bank.php", "ivalidAmount");
    }
    
    $lista["accounts"][$accountNumber][] = array($amount, date("Y-m-d H:i:s"));
    update_users($lista);
    if($redirect){
        reload("bank.php");
    }
}

function withdrawal($amount, $account="allkonto", $redirect=true){
    # Tar ut pengar från kontot
    $lista = getJsonList();
    if($amount < 0){
        reload("bank.php", "ivalidAmount");
    }elseif($amount > getBalance($account)){
        reload("bank.php", "notEnoughMoney");
    }
    $accountNumber = $lista["users"][$_SESSION["activeUser"]]["accounts"][$account];
    $lista["accounts"][$accountNumber][] = array(strval(-$amount), date("Y-m-d H:i:s"));
    update_users($lista);
    if($redirect){
        reload("bank.php");
    }
    
}

function deleteAccount(){
    # Tar bort användare
    $lista = getJsonList();
    foreach($lista["users"][$_SESSION["activeUser"]]["accounts"] as $acc){
        unset($lista["accounts"][$acc]);
    }
    unset($lista["users"][$_SESSION["activeUser"]]);
    unset($_SESSION["activeAccount"]);
    update_users($lista);
    logout();
}

function removeAccount($account){
    # Tar bort ett konto från användaren
    $lista = getJsonList();
    if($account == "allkonto"){
        reload("bank.php");
    }
    if(intval(getBalance($account)) != 0){
        reload("bank.php", "emtyAccount");
    }

    $accountNumber = $lista["users"][$_SESSION["activeUser"]]["accounts"][$account];
    unset($lista["accounts"][$accountNumber]);
    unset($lista["users"][$_SESSION["activeUser"]]["accounts"][$account]);    
    if($_SESSION["activeAccount"] == $account){
        unset($_SESSION["activeAccount"]);
    }
    update_users($lista);
    reload("bank.php");
}

function getBalance($account="allkonto"){
    # returnar kontonts saldo
    $lista = getJsonList();

    $balance = 0;
    $accountNumber = $lista["users"][$_SESSION["activeUser"]]["accounts"][$account];
    foreach($lista["accounts"][$accountNumber] as $transaction){
        $balance += intval($transaction[0]);
    }
    return $balance;
}

function getTransactionTable($account="allkonto"){
    # returnar tablen för alla transaktioner
    $output = "<table><tr><th>Nr</th><th>Belopp</th><th>Datum</th><th>Saldo</th></tr>";
    $i = 1;
    $balance = 0;

    $lista = getJsonList();
    $accountNumber = $lista["users"][$_SESSION["activeUser"]]["accounts"][$account];

    foreach($lista["accounts"][$accountNumber] as $transaction){
        $balance += $transaction[0];
        $output .= "\n<tr><td>".$i++."</td><td>{$transaction[0]}</td><td>{$transaction[1]}</td><td>$balance</td></tr>";
    }
    $output .= "</table>";
    return $output;
}

function transfer($fromAccount, $toAccount, $ammount){
    # Överför pengar från ett konto till ett annat inom samma användare
    if($fromAccount == $toAccount){
        reload("bank.php", "accToAcc");
    }elseif(getBalance($fromAccount) < $ammount){
        reload("bank.php", "notEnoughMoney");
    }elseif($ammount < 0){
        reload("bank.php", "invalidAmmount");
    }else{
        withdrawal($ammount, $fromAccount, false);
        deposit($ammount, $toAccount, false);
        reload("bank.php", "transferSucces");
    }   
}

function transferBetweenUsers($fromAccount, $accountNumber, $ammount){
    # Överför pengar från ditt konto till någon annans användares konto
    $lista = getJsonList();

    if(getBalance($fromAccount) < $ammount){
        reload("bank.php", "notEnoughMoney");
    }elseif($ammount < 0){
        reload("bank.php", "invalidAmmount");
    }elseif(!isset($lista["accounts"][$accountNumber])){
        reload("bank.php", "invalidAccountNumber");
    }else{
        withdrawal($ammount, $fromAccount, false);
        deposit($ammount, $fromAccount, false, $accountNumber);
        
        reload("bank.php", "transferSucces");
    }
}
?>