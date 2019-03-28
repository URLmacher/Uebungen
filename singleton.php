<?php
// class SingletonLegacy{

//     /**
//      * Die einzig Instanz der Klasse wir hier gespeichert
//      */

//     private static $instance = false;
//     protected $dsn;

//     /**
//      * Hier wird die Instanz übergeben
//      */

//     public static function getInstance() {
//         // wenn es keine Instanz gibt, wird eine erzeugt
//         if(self::$instance == false) {
//             $class = __CLASS__;
//             self::$instance = new SingletonLegacy;
//         }
//         //wenn es eine Instanz gibt, wird sie heir ausgegeben
//         return self::$instance;
//     }
//     //Beispiel Methode
//     public function setDsn($dsn) {
//         $this->dsn = $dsn;
//     }
//     //Beispiel Methode
//     public function getDsn() {
//        return  $this->dsn;
//     }
//     /**
//      * Muss privat oder protected sein
//      */
//     private function __construct(){
//         return 'CLass created';
//     }

//     /**
//      * Keine Klone erlaubt
//      */
//     private function __clone(){}

//     /**
//      * Keine serialization
//      */
//     private function __wakeup(){}
// }

// $database = SingletonLegacy::getInstance();
// $database->setDsn('Hello');
// echo $database->getDsn() . PHP_EOL;

// $database2 = SingletonLegacy::getInstance();
// $database2->setDsn('bölö');
// echo $database2->getDsn() . PHP_EOL;

class Singleton{
    /**
     * Die einzig Instanz der Klasse wir hier gespeichert
     */

    private static $instance = false;

    /**
     * Hier wird die Instanz übergeben
     */

    public static function getInstance() {
        // wenn es keine Instanz gibt, wird eine erzeugt
        if(self::$instance == false) {
            return self::$instance = new static();
        }
        //Late static binding
        return self::$instance;
    }
 
    /**
     * Zugriff nicth erlaubt
     */
    protected function __construct(){}

    /**
     * Keine Klone erlaubt
     */
    private function __clone(){}

    /**
     * Keine serialization
     */
    private function __wakeup(){}
}

class Database extends Singleton{

    protected $dsn;
    //Beispiel Methode
    public function setDsn($dsn) {
        $this->dsn = $dsn;
    }
    //Beispiel Methode
    public function getDsn() {
       return  $this->dsn;
    }
}

$database = Database::getInstance();
$database->setDsn('Fotze');
echo $database->getDsn();


$database2 = Database::getInstance();
$database2->setDsn('bölö');
echo $database2->getDsn() . PHP_EOL;