<?php
require_once('../conexao.php');
require_once('../cors.php');

$data = json_decode(file_get_contents("php://input"));

// Verifica se os campos obrigatórios estão presentes
if (!isset($data->idEmpresa) || !isset($data->idDeclaracao) || !isset($data->idMes) || !isset($data->entregue)) {
    echo json_encode(["error" => "Campos obrigatórios ausentes"]);
    exit();
}

$idEmpresa = $data->idEmpresa;
$idDeclaracao = $data->idDeclaracao;
$idMes = $data->idMes;
$entregue = $data->entregue ? 1 : 0;

// Prepara a consulta SQL para atualizar o status de entrega
$sql = "UPDATE entregadeclaracao SET entregue = ? WHERE idEmpresa = ? AND idDeclaracao = ? AND idMes = ?";

$stmt = $mysqli->prepare($sql);
if ($stmt) {
    $stmt->bind_param("iiii", $entregue, $idEmpresa, $idDeclaracao, $idMes);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Status atualizado com sucesso"]);
    } else {
        echo json_encode(["error" => "Erro ao atualizar status: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
}

$mysqli->close();
?>
