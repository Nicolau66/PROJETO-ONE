<?php
require_once('../../conexao.php');
require_once('../../cors.php');


if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');


$data = json_decode(file_get_contents('php://input'), true);

$idEmpresa = $data['idEmpresa'];
$idDeclaracao = $data['idDeclaracao'];
$entregue = $data['entregue'] ? 1 : 0;


$sql = "
    UPDATE entregadeclaracao
    SET entregue = ?
    WHERE idEmpresa = ? AND idDeclaracao = ?
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iii', $entregue, $idEmpresa, $idDeclaracao);

if ($stmt->execute()) {
    echo json_encode(["message" => "Status atualizado com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao atualizar status: " . $mysqli->error]);
}


$stmt->close();
$mysqli->close();
?>
