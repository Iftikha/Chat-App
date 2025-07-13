<?php
    function checkPasswordStrength($password){
        if(strlen($password) >= 6){
            if(preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password) && preg_match('/[0-9]/', $password) && preg_match('/[\W_]/', $password)){
                return 1;
            }else{
                return 0;
            }
        }
        return 0;
    }
?>