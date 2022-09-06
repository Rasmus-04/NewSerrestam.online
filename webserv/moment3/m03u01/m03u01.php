<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <span class="pln">
  </span><link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic"><span class="pln">
  </span><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css"><span class="pln">
  </span><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css"><span class="pln">
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