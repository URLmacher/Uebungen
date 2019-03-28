<?php
namespace meinNS;

class Gruss {
    private $name;
    function __construct($name) {
        $this->name = $name;
    }
    function hallo() {
        echo "Hsllo {$this->name}!";
    }
}

?>