<?php
$hostName = "localhost";
$bancoDeDados = "catalogo";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($hostName, $usuario, $senha, $bancoDeDados);
if ($mysqli->connect_error) {
    echo "FALHA AO CONECTAR: (" . $mysqli->connect_error . ") " . $mysqli->connect_error;
}

