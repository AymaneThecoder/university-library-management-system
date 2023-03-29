<?php


// Redirect to another page

function redirect($url){
    header("Location: $url.php");
    die();
}