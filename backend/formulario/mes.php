<?php
require_once('../conexao.php');
require_once('../cors.php');

header('Content-Type: application/json');


$sql = "SELECT idMes, mes, ano FROM mes";
$result = $mysqli->query($sql);

if ($result === false) {
    error_log("Erro na consulta SQL: " . $mysqli->error);
    echo json_encode(['error' => "Erro na consulta: " . $mysqli->error]);
    exit;
}

$mes = [];
while($row = $result->fetch_assoc()) {
    $mes[] = $row;
}

echo json_encode($mes);
?>
