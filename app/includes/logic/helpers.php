<?php


// Redirect to another page

function redirect($url){
    header("Location: $url.php");
    die();
}

// Clear a session variable after certain amount of time

function clearSessVarIfTimedOut($variableName, $timeoutSec){

    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeoutSec)
    {
        unset($_SESSION[$variableName], $_SESSION['last_activity']);
    } 

}