<?php
include("functions.php");
# Kollar så att användaren är inloggad
validateAccess();
$accounts = getDatabaseData("*", "accounts", "user = '{$_SESSION['activeUser']}'");

# Kollar om ett konto är valt anars så defualtar den till allkonto
if(!isset($_SESSION["activeAccount"])){
  $_SESSION["activeAccount"] = "allkonto";
}

foreach($accounts as $account){
  if($account["accountName"] == $_SESSION["activeAccount"]){
    $_SESSION["activeAccountNumber"] = $account["accountNumber"];
    break;
  }
}

# Kollar om användaren vill byta aktivt konto
if(isset($_GET["updateActiveAccount"])){
  # Kollar så att kontot användaren vill byta till finns
  if(checkAccounNumber($_GET["updateActiveAccount"])){
    $_SESSION["activeAccountNumber"] = $_GET["updateActiveAccount"];
    foreach($accounts as $account){
      if($account["accountNumber"] == $_SESSION["activeAccountNumber"]){
        $_SESSION["activeAccount"] = $account["accountName"];
        break;
      }
    }
    
  }
  reload("bank.php");
}

# Kollar om användaren vill ta bort sitt konto eller logga ut
if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "Logga ut":
            logout();
            break;
        case "Radera konto":
          deleteAccount();
          break;
    }
}
$lastLogedIn = getDatabaseData("lastLogedIn", "users", "user = '{$_SESSION["activeUser"]}'")
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bank kopplad till databas</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">

  <link rel="stylesheet" href="../css/milligram.css">

    <link rel="stylesheet" href="main.css">

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Rasmus Serrestam - Banken-databas</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="../webserv.html">Gå tillbaka</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Version 01</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="source.php">CSource</a>
      </li>
    </ul>
  </div>
</nav>

<main>
    <h1>Sveriges säkraste bank</h1>
    <h2>Du är inloggad som <?php echo ucfirst($_SESSION["activeUser"])?></h2>
    <?php
      echo "<h3 style='text-align: center;'>Senast inloggad: {$lastLogedIn[0]['lastLogedIn']}</h3>"
    ?>
    <?php bankMess() ?>
    <hr>
    <article class="container">
      <section>
        <form action="?">
            <h3>Välj konto</h3>
            <select id="accountSelect" onchange="selectAccount()">
              <?php
              # Går igenom alla konton användaren har och lägger dom i en select
              foreach($accounts as $account){
                $accountName = ucfirst($account["accountName"]);
                if($account["accountNumber"] == $_SESSION["activeAccountNumber"]){
                  echo "<option value='{$account["accountNumber"]}' selected>$accountName | Kontonummer : {$account["accountNumber"]}</option>";
                }else{
                  echo "<option value='{$account["accountNumber"]}'>$accountName | Kontonummer : {$account["accountNumber"]}</option>";
                }
              }
              ?>
            </select>
        </form>
      </section>

      <section>
        <form action="bankmanager.php" method="POST">
          <h3>Skapa Nytt konto</h3>
          <?php accountCreationsError();?>
          <input type="text" name="kontonamn" placeholder="Konto namn" pattern="[^()/><\][\\\x22,;|]+" minlength="3" maxlength="9" required>
          <input type="submit" name="action" value="Skapa konto">
        </form>
      </section>

    <section>
        <h3><b>Saldo</b></h3>
        <p><?php echo getBalance($_SESSION["activeAccountNumber"])?> kr</p>
        <h3><b>Insättning/uttag</b></h3>

        <form action="bankmanager.php" method="POST">
        <label for="belopp">Belopp:</label>
        <input type="number" id="belopp" name="amount" min="1" max="9223372036854775800" pattern="\d*" required>

        <label for="deposit"><input type="radio" id="deposit" name="action" value="deposit" checked> Insättning</label>
        <label for="withdrawal"><input type="radio" id="withdrawal" name="action" value="withdrawal"> Uttag</label>
        
        <input type="submit" value="Utför">
        
        </form>
    </section>

    <section>
        <h3><b>Transaktioner</b></h3>
        <div id="trasactionList">
        <?php echo getTransactionTable($_SESSION["activeAccountNumber"])?>
        </div>
    </section>

      <section>
        <form action="bankmanager.php" method="POST">
            <h3>Ta bort konto</h3>
            <select name="konto" id="delAcount" onchange="check_selected()">
              <option value="">Välj ett konto...</option>
              <?php
              # Går igenom alla konton användaren har och lägger dom i en select
              foreach($accounts as $account){
                $accountName = ucfirst($account["accountName"]);
                if($account["accountName"] == "allkonto"){
                  continue;
                }
                echo "<option value='{$account["accountName"]}'>$accountName</option>";
              }
              ?>
            </select>
            <input type="submit" name="action" value="Ta bort konto" id="button_select" onclick="return confirm('Är du säker att du vill ta bort detta konto?')" disabled>
        </form>
      </section>

      <section>
        <form action="bankmanager.php" method="POST" id="test">
          <h3>Byt Lösenord</h3>
          <input type="Password" placeholder="Current Password" name="oldpsw" required>

          <input type="password" name="password" id="password" placeholder="New password" minlength="3" required>
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>

          <input type="submit" name="action" value="Change Password">
        </form>
      </section>

      <section>
        <form action="bankmanager.php" method="POST">
          <h3>Överför mellan konton</h3>

          <label for="fromAccount">Från konto</label>
          <select name="fromKonto" id="fromAccount" required onchange="checkSelectedMulti()">
              <option value="">Välj ett konto...</option>
              <?php
              # Går igenom alla konton användaren har och lägger dom i en select
              foreach($accounts as $account){
                $accountName = ucfirst($account["accountName"]);
                $balance = getBalance($account["accountNumber"]);
                echo "<option value='{$account["accountName"]}'>$accountName: $balance kr</option>";
              }
              ?>
            </select>
            <label for="toKonto">Till konto</label>
            <select name="toKonto" id="toKonto" required onchange="checkSelectedMulti()">
              <option value="">Välj ett konto...</option>
              <?php
              # Går igenom alla konton användaren har och lägger dom i en select
              foreach($accounts as $account){
                $accountName = ucfirst($account["accountName"]);
                $balance = getBalance($account["accountNumber"]);
                echo "<option value='{$account["accountName"]}'>$accountName: $balance kr</option>";
              }
              ?>
            </select>
            <label for="summa1">Summa</label>
            <input type="number" name="amount" id="summa1" placeholder="Summa" min="1" pattern="\d*" onchange="checkSelectedMulti()" max="9223372036854775806" required>
            <input type="hidden" name="action" value="transfer">
          <input type="submit" value="Överför" id="transfer" disabled>
        </form>
      </section>

      <section>
        <form action="bankmanager.php" method="POST">
          <h3>Överför mellan användare</h3>
          <label for="fromKonto">Från konto</label>
          <select name="fromKonto" id="fromKonto" required>
              <option value="">Välj ett konto...</option>
              <?php
              # Går igenom alla konton användaren har och lägger dom i en select
              foreach($accounts as $account){
                $accountName = ucfirst($account["accountName"]);
                $balance = getBalance($account["accountNumber"]);
                echo "<option value='{$account["accountName"]}'>$accountName: $balance kr</option>";
              }
              ?>
            </select>

            <label for="accountNumber">Användarens Kontonummer</label>
            <input type="number" id="accountNumber" name="accountNumber" pattern="\d*" placeholder="Kontonummer" required>

            <label for="summa">Summa</label>
            <input type="number" name="amount" id="summa" placeholder="Summa" min="1" max="9223372036854775806" pattern="\d*" required>

            <input type="hidden" name="action" value="transferBetweenUsers">
            <input type="submit" value="Överför">
        </form>
      </section>

    <section>
        <form action="?" method="GET">
          <input type="submit" name="action" value="Logga ut">
          <input type="submit" name="action" value="Radera konto" onclick="return confirm('Är du säker att du vill ta bort ditt konto?')">
        </form>
      </section>
    </article>
</main>
<script src="main.js"></script>
</body>
</html>