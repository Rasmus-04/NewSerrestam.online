<?php
include("functions.php");

# kollar om det finns en cookie och om det finns så loggas användaren in.
if(isset($_COOKIE["activeUser"])){
    setcookie("activeUser", $_COOKIE["activeUser"], time()+(3600*24));
    $_SESSION["activeUser"] = $_COOKIE["activeUser"];
    $datetime = date("Y-m-d H:i:s");
    updateDatabaseData("users", "lastLogedin = '$datetime'", "user = '{$_SESSION['activeUser']}'");
}

# Om man är inloggad så blir man sickat till banken
if(isset($_SESSION["activeUser"])){
    reload("bank.php");
}

if(isset($_GET["action"])){
    switch($_GET["action"]){
        case "killsession":
            clearSession();
            header("location: index.php");
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
  <title>Bank - login</title>

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
    <h1>Sveriges mest säkraste bank</h1>
  <div class="container">
    <section>
        <form action="bankmanager.php" method="post">
            <h2>Logga in</h2>
            <?php loginMsg();?>
            <input type="text" placeholder="Användarnamn" name="user" required>
            <br>
            <input type="password" placeholder="Lösenord" name="password" required>
            <br>
            <label class="form-checkbox">
                <input type="checkbox" name="keepLoggedIn"> Håll mig inloggad (Använder cookies!)</label>
            <input type="submit" name="action" value="login">
        </form>
    </section>

    <section>
    <form action="bankmanager.php" method="post">
          <h2>Registrera konto</h2>
          <?php regMsg();?>
          <input type="text" placeholder="Användarnamn" name="user" maxlength="9" minlength="3" oninvalid="this.setCustomValidity('Du måste ange ett användarnamn')" oninput="this.setCustomValidity('')" required>
          <input type="password" name="password" id="password" placeholder="Lösenord" minlength="3" oninvalid="this.setCustomValidity('Du måste ange ett lösenord med minst 3 bokstäver')" oninput="this.setCustomValidity('')" required>
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Upprepa lösenord" oninvalid="this.setCustomValidity('Du måste upprepa ditt lösenord')" oninput="this.setCustomValidity('')" required>
          <input type="submit" name="action" value="registrera">
    </form>
    </section>
  </div>



  <p>Döda sessionen om du har en från någon annan version eller annat projekt <a href="?action=killsession">Kill session</a></p>
</main>
<script src="main.js"></script>
</body>
</html>