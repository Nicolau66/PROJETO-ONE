<?php
require_once('../../conexao.php');
require_once('../../cors.php');

$data = json_decode(file_get_contents("php://input"));


if (!isset($data->idEmpresa) || !isset($data->idDeclaracao) || !isset($data->entregue)) {
    echo json_encode(["error" => "Campos obrigatórios ausentes"]);
    exit();
}

$idEmpresa = $data->idEmpresa;
$idDeclaracao = $data->idDeclaracao;
$entregue = $data->entregue ? 1 : 0;


$sql = "UPDATE entregadeclaracao SET entregue = ? WHERE idEmpresa = ? AND idDeclaracao = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iii", $entregue, $idEmpresa, $idDeclaracao);

if ($stmt->execute()) {
    echo json_encode(["message" => "Status atualizado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao atualizar status"]);
}

$stmt->close();
$mysqli->close();
?>
