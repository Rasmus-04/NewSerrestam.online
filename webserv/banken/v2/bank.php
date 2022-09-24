<?php
include("functions.php");
validateAccess();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bank</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">

  <link rel="stylesheet" href="../../css/milligram.css">

    <link rel="stylesheet" href="main.css">

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Rasmus Serrestam - Banken</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="../../webserv.html">Gå tillbaka</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../v1/index.php">Version 01</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Version 02</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Version 03</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="source.php">CSource</a>
            </li>
          </ul>
        </div>
      </nav>

<main>
    <h1>Sveriges mest säkraste bank</h1>
    <h2>Du är inloggad som <?php echo ucfirst($_SESSION["activeUser"])?></h2>
    <?php bankMess() ?>
    <hr>
    <article class="container">
    <section>
        <h3><b>Saldo</b></h3>
        <p><?php echo getBalance()?> kr</p>
        <h3><b>Insättning/uttag</b></h3>

        <form action="bankmanager.php" method="POST">
        <label for="belopp">Belopp:</label>
        <input type="number" name="amount" min="1" required>

        <label for="deposit"><input type="radio" id="deposit" name="action" value="deposit" checked> Insättning</label>
        <label for="withdrawal"><input type="radio" id="withdrawal" name="action" value="withdrawal"> Uttag</label>
        
        <input type="submit" value="Utför">
        
        </form>
    </section>

    <section>
        <h3><b>Transaktioner</b></h3>
        <div id="trasactionList">
        <?php echo getTransactionTable()?>
        </div>
    </section>
    </article>
    
    <hr>

    <article class="container">
      <section>
        <form action="?" method="GET">
          <input type="submit" name="action" value="Logga ut">
          <input type="submit" name="action" value="Radera konto" onclick="return confirm('Är du säker att du vill ta bort ditt konto?')">
        </form>
      </section>

      <section>
        <form action="bankmanager.php" method="POST" id="test">
          <h4>Byt Lösenord</h4>
          <input type="Password" placeholder="Current Password" name="oldpsw" required>

          <input type="password" name="password" id="password" placeholder="New password" minlength="3" required />
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required />

          <input type="submit" name="action" value="Change Password">
        </form>
      </section>
    </article>

    <pre>
    <?php
    print_r(get_defined_vars());
    ?>
    </pre>
</main>
<script src="main.js"></script>
</body>
</html>