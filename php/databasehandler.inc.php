<?php

$host= "localhost";
$dbUsername = "root";
$dbPwd = "root";
$dbName = "easylandb";

$connection = new PDO("mysqli:host=$host;dbname=$dbName",$dbUsername,$dbPwd);

/*$options = [
    PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
];*/

if(!$connection)
    die("Connessione al DB non riuscita" . mysqli_connect_error());