<?php
function conectar() {
    // $link = mysql_pconnect("localhost", "leer", "Leer2018");
    //mysql_select_db("bd_gmp", $link);
//    $link = mysql_pconnect("localhost", "root", "root");
//    // mysqli_set_charset($link, 'utf8');
//    mysql_select_db($_SESSION['ses_nombd'], $link);
    
    $mysqli = new mysqli('127.0.0.1', 'root', 'root', $_SESSION['ses_nombd']);
$mysqli->set_charset("utf8");
    return $mysqli;
}

?>