<?php
require_once('../conexao.php');
require_once('../cors.php');

header('Content-Type: application/json');


$sql = "SELECT idEstado, nomeEstado FROM estado";
$result = $mysqli->query($sql);

if ($result === false) {
    error_log("Erro na consulta SQL: " . $mysqli->error);
    echo json_encode(['error' => "Erro na consulta: " . $mysqli->error]);
    exit;
}

$estados = [];
while($row = $result->fetch_assoc()) {
    $estados[] = $row;
}

echo json_encode($estados);
?>



