<?php
    function error_handler($errno,$errstr,$errfile,$errline){
        switch( $errno){
            case E_NOTICE:
            echo "NOTICE: [$errno] $errstr <br/>";
            break;
            default:
            echo "Kein E_NOTICE-Fehler!";
            break;
        }
        return true;
    }

    set_error_handler("error_handler", E_NOTICE);

    class Computer {

    }
    $MeinComputer = new Computer();
    $MeinComputer->display;
?>