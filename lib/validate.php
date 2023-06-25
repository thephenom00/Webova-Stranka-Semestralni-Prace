<?php
    // FUNCTION TO VALIDATE USERNAME
    // HAS TO CONTAIN ONLY LETTERS AND NUMBERS, NO SPACES, MORE THAN 5 CHARS
    function validateName($name) {
        if(strlen($name) >= 5 && !strpos($name, ' ') && !preg_match('/[^A-Za-z0-9]/', $name)){
            return true;
        }else{
            return false;
        }

    }

    // FUNCTION TO VALIDATE PASSWORD
    // HAS TO MATCH, MUST NOT CONTAIN SPACES, MORE THAN 4 CHARS
    function validatePasswords($pass1, $pass2) {
        if($pass1 == $pass2 && strlen($pass1) >= 4 && !strpos($pass1, ' ')){ 
            return true;
        }
    }

    // FUNCTION TO VALIDATE EMAIL
    // HAS TO CONTAIN @ AND . AND NO SPECIAL CHARS
    function validateEmail($email) {
        if (strpos($email, '@') !== false && strpos($email, '.') !== false && !preg_match('/[^@.A-Za-z0-9]/', $email)){
            return true;
        }else{
            return false;
        }
    }




?>