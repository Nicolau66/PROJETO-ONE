<?php
require_once('../conexao.php');
require_once('../cors.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['idEmpresa']) || !isset($data['idDeclaracao']) || !isset($data['idMes'])) {
    echo json_encode(["error" => "Dados insuficientes para a remoção"]);
    exit();
}

$idEmpresa = intval($data['idEmpresa']);
$idDeclaracao = intval($data['idDeclaracao']);
$idMes = intval($data['idMes']);

error_log("Tentativa de remover declaração: idEmpresa=$idEmpresa, idDeclaracao=$idDeclaracao, idMes=$idMes");

// Consulta SQL para remover a declaração
$sql = "DELETE FROM entregadeclaracao WHERE idEmpresa = ? AND idDeclaracao = ? AND idMes = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt === false) {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
    exit();
}

$stmt->bind_param("iii", $idEmpresa, $idDeclaracao, $idMes);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => "Declaração removida com sucesso"]);
    } else {
        echo json_encode(["error" => "Nenhuma declaração foi removida"]);
    }
} else {
    echo json_encode(["error" => "Erro ao remover declaração: " . $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>
