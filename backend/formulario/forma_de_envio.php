<?php
require_once('../conexao.php');
require_once('../cors.php');

header('Content-Type: application/json');


$sql = "SELECT idEnvio, formaEnvio FROM empresa_formaenvio";
$result = $mysqli->query($sql);

if ($result === false) {
    error_log("Erro na consulta SQL: " . $mysqli->error);
    echo json_encode(['error' => "Erro na consulta: " . $mysqli->error]);
    exit;
}

$envio = [];
while($row = $result->fetch_assoc()) {
    $envio[] = $row;
}

echo json_encode($envio);
?>