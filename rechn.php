<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rechnen</title>
</head>
<body>

    <?php
        if (isset($_POST["senf"])){
            $dezimal = $_POST["dezimal"];
            $hexa = dechex($dezimal);
            $binaer = decbin($dezimal);
            $oktal = decoct($dezimal);
        }
    ?>
    <form method="POST">
        <input type="text" name="dezimal" value="<?=isset($dezimal)?$dezimal:''?>" />
        <h1>Die Dzimalzahl:</h1><br/>
        <input type="text" name="hexa" value="<?=isset($hexa)?$hexa:''?>" />
        <h1>in binaererer Schreibweise:</h1><br/>
        <input type="text" name="binaer" value="<?=isset($binaer)?$binaer:''?>" />
        <h1>in oktoberole Schreibweise:</h1><br/>
        <input type="text" name="oktal" value="<?=isset($oktal)?$oktal:''?>" />
        <input type="submit" name="senf" value="Konveert" />
        
    </form>
</body>
</html>