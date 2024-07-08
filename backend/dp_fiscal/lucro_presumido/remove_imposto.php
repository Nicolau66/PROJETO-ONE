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
$idMes = $data['idMes'] ?? null;

if ($idEmpresa === null || $idImposto === null || $idMes === null) {
    echo json_encode(["error" => "Dados incompletos."]);
    exit();
}


$sql = "DELETE FROM entregaimposto WHERE idEmpresa = ? AND idImposto = ? AND idMes = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iii", $idEmpresa, $idImposto, $idMes);

if ($stmt->execute()) {
    echo json_encode(["message" => "Imposto removido com sucesso."]);
} else {
    echo json_encode(["error" => "Erro ao remover imposto: " . $stmt->error]);
}


$stmt->close();
$mysqli->close();
?>
