<?php
function uppgift1(){
    echo "<h1>Uppgift 1</h1>";
    echo "<p>Jag heter Rasmus Serrestam</p>";
    echo "<p>Jag går teknik programet</p>";
}

function uppgift2(){
    echo "<h1>Uppgift 2/3</h1>";
    $namn = "Rasmus";
    $kurs = "Webbserverprogrammering 1";

    echo "<p>".$namn." läser kursen ".$kurs."</p>";

    $radie = 4;
    $pi = 3.14;

    echo "<p>Om radien är $radie så är omkretsen ".($radie + $radie) * $pi." och arean ".$radie*$radie*$pi.".</p>";
}

function uppgift4(){
    echo "<h1>Uppgift 4</h1>";
    echo "<p>- Jag tycker det är \"kul\" med PHP!</p>";
    echo "\n";
    echo "<p>- Nej, jag skojade bara!</p>";
}

function uppgift5(){
    $kurs = "Webbserverprogrammering 1";
    echo "<h1>Uppgift 5</h1>";
    echo strlen($kurs);
    echo "</br>";
    echo strtolower($kurs);
    echo "</br>";
    echo strtoupper($kurs);
    echo "</br>";
    
    echo strrev(ucfirst(strtolower($kurs)));
}

function uppgift6(){
    echo "<h1>Uppgift 6</h1>";
    $namn = array("Rasmus", "Kalle", "Pelle");
    $mail = array("Rasmus@gmail.com", "Kalle@gmail.com", "Pelle@gmail.com");

    echo "<pre>";
    var_export($namn);      // var_export ger annan formattering
    echo "</pre>";

    echo "<pre>";
    var_export($mail);      // var_export ger annan formattering
    echo "</pre>";

    echo "$namn[0] har mailadressen $mail[0]";
    echo "</br>";
    echo "$namn[1] har mailadressen $mail[1]";
    echo "</br>";
    echo "$namn[2] har mailadressen $mail[2]";
    echo "</br>";
}

function uppgift7(){
    echo "<h1>Uppgift 7</h1>";
    $timme = date("H");
    echo "<p>Timslaget är $timme</p>";
    if($timme > 16){
        echo "<p>skoldagen är slut</p>";
    }
}

function uppgift8(){
    echo "<h1>Uppgift 8</h1>";
    $timme = date("H");
    echo "<p>Timslaget är $timme</p>";
    if($timme <= 16 and $timme >= 8){
        echo "<p>skoldagen pågår</p>";
    }else{
        echo "<p>skoldagen är slut</p>";
    }
}

function uppgift9(){
    echo "<h1>Uppgift 9</h1>";
    $timme = date("H");
    echo "<p>Timslaget är $timme</p>";
    if($timme < 8){
        echo "<p>skoldagen inte har börjat</p>";
    }else if($timme > 16){
        echo "<p>skoldagen är slut</p>";
    }else{
        echo "<p>skoldagen pågår</p>";
    }
}

function uppgift10(){
    echo "<h1>Uppgift 10</h1>";
    $timme = date("H");
    echo "<p>Timslaget är $timme</p>";
    
    switch($timme){
        case 0:
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
        case 7:
            echo "<p>skoldagen inte har börjat</p>";
            break;
        case 8:
        case 9:
        case 10:
        case 11:
        case 12:
        case 13:
        case 14:
        case 15:
        case 16:
            echo "<p>skoldagen pågår</p>";
            break;
        default:
            echo "<p>skoldagen är slut</p>";
    }
}

function uppgift11(){
    echo "<h1>Uppgift 11</h1>";
    $timme = date("H");
    echo "<p>Timslaget är $timme</p>";
    if($timme <= 16 and $timme >= 8){
        echo "<p>skoldagen pågår</p>";
    }else{
        echo "<p>skoldagen är slut</p>";
    }
}

function uppgift12(){
    echo "<h1>Uppgift 12</h1>";
    $konto = 10000;
    $ränta = 1.03;

    for($i=0; $i<15; $i++){
        $konto *= $ränta;
    }
    echo "<p>Kontot är på $konto</p>";
}

function uppgift13(){
    echo "<h1>Uppgift 13</h1>";
    $råttor = 100;
    $månad = 1;

    while($råttor <= 1000000){
        $råttor *= 2;
        $månad++;
    }
    echo "<p>Efter $månad månader så finns det $råttor st råttor</p>";
}

function uppgift14(){
    echo "<h1>Uppgift 14</h1>";

    for($i=1; $i<21; $i++){
        if ($i == 15){
            break;
        }else if($i % 3 == 0){
            continue;
        }
    echo "<p>$i</p>";
    }
}

function uppgift15(){
    echo "<h1>Uppgift 15</h1>";
    echo "<p>Jag heter Rasmus Serrestam och jag går i 20Teb</p>";
}

function uppgift16($radie, $x=true){
    if ($x){
        echo "<h1>Uppgift 16</h1>";
    }

    $omkrets = number_format(M_PI * $radie * 2, 2, '.', ' ');
    $area = number_format($radie * $radie * M_PI, 2, '.', ' ');
    echo "<p>om radien är $radie så är omkretsen $omkrets och arian $area</p>";
}


function uppgift_table(){
    echo "<h1>Uppgift Tabell</h1>";
    echo "<table>";
    echo "<tbody>";
    $color = "white";
    for($i=1; $i<21; $i++){
        if($i % 3 == 0 and $i % 5 == 0){
            $color = "orange";
        }else if($i % 3 == 0){
            $color = "yellow";
        }else if($i % 5 == 0){
            $color = "red";
        }else{
            $color = "white";
        }
        echo "<tr style=\"background-color: $color\">";
        echo "<td>$i</td>";
        echo "<td>".str_repeat("*",$i)."</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</tbody>";
}

?>