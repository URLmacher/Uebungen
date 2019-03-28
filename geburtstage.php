<?php
    include_once('Geburtstag.php');
    /**
     * Erstellt und schreibt JSON-Datei
     * @param string $file
     * @param object $data
     */
    function writeJson($file,$data){ 
        if(file_exists($file)) {
            $tempString = file_get_contents($file);
            $handle = fopen($file, 'w+');
            $tempArr = json_decode($tempString);
            $tempArr[] = $data;
            $readyData = json_encode($tempArr);
            fwrite($handle,$readyData);
            fclose($handle);
        }else{
            $handle = fopen($file, 'w+');
            $tempArr = [];
            $tempArr[] = $data;
            fwrite($handle,json_encode($tempArr));
            fclose($handle);
        }
    }   

    /**
     * Sucht nach Geburtstagen innerhalb von 30 Tagen
     * @param string $file
     */
    function getBirthday($file) {
        if(file_exists($file)) {
            $tempString = file_get_contents($file);
            $tempArr = json_decode($tempString);

            foreach($tempArr as $obj){
                $dt = new \DateTime('now +30 day');
                $curYear = $dt->format('Y');
                $compar = substr_replace($obj->{'geb'},$curYear,-4);
                $datum = new \DateTime($compar);
                
                $interval = $dt->diff($datum);
               
                if($interval->format('%a') < 30){ 
                    echo  "<div class='alert alert-primary' id='geburtstag' role='alert'>";
                    echo "Der Geburtstag von ".$obj->{'vname'}." ".$obj->{'nname'}." am ".$compar."<br/>";
                    echo "</div>";
                }
            }
        }
    }

    if(!empty($_POST)){
        $objGeburtstage = new \Geburtstag;
        $conf = [
            'vname'=>['minMax'],
            'nname'=>['minMax'],
            'geb'=>['validDate'],
            'tel'=>['validNumber'],
            'email'=>['validMail']
        ];

        $objGeburtstage->setData($_POST,$conf);
        $errors = $objGeburtstage->getErrors();
        $data = $objGeburtstage->getData();

        if(!empty($data)) { 
            writeJson('geburtstage.json',$data);
        }
        
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formular</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <style>
        form{
            max-width:500px;
            padding:20px;
        }
        label{
            padding-top:15px;
        }
        .success{ 
            color: green;
        }
        form .error{
            color:red;
        }
        form .btn-group{
            padding-top:15px;
        }
        #geburtstag{
            max-width:500px;
            height:auto;
        }
    </style>
</head>
<body>
<div id="wrapper" class="container-fluid">
    <!-- <p>Erstellung einer Klasse um Formulareingaben zu validieren.<br>
    Mittels HTML Formular sollen folgende Daten erfasst werden: </p>
    <ul>
        <li>Vorname</li>
        <li>Nachname</li>
        <li>Geburtsdatum</li>
        <li>E-Mail</li>
        <li>Telefonnummer</li>
    </ul> 
    <p>Alle Eingabefelder sind Pflichtfelder und auf Gültigkeit zu überprüfen</p>
    <p>Die Daten sollen in einer Datei (Format: JSON <a href="https://de.wikipedia.org/wiki/JavaScript_Object_Notation" target="_blank">https://de.wikipedia.org/wiki/JavaScript_Object_Notation</a> gespeichert werden.</p>   
    <p>Die bevorstehenden Geburtstage (nächsten 30 Tage) sollen ausgegeben werden.</p> -->
    <h1>Registrierung</h2>
    <?php if(empty($errors) && !empty($_POST['senden'])) echo "<div class='success'>Daten erfolgreich gespeichert.</div>";?>
    <form action="geburtstage.php" method="post">
    <div class="row">
        <label for="vname">Vorname*: </label>
        <input type="text" name="vname" id="vname" value="" class="form-control">
        <?php if(!empty($errors['vname'])) echo "<div class='error'>".$errors['vname']."</div>";?>
    </div>
    <div class="row">
        <label for="nname">Nachname*: </label>
        <input type="text" name="nname" id="nname" value="" class="form-control">
        <?php if(!empty($errors['nname'])) echo "<div class='error'>".$errors['nname']."</div>";?>
    </div>
    <div class="row">
        <label for="geb">Geburtsdatum*: </label>
        <input type="text" name="geb" id="geb" value="" class="form-control">
        <?php if(!empty($errors['geb'])) echo "<div class='error'>".$errors['geb']."</div>";?>
    </div>
    <div class="row">
        <label for="tel">Telefonnummer*: </label>
        <input type="text" name="tel" id="tel" value="" class="form-control">
        <?php if(!empty($errors['tel'])) echo "<div class='error'>".$errors['tel']."</div>";?>
    </div>
    <div class="row">
        <label for="email">E-Mail*: </label>
        <input type="text" name="email" id="email" value="" class="form-control">
        <?php if(!empty($errors['email'])) echo "<div class='error'>".$errors['email']."</div>";?>
    </div>
    <div class="row">
        <div class="btn-group">
            <input type="submit" name="senden" value="senden" class="btn btn-primary">
        </div>
    </div>
    </form>
    <!-- Hier werden die bevorstehenden Geburtstage ausgegeben -->
    <?php getBirthday('geburtstage.json'); ?>
</div>
</body>
</html>