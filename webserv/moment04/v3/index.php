<?php
include("functions.php");

if(isset($_COOKIE["activeuser"])){
  $_SESSION["active_user"] = $_COOKIE["activeuser"];
}


if(!isset($_SESSION["users"])){
  get_users();
}

if(isset($_SESSION["active_user"])){
  switch($_SESSION["active_user"]){
    case "admin":
      header("location: admin.php");
      break;
    default:
      header("location: userpage.php");
  }
}

if(isset($_GET["action"])){
  switch($_GET["action"]){
    case "clearsession":
      session_unset();
      session_destroy();
      delete_users();
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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">

  <link rel="stylesheet" href="../../css/milligram.css">


  <style>
    main{
      width: 80%;
      margin: 0 auto;
      margin-top: 4rem;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      flex-direction: row;
      justify-content: space-between;
      align-items: auto;
      align-content: start;
      padding: 0;
      margin-left: 0;
    }

    .item {
      flex: 0 0 auto;
    }

    form{
      width: 40%;
    }
  </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Rasmus Serrestam - Moment 04 - inloggningsapplikationen</a>
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
            <li class="nav-item">
              <a class="nav-link" href="../v2/index.php">Version 02</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Version 03</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="source.php">CSource</a>
            </li>
          </ul>
        </div>
      </nav>

<main>
  <div class="container">
    <form action="login.php" method="post" id="login">
        <div class="item">
          <h2>Logga in</h2>
          <?php
            if(isset($_GET["mess"])){
              login_error($_GET["mess"]);
            }
          ?>
          <input type="text" placeholder="Användarnamn" name="user" required />
          <br>
          <input type="password" placeholder="Lösenord" name="password" required />
          <br>
          <label class="form-checkbox">
              <input type="checkbox" name="keepLoggedIn"> Håll mig inloggad (Använder cookies!)</label>
          <input type="submit" name="action" value="login">
        </div>
    </form>

    <form action="registration.php" method="post">
        <div class="item">
          <h2>Registrera</h2>
          <?php
            if(isset($_GET["mess"])){
              reg_error($_GET["mess"]);
            }
          ?>
          <input type="text" placeholder="Användarnamn" name="user" required />
          <input type="password" name="password" id="password" placeholder="Password" required />
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required />
          <input type="submit" name="action" value="login">
        </div>
    </form>
  </div>
</main>
<script src="main.js"></script>
</body>
</html>