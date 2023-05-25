<?php
$hostName = "localhost";
$bancoDeDados = "teste";
$usuario = "root";
$senha = "";


try{
    // $mysqli = new PDO($hostName, $usuario, $senha, $bancoDeDados);
    $conn = new PDO("mysql:host=$hostName;dbname=" . $bancoDeDados, $usuario, $senha );
} catch(PDOException $error) {
    echo "FALHA AO CONECTAR: (" . $error->getMessage(). ") ";
}



// if ($mysqli->connect_error) {
//    
// }