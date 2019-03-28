<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP OK</title>
</head>
<body>



<?php





class CSVIterator implements Iterator{
    private $csv;
    private $position;

    public function __construct($csv) {
        $this->csv = explode(',',$csv);
    }
    public function next() {
        $this->position += 1;
    }
    public function rewind() {
        $this->position = 0;
    }
    public function key() {
        return $this->position;
    }
    public function current() {
        return $this->csv[$this->position];
    }
    public function valid() {
        return $this->position < count($this->csv);
    }
}

class CSVFilterIterator extends FilterIterator {
    private $wert;

    public function __construct(CSVIterator $CSVIterator, $wert) {
        parent::__construct($CSVIterator);
        $this->$wert = $wert; 
    }
    public function accept() {
        $ele = $this->getInnerIterator()->current();
        if (strpos($ele, $this->wert) !== 0) {
            return true;
        } else {
            return false;
        }
    }
}

class CSV implements IteratorAggregate {
    private $csv;
    
    public function __construct($csv = '') {
        $this->csv = $csv;
    }
    public function getIterator() {
    
         return new CSVFilterIterator(new CSVIterator($this->csv), 'seperierte');
    }
}



$text = new CSV("DEr, TESR , rfrgege, ereg,Komma,seperierte, Weret");

foreach ($text as $schluessel => $wert) {
    echo $wert;
    echo '</br>';
}
?>


</body>
</html>