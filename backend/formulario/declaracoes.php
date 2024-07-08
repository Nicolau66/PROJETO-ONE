<?php
require_once('../conexao.php');
require_once('../cors.php');


header('Content-Type: application/json');


$sql = "SELECT idDeclaracao, nomeDeclaracao FROM declaracao";
$result = $mysqli->query($sql);

if ($result === false) {
    
    error_log("Erro na consulta SQL: " . $mysqli->error);
    echo json_encode(['error' => "Erro na consulta: " . $mysqli->error]);
    exit;
}

$declaracoes = [];
while($row = $result->fetch_assoc()) {
    $declaracoes[] = $row;
}

echo json_encode($declaracoes);
?>
