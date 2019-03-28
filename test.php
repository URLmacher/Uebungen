<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
    table{
        width:100%;
        border-collapse: collapse;
    }
    tr{
       
        width:100%;
    }
    tr:nth-child(even){
        background-color: #f2f2f2;
    }
    td{
        border:1px solid black;
        padding: 15px;
    }
    </style>
    <title>Übung 4</title>
</head>
<body> 
     


<?php
// Beginn der HTML-Tabelle (`<table>`) auszugeben
// echo('<table>');

// CSV-Sonderzeichen sollen nicht ignoriert werden, diese Information als Datentyp boolean in einer Variable speichern
// $ignoreSpecialCharacters = ...

// Datei zum Lesen öffnen


// Solange Zeichen für Zeichen aus der Datei einlesen, solange das Dateiende noch nicht erreicht ist
//  Eine neue HTML-Zeile beginnen (`<tr>`)
//  Eine neue HTML-Spalte beginnen (`<td>`)
//  Ein Zeichen aus der Datei einlesen
//  Das Zeichen auswerten

//    Wenn CSV-Sonderzeichen ignoriert werden sollen:
//      Wenn das Zeichen ein Anführungszeichen `'""'` ist, den Wert der Variable, in der die Information, ob CSV-Sonderzeichen ignoriert werden sollen, gespeichert ist so ändern, dass CSV-Sonderzeichen nicht mehr ignoriert werden; eine Spalte ist komplett, die eingelesenen Zeichen können als HTML-Spalte ausgegeben werden (`<td>Zeichen</td>`)
//      Wenn das Zeichen irgendein anderes Zeichen ist, das Zeichen merken und zu den anderen bereits gemerkten Zeichen hinzufügen

//    Wenn CSV-Sonderzeichen nicht ignoriert werden sollen:
//      Wenn das Zeichen ein Anführungszeichen `'""'` ist, den Wert der Variable, in der die Information, ob CSV-Sonderzeichen ignoriert werden sollen, gespeichert ist so ändern, das CSV-Sonderzeichen ignoriert werden
//      Wenn das Zeichen ein Komma-Zeichen `','` ist, alle bisher gemerkten Zeichen als HTML-Spalte ausgeben (`<td>Zeichen</td>`)
//      Wenn das Zeichen ein Zeilenumbruch ist `"\n"`, die aktuelle HTML-Zeile abschließen (`</tr>`), eine neue HTML-Zeile beginnen (`<tr>`)

// Ende der HTML-Spalte (`</td>`) ausgeben
// Ende der HTML-Zeile (`</tr>`) ausgeben
// Ende der HTML-Tabelle (`</table>`) ausgeben


    $ignoreSpecialCharacters = [];
    $data =  file_get_contents("SampleCSVFile_119kb.csv");
    // zur Überprüfung von "" in Zellen 
    $cell ='';
    $ignoreBeistrich = false;
    echo "<table><tr><td>";
            
            for($i = 0; $i < strlen($data); $i++) {
                $cur = $data[$i];
                $cell .= $cur;  
                //Wenn ein Buchstabe in der ASCII-Tabelle höher als 140 ist, wird er gespeichert
                //& wenn er nicht schon gespeichert wurde 
                if ( (ord($cur) > 140) && (!in_array($cur,$ignoreSpecialCharacters)) ){
                    $ignoreSpecialCharacters[] = $cur;
                }
                // Double Quotes werden entfernt, außer hinter Zahlen
                if ($cur === '"' && !is_numeric($data[$i-1])){
                    echo "";
                }
                //eine neue Zelle ensteht durch das ersetzen vo beistrichen mit td
                // außer wenn die Beistriche durch 2x" escaped wurden
                elseif ($cur == ","  && $ignoreBeistrich == false) {
                    echo "</td>";
                    echo str_replace(",",'',$cur);
                    echo "<td>";
                }else{
                    echo str_replace($ignoreSpecialCharacters,"",$cur);
                }
                // neue Reihe bei new line
                if($cur == "\n") {
                    echo '</tr>';
                    // außer bei der letzten Reihe
                    if(!empty($data[$i+1])){
                       echo "<td>"; 
                    }
                }
                // wenn in einer Zelle zwei "" sind, wird der Beistrich ignoriert
                else if(preg_match_all('/(["])/',$cell) == 1) {
                    $ignoreBeistrich = true;
                }else if(preg_match_all('/(["])/',$cell) == 2) {
                    echo '';
                    $cell = '';
                    $ignoreBeistrich = false;
                }
                    
            }

         echo "</td></tr></table>";
    ?>
</body>
</html>