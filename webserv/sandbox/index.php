<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
</head>
<body>
<main>
	<h1>Kan ej skicka tomt val i Selectionbox</h1>
	<article>
		<section>
			<h2>Formuläret</h2>
			<form action="" method="POST">
				<select name="select" id="delUser" onchange="check_selected()">
               <option value="">Välj ett alternativ...</option>
               <option value="1">Alternativ 1</option>
               <option value="two">two</option>
               <option value="annan text">annan text</option>
               <option value="">-----</option>
               <option value="sista">Ett sista alternativ</option>
            </select>
				<button type="submit" name="button" id="button_select" value="skicka" disabled>skicka</button>
			</form>
		</section>
		<section>
			<h2>Info</h2>
			<p>Knappen är <q>disabled</q> när formuläret skapas. När <q>value</q> i valt alternativ har en längd som är
				längre än 0 tkn så kommer knappen att göras <q>enabled</q>. Varje gång ett nytt val görs så kommer
				JavaScriptet köras och knappen görs enabled/disabled.</p>
			<p>Det första alternativet i select-boxen och <q>-----</q> går inte att välja.</p>
		</section>
	</article>
</main>
<script src="../moment04/v3/main.js"></script>
</body>

</html>