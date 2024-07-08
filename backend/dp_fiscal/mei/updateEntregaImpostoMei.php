<?php
require_once('../../conexao.php');
require_once('../../cors.php');


if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);

$idEmpresa = isset($data['idEmpresa']) ? intval($data['idEmpresa']) : null;
$idImposto = isset($data['idImposto']) ? intval($data['idImposto']) : null;
$entregue = isset($data['entregue']) && $data['entregue'] ? 1 : 0;

if (is_null($idEmpresa) || is_null($idImposto)) {
    echo json_encode(["error" => "Dados insuficientes para atualizar o status"]);
    exit();
}


$sql = "
    UPDATE entregaimposto
    SET entregue = ?
    WHERE idEmpresa = ? AND idImposto = ?
";

$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
    exit();
}

$stmt->bind_param('iii', $entregue, $idEmpresa, $idImposto);

if ($stmt->execute()) {
    echo json_encode(["message" => "Status atualizado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao atualizar status: " . $stmt->error]);
}


$stmt->close();
$mysqli->close();
?>
