<?php
require_once('../conexao.php'); 
require_once('../cors.php');


if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);
$idMes = $data['idMes'];
$idEmpresa = $data['idEmpresa'];
$idImpostos = isset($data['idImpostos']) ? $data['idImpostos'] : [];
$idDeclaracoes = isset($data['idDeclaracoes']) ? $data['idDeclaracoes'] : [];


if (!is_numeric($idMes) || !is_numeric($idEmpresa) || !is_array($idDeclaracoes) || !is_array($idImpostos)) {
    echo json_encode(["error" => "Dados inválidos"]);
    exit();
}

$success = true;
$error = '';


if (!empty($idImpostos)) {
    $sqlImposto = "
        INSERT INTO entregaimposto (idEmpresa, idImposto, idMes, entregue)
        VALUES (?, ?, ?, 0)
        ON DUPLICATE KEY UPDATE idMes = VALUES(idMes)
    ";

    $stmtImposto = $mysqli->prepare($sqlImposto);

    foreach ($idImpostos as $idImposto) {
        if (!is_numeric($idImposto)) {
            continue;
        }
        $stmtImposto->bind_param("iii", $idEmpresa, $idImposto, $idMes);

        if (!$stmtImposto->execute()) {
            $success = false;
            $error = $stmtImposto->error;
            break;
        }
    }

    $stmtImposto->close();
}


if (!empty($idDeclaracoes)) {
    $sqlDeclaracao = "
        INSERT INTO entregadeclaracao (idEmpresa, idDeclaracao, idMes, entregue)
        VALUES (?, ?, ?, 0)
        ON DUPLICATE KEY UPDATE idMes = VALUES(idMes)
    ";

    $stmtDeclaracao = $mysqli->prepare($sqlDeclaracao);

    foreach ($idDeclaracoes as $idDeclaracao) {
        if (!is_numeric($idDeclaracao)) {
            continue;
        }
        $stmtDeclaracao->bind_param("iii", $idEmpresa, $idDeclaracao, $idMes);

        if (!$stmtDeclaracao->execute()) {
            $success = false;
            $error = $stmtDeclaracao->error;
            break;
        }
    }

    $stmtDeclaracao->close();
}

if ($success) {
    echo json_encode(["message" => "Empresa, impostos e declarações vinculados com sucesso ao mês e ano selecionado"]);
} else {
    echo json_encode(["error" => "Erro ao vincular empresa: " . $error]);
}

$mysqli->close();
?>
