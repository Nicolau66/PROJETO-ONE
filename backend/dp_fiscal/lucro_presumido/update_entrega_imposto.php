<?php
require_once('../../conexao.php');
require_once('../../cors.php');


if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);

$idEmpresa = $data['idEmpresa'] ?? null;
$idImposto = $data['idImposto'] ?? null;
$entregue = $data['entregue'] ?? null;

if ($idEmpresa === null || $idImposto === null || $entregue === null) {
    echo json_encode(["error" => "Dados incompletos."]);
    exit();
}


$sql = "UPDATE entregaimposto SET entregue = ? WHERE idEmpresa = ? AND idImposto = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iii", $entregue, $idEmpresa, $idImposto);

if ($stmt->execute()) {
    echo json_encode(["message" => "Status atualizado com sucesso."]);
} else {
    echo json_encode(["error" => "Erro ao atualizar status: " . $stmt->error]);
}


$stmt->close();
$mysqli->close();
?>
