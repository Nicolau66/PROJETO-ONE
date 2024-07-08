<?php
require_once('../../conexao.php');
require_once('../../cors.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['idEmpresa']) || !isset($data['idImposto']) || !isset($data['idMes'])) {
    echo json_encode(["error" => "Dados insuficientes para a remoção"]);
    exit();
}

$idEmpresa = intval($data['idEmpresa']);
$idImposto = intval($data['idImposto']);
$idMes = intval($data['idMes']);

error_log("Tentativa de remover imposto: idEmpresa=$idEmpresa, idImposto=$idImposto, idMes=$idMes");

// Consulta SQL para remover o imposto
$sql = "DELETE FROM entregaimposto WHERE idEmpresa = ? AND idImposto = ? AND idMes = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
    exit();
}

$stmt->bind_param("iii", $idEmpresa, $idImposto, $idMes);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => "Imposto removido com sucesso"]);
    } else {
        echo json_encode(["error" => "Nenhum imposto foi removido"]);
    }
} else {
    echo json_encode(["error" => "Erro ao remover imposto: " . $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>
