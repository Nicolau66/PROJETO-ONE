<?php
require_once('../conexao.php');
require_once('../cors.php');
header('Content-Type: application/json');


$sql = "SELECT idImposto, nomeImposto FROM imposto";
$result = $mysqli->query($sql);

if ($result === false) {
    error_log("Erro na consulta SQL: " . $mysqli->error);
    echo json_encode(['error' => "Erro na consulta: " . $mysqli->error]);
    exit;
}

$impostos = [];
while($row = $result->fetch_assoc()) {
    $impostos[] = $row;
}

echo json_encode($impostos);
?>
