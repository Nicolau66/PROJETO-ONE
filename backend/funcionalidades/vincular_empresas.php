<?php
require_once('../conexao.php'); 
require_once('../cors.php');


if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);


if (!isset($data['idMes']) || empty($data['idMes'])) {
    echo json_encode(["error" => "Dados inválidos"]);
    exit();
}

$idMes = $data['idMes'];


$sqlDeclaracao = "
    INSERT INTO entregadeclaracao (idEmpresa, idDeclaracao, idMes, entregue)
    SELECT ed.idEmpresa, ed.idDeclaracao, ?, 0
    FROM entregadeclaracao ed
    WHERE ed.idMes <> ?
    ON DUPLICATE KEY UPDATE idMes = VALUES(idMes)
";

$sqlImposto = "
    INSERT INTO entregaimposto (idEmpresa, idImposto, idMes, entregue)
    SELECT ei.idEmpresa, ei.idImposto, ?, 0
    FROM entregaimposto ei
    WHERE ei.idMes <> ?
    ON DUPLICATE KEY UPDATE idMes = VALUES(idMes)
";

$stmtDeclaracao = $mysqli->prepare($sqlDeclaracao);
$stmtImposto = $mysqli->prepare($sqlImposto);

$stmtDeclaracao->bind_param("ii", $idMes, $idMes);
$stmtImposto->bind_param("ii", $idMes, $idMes);

$success = true;

if (!$stmtDeclaracao->execute()) {
    $success = false;
    $error = $stmtDeclaracao->error;
}

if (!$stmtImposto->execute()) {
    $success = false;
    $error = $stmtImposto->error;
}

if ($success) {
    echo json_encode(["message" => "Empresas vinculadas com sucesso ao mês e ano selecionado"]);
} else {
    echo json_encode(["error" => "Erro ao vincular empresas: " . $error]);
}


$stmtDeclaracao->close();
$stmtImposto->close();
$mysqli->close();
?>
