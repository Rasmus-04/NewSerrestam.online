<?php
// lagra filnamnet i en variabel
$filename = "test.txt";

// Nu gäller det att bestämma sig för vad du vill göra.
// 1. Läs in hela filen och skriv ut den direkt
// readfile tar som argument filnamnet
readfile($filename);
echo "<hr>";

// 2. Skriv ut den rad för rad
// Skapa ett filhandtag
// första argumentet är filnamnet
// andra argumentet är hur filen skall öppnas, "r" innebär bara läsning
$file = fopen($filename, "r");
// Loopa igenom filen, så länge det finns fler rader
// feof -  end of file in a file pointer
while(!feof($file)){
  // Skriv ut varje rad för sig.
  echo fgets($file)."<br />";
  // Om du vill jobba med
}
echo "<hr>";

// 3. Läs in varje rad till en array.
// Läser in filen igen eftersom den lästes till slutet i förra loopen
$file = fopen($filename, "r");
while(!feof($file)){
  $arr[] = fgets($file);
}

// Loopar igenom hela arrayen
foreach ($arr as $line) {
  // Skriv ut varje rad för sig.
  echo "$line<br />";
}
echo "<hr>";

// 4. Läser in filen till två arrayer, course och desc
$course = array(); $desc = array();
// Läser in filen igen eftersom den lästes till slutet i förra loopen
$file = fopen($filename, "r");
while(!feof($file)){
  $data = fgets($file);    // Läs rad till $data
  if(strlen($data)>0){    // Om $data har innehåll
    // Använd explode för att dela upp innehåll i olika arrayer
    list($course[], $desc[]) = explode("|", $data);
  }
}

// Skriv ut innehållet från våra två arrayer.
for($i=0; $i<count($course); $i++){
  echo "<p>Kurs: $course[$i]<br>Beskrivning: $desc[$i]</p>";
}
?>