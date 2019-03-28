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
    echo "<pre>";
    $now = date('m-d-Y H:i:s');
    var_dump(DateTime::createFromFormat('m-d-Y H:i:s', $now));

    $datum = "02.03.2019";
    
    $reg2 = "/^(0?[1-9]|[12][0-9]|3[01]).(0?[1-9]|1[0-2]).((19|20)?[0-9]{2})$/";

    print preg_match($reg2,$datum);
        if (isset($_POST["sinf"])){
            $datum1 = new DateTime($_POST['sinf']);
            $datum2 = new DateTime();
            $diff = $datum2->diff($datum1);

            if($datum1 > $datum2){
                echo "Noch " . $diff->days . " Tage ";
                echo "bis zum " . $datum->format('d.m.Y');
            }else{
                echo "Ihr datum ist schlecht!";
            }
        }
    ?>
    <form method="POST">
        <input type="text" name="eingabe" value="2018" />
        <input type="submit" name="sinf" value="rechne" />
        
    </form>
</body>
</html>