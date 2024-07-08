<?php
require_once('../../conexao.php');
require_once('../../cors.php');


if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);

$idEmpresa = isset($data['idEmpresa']) ? intval($data['idEmpresa']) : null;
$idDeclaracao = isset($data['idDeclaracao']) ? intval($data['idDeclaracao']) : null;
$entregue = isset($data['entregue']) && $data['entregue'] ? 1 : 0;

if (is_null($idEmpresa) || is_null($idDeclaracao)) {
    echo json_encode(["error" => "Dados insuficientes para atualizar o status"]);
    exit();
}


$sql = "
    UPDATE entregadeclaracao
    SET entregue = ?
    WHERE idEmpresa = ? AND idDeclaracao = ?
";

$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
    exit();
}

$stmt->bind_param('iii', $entregue, $idEmpresa, $idDeclaracao);

if ($stmt->execute()) {
    echo json_encode(["message" => "Status atualizado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao atualizar status: " . $stmt->error]);
}

// Fechar a conexão
$stmt->close();
$mysqli->close();
?>
