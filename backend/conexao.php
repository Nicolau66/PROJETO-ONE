<?php  
$hostName = "localhost";
$bancoDeDados = "dbfmgbrasil";
$usuario = "root";
$senha = "";

// Criar conexão
$mysqli = new mysqli($hostName, $usuario, $senha, $bancoDeDados);


if ($mysqli->connect_errno) {
    echo "Falha ao conectar ao MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}

?>


