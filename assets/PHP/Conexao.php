<?php
$hostName = "localhost";
$bancoDeDados = "teste";
$usuario = "root";
$senha = "";


try{
    $conn = new PDO("mysql:host=$hostName;dbname=" . $bancoDeDados, $usuario, $senha );
} catch(PDOException $error) {
    echo "FALHA AO CONECTAR: (" . $error->getMessage(). ") ";
}
