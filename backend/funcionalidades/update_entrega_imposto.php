<?php
require_once('../conexao.php');
require_once('../cors.php');

if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$idEmpresa = $data['idEmpresa'] ?? null;
$idImposto = $data['idImposto'] ?? null;
$idMes = $data['idMes'] ?? null;  // Adicionei esta linha
$entregue = $data['entregue'] ?? null;

if ($idEmpresa === null || $idImposto === null || $idMes === null || $entregue === null) {  // Adicionei idMes aqui
    echo json_encode(["error" => "Dados incompletos"]);
    exit();
}

$sql = "UPDATE entregaimposto SET entregue = ? WHERE idEmpresa = ? AND idImposto = ? AND idMes = ?";  // Adicionei mes aqui
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param('iiii', $entregue, $idEmpresa, $idImposto, $idMes);  // Adicionei idMes aqui

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Erro ao atualizar o status de entrega: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
}

$mysqli->close();
?>
