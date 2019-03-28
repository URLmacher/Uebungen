<?php

    class Geburtstag{
       
        private $data;
        private $errors = [];
        
        /**
         * Wertet Daten anhand der übermittelten Konfiguration aus
         * @param array $form
         * @param array $conf
         */
        public function setData($form,$conf) {
            foreach($form as $key => $val) {
                if(!empty($val)){
                    foreach($conf as $subject => $method) {
                        if(!empty($method) && $key == $subject){
                            $dothis = $method[0];
                            $this->$dothis($val,$key);
                        }
                    }
                }else{
                    $this->errors[$key] = "Bitte alle Felder ausfüllen.";
                }
            }
        }

        /**
         * Überprüft auf die richtige Länge von Strings
         * @param string $name
         * @param string $key
         */
        public function minMax($name,$key){
            if(strlen($name) > 2 && strlen($name) < 20){
                $this->cleanData($name,$key);
            }else{
                $this->errors[$key] = "Namenslänge inakzeptabel!";
            }
        }

        /**
         * Überprüft das Geburtsdatum
         * @param string $date
         * @param string $key
         */
        public function validDate($date,$key){
            $reg= '/^(0?[1-9]|[12]\d|3[01]).(0?[1-9]|1[0-2]).((19|20){1}\d{2})$/';
            if (preg_match($reg,$date)){
                $datum = new \DateTime($date);
                $heute = new \DateTime();
                    if($datum>$heute){
                        $this->errors[$key] = "Sie sind noch garnicht geboren!";
                    }
                    $this->cleanData($date,$key);
            }else{
                $this->errors[$key] = "Datum ungültig!";
            }
        }

        /**
         * Überprüft Telefonnummer auf Ordentlichkeit
         * @param string $number
         * @param string $key
         */
        public function validNumber($number,$key){
            $number = preg_replace('/[^\d]/','',$number);
            $reg = '/^\d{1,15}$/i';
            if(preg_match($reg,$number)) {
                $this->cleanData($number,$key);
            }else{
                $this->errors[$key] = "Telefonnummer ungültig!";
            }
        }

        /**
         * Überprüft die Email Adresse
         * @param string $email
         * @param string $key
         */
        public function validMail($email,$key){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->cleanData($email,$key);
            }else{
                $this->errors[$key] = "Email Adresse ungültig!";
            }
        }

        /**
         * Reinigt Daten vorm endgültigen Speichern
         * @param string $data
         * @param string $key
         */
        public function cleanData($data,$key) {
            $data = stripslashes($data);
            $data = trim($data);
            $data = htmlspecialchars($data);
            $this->data[$key] = $data;
        }

        /**
         * Gibt Daten aus
         * @return array $data
         */
        public function getData() {
            if(empty($this->errors)) {
                return $this->data;
            }
        }

        /**
         * Gibt Fehler aus
         * @return array $errors
         */
        public function getErrors() {
            return $this->errors;
        }
    }
?>