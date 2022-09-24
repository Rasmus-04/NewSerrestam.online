<?php
$file = "transactions.txt"; 
$transactions = array();
$transactionsOutput = "";
$balance = 0;

if(!file_exists($file)){
  $f = fopen($file, "a");
  fwrite($f, "1000\n");
  fclose($f);
}

$f = fopen($file, "r");
while(!feof($f)){
  $temp = intval(fgets($f));
  if(!empty($temp)){
    $transactions[] = $temp; 
  }
}

foreach($transactions as $t){
  $balance += $t;
  $transactionsOutput .= "<p>$t kr</p>";
}

if(isset($_POST["action"])){
  switch($_POST["action"]){
    case "deposit":
      $f = fopen($file, "a");
      fwrite($f, "{$_POST['amount']}\n");
      fclose($f);
      echo "test";
      header("location: index.php");
      exit();
      break;
    
    case "withdrawal":
      if($_POST['amount'] > $balance){
        header("location: index.php?mess=Utaget kan inte vara större än ditt saldo");
        exit();
      }else{
        $f = fopen($file, "a");
        fwrite($f, "-{$_POST['amount']}\n");
        fclose($f);
        header("location: index.php");
        exit();
      }
      break;
    
    case "deleteAccount":
      unlink($file);
      header("location: index.php?mess=Det gammla konto har raderats och ett nytt har skapats!");
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
            <li class="nav-item active">
              <a class="nav-link" href="#">Version 01</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../v2/index.php">Version 02</a>
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
  <?php
    if(isset($_GET["mess"])){
      echo "<p style='color: red; text-align: center;'>{$_GET['mess']}</p>";
    }
    ?>
  <article class="container">
    <section>
        <h3><b>Saldo</b></h3>
        <p><?php echo $balance;?> kr</p>
        <h3><b>Insättning/uttag</b></h3>

        <form action="?" method="POST">
        <label for="belopp">Belopp:</label>
        <input type="number" name="amount" min="1" required>

        <label for="deposit"><input type="radio" id="deposit" name="action" value="deposit" checked> Insättning</label>
        <label for="withdrawal"><input type="radio" id="withdrawal" name="action" value="withdrawal"> Uttag</label>
        
        <input type="submit" value="Utför">
        
        </form>
    </section>

    <section>
        <h3><b>Transaktioner</b></h3>
        <div id="test">
        <?php echo $transactionsOutput; ?>
        </div>

        <form action="?" method="POST">
          <input type="hidden" name="action" value="deleteAccount">
          <input type="submit" value="Radera konto">
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