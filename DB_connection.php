<?php

$sName = "localhost"; 
$uName = "root";
$pass = "";
$db_name = "aplicacao_notify_db";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass); 
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch(PDOException $e) {
    echo "Connection failed: ". $e->getMessage();
    exit;
}
