<?php
    include("check_login.php")
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


    <span class="pln">
  </span><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic"><span class="pln">

  </span><link rel="stylesheet" href="../../css/milligram.css"><span class="pln">
  </span>
  
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
      width: 47%;
    }

    #login input{
        width: 20%;
        min-width: 300px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Rasmus Serrestam - Moment 04</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="../../webserv.html">Gå tillbaka</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">inloggningsapplikationen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="source.php">CSource</a>
            </li>
          </ul>
        </div>
      </nav>

<main>
    <h2>Du är inloggad som Admin</h2>
    <a href="logout.php">Logga ut</a>
    <br>
    <a href="clearsession.php">Logga ut och ta bort alla användare</a>

    <pre>
    <?php
    print_r(get_defined_vars());
    #print_r($_SESSION);
    ?>
</pre>
</main>
</body>
</html>