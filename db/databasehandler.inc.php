<?php

$host = "localhost";
$DBuser = "root";
$DBpwd = "root";
$dbName = "easylandb";

//si connette con un try-catch,
try {
    $connection = new PDO("mysql:host=$host;dbname=$dbName", $DBuser, $DBpwd);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connessione al DB non riuscita" . $e);
}

