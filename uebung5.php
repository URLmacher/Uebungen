<!DOCTYPE html>
<?php
    /**Reinigt Variablen
     * @param @mixed [$val]
     * @return @mixed [$val]
     */
    function sanitize($val) {
        $val = htmlspecialchars($val);
        $val = stripslashes($val);
        $val = trim($val);
        return $val;
    }
    //"Datenbank" der Bundsländer und ihrer PLZs
    $bundeslaender = [
        'Wien' => [10,11,12,13,14,15,16,17,18,19],
        'Burgenland' => [70,71,72,73,74,75,76,77,78,79],
        'Niederösterreich' => [20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39],
        'Oberösterreich' => [40,41,42,43,44,45,46,47,48,49],
        'Kärnten' => [90,91,92,93,94,95,96,97,98,99],
        'Steiermark' => [80,81,82,83,84,85,86,87,88,89],
        'Vorarlberg' => [67,68,69],
        'Tirol' => [60,61,62,63,64,65,66],
        'Salzburg' => [50,51,52,53,54,55,56,57,58,59]
    ];
    //Variablen werden vorgefertigt
    $fehler = "";
    $erfolg = "Formular erfolgreich übermittelt!<br/>(theoretisch)";
    $email = '';
    $passwort = '';
    $adresse1 = '';
    $adresse2 = '';
    $plz = '';
    $stadt = '';
    $bundesland = '';
    $agb = '';
    //Werte werden abgeholt beim abschicken
    if (isset($_POST['send'])){
        //variablen befüllen
        foreach ($_POST as $key => $val){
           $$key = sanitize($val);
        }
        //validate Email
        if ($email == "" || $email == "Email-Adresse") {
            $fehler .= "Bitte Email Adresse eingeben.<br/>";
        }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fehler .="Keine gültige Email-Adresse! <br/>";
        }
        //validate Passwort
        $pwRegex = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[0-9])\S*$/';
        if ($passwort == "" || $passwort == "Passwort") {
            $fehler .= "Bitte Passwort eingeben.<br/>";
        }
        elseif(!preg_match($pwRegex,$passwort)) {
            $fehler .= "Ihr Passwort muss: <br/> 
                        min.8 Zeichen lang sein<br/>
                        min. eine Zahl enthalten<br/>
                        min. einen Großbuchstaben enthalten<br/>
                        min. einen Kleinbuchstaben enthalten<br/>
                        min. ein Sonderzeichen enthalten<br/>";
        }     
        //validate Bundesland
        if ($bundesland == "" || $bundesland == "auswählen...") {
            $fehler .= "Bitte Bundesland eingeben.<br/>";
        }
        elseif(!array_key_exists($bundesland,$bundeslaender)) {
            $fehler .= "Kein gültiges Bundesland! <br/>";
        //Vergleicht PLZ mit Bundesland
        }elseif(!array_search(substr($plz,0,2),$bundeslaender[$bundesland])) {
            $fehler .= "Keine gültige Postleitzahl im gewählten Bundesland! <br/>";
        }
        //validate PLZ
        if ($plz == "") {
            $fehler .= "Bitte Postleitzahl eingeben.<br/>";
        }
        elseif(!is_numeric($plz) || strlen($plz) != 4) {
            $fehler .= "Keine gültige Postleitzahl! <br/>";
        }
        //validate AGB
        if($agb == "") {
            $fehler .= "Akzeptieren Sie bitte die AGB.<br/>";
        }
        //leere Felder
        if($adresse1 == "" || $adresse1 == "Musterstraße 123") {
            $fehler .= "Bitte Adresse eingeben. <br/>";
        }
        if($adresse2 == "" || $adresse2 == "Stiege, Stock, Türnummer, ...") {
            $fehler .= "Bitte Adresse eingeben. <br/>";
      }
    }
?>
<html>
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  </head>
  <body>
    <div class="p-5">
      <form method="POST" action="uebung5.php">  
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputEmail4">Email-Adresse</label>
            <input name ="email" type="email" class="form-control" id="inputEmail4" placeholder="Email-Adresse">
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Passwort</label>
            <input name ="passwort" type="password" class="form-control" id="inputPassword4" placeholder="Passwort">
          </div>
        </div>
        <div class="form-group">
          <label for="inputAddress">Adresse</label>
          <input name ="adresse1" type="text" class="form-control" id="inputAddress" placeholder= >
        </div>
        <div class="form-group">
          <label for="inputAddress2">Adresse 2</label>
          <input name="adresse2" type="text" class="form-control" id="inputAddress2" placeholder="Stiege, Stock, Türnummer, ...">
        </div>
        <div class="form-row">
          <div class="form-group col-md-2">
            <label for="inputZip">Postleitzahl</label>
            <input name="plz" type="text" class="form-control" id="inputZip">
          </div>
          <div class="form-group col-md-6">
            <label for="inputCity">Stadt</label>
            <input name="stadt" type="text" class="form-control" id="inputCity">
          </div>
          <div class="form-group col-md-4">
            <label for="inputState">Bundesland</label>
            <select name="bundesland" id="inputState" class="form-control">
              <option selected>auswählen...</option>
              <option value="Wien">Wien</option>
              <option value="Burgenland">Burgenland</option>
              <option value="Niederösterreich">Niederösterreich</option>
              <option value="Oberösterreich">Oberösterreich</option>
              <option value="Kärnten">Kärnten</option>
              <option value="Steiermark">Steiermark</option>
              <option value="Vorarlberg">Vorarlberg</option>
              <option value="Tirol">Tirol</option>
              <option value="Salzburg">Salzburg</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <div class="form-check">
            <input name="agb" value="Ja" class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
              Ich habe die <a href="#">AGBs</a> gelesen und akzeptiere diese.
            </label>
          </div>
        </div>
        <button name="send" type="submit" class="btn btn-primary">Sign in</button>
      </form>
      <?php
      //Ausgabe der Fehler oder des Erfolgs
        if (isset($_POST['send']) && $fehler == ""){
          echo "<div class='alert alert-success' role='alert'>".$erfolg."</div>";
        }elseif(isset($_POST['send'])){
            echo "<div class='alert alert-danger' role='alert'>".$fehler."</div>";
        }
      ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
