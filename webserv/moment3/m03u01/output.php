<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Title of the document</title>
   </head>
   <body>
      <!--<h1>Resultat</h1>
      <p>Följande har skickats från formuläret!</p>
      <pre>
        <?php
         // var_dump är en bra funktion som skriver
         // ut allt innehåll i en variabel, i detta
         // fallet en array var_dump($_POST);
         // print_r skriver ut samma sak, fast med
         // lite mindre information. Använd den du vill.
         print_r($_POST);
         ?>
        </pre>-->

        <?php
            
            echo "<h1>Regrestrering för ".$_POST['name']." ".$_POST['efternamn']." blev godkänd</h1>";
            echo "<p>Lösenordet är: ".$_POST["password"]." och är en ".$_POST["gender"]."</p>";
            echo "<p>".$_POST['name']." fyller år ". $_POST["birthday"]."</p>";
        ?>
      <a href="javascript:history.back()">Back</a>
   </body>
</html>