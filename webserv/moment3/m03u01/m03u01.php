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


  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Rasmus Serrestam - Moment 3</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link" href="../../webserv.html">Gå tillbaka</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">m03u01</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../m03u02/m03u02.php">m03u02</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../m03u03/m03u03.php">m03u03</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="source.php">CSource</a>
            </li>
          </ul>
        </div>
      </nav>

<main>
  <form action="output.php" method="post">
  
  <div class="container">
    <p class="item"><label for="Förnamn">Förnamn</label>
    <input id="Förnamn" type="text" name="name" required placeholder="Ange ditt Förnamn"></p>

    <p class="item"><label for="efternamn">Efternamn</label>
    <input id="efternamn" type="text" name="efternamn" required placeholder="Ange ditt efternamn"></p>
  </div>

  <div class="container">
    <p class="item"><label for="password">Lösenord</label>
    <input id="password" type="password" name="password" required></p>

    <p class="item"><label for="birthday">Födelsedag</label>
    <input id="birthday" type="date" name="birthday" required></p>
  </div>

  <fieldset class="container">
    <legend>Kön</legend>
    <p class="item"><label for="man"><input id="man" name="gender" value="man" type="radio" checked>Man</label></p>
    
    <p class="item"><label for="kvinna"><input id="kvinna" name="gender" value="kvinna" type="radio">Kvinna</label></p>
  </fieldset>

  <p><label><input type="checkbox" name="villkor" required>     Jag godkänner användarvillkoren</label></p>

  <p><input type="submit" name="submit" value="Registrera">
  <input type="reset" name="reset" value="reset"></p>
  </form>
  </main>
</body>
</html>