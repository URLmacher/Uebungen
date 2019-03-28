<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Datujm</title>
</head>
<body>

    <?php
        if (isset($_POST["senf"])){
            $datum1 = strtotime($_POST["eingabe"]);
            $datum2 = time();
            $erg = $datum1 - $datum2;
            if($erg > 0){
                echo "Noch " . floor($erg / (60 * 60 * 24)) . " Tage ";
                echo "bis zum " . date('d.m.Y', $datum1);
            }else{
                echo "Ihr datum ist schlecht!";
            }
        }
    ?>
    <form method="POST">
        <input type="text" name="eingabe" value="<?=isset($dezimal)?$dezimal:''?>" />
        <input type="submit" name="senf" value="Konveert" />
        
    </form>
   
</body>
</html>