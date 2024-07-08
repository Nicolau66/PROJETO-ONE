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
$idMes = $data['idMes'];


$sql = "
    DELETE FROM entregadeclaracao
    WHERE idEmpresa = ? AND idDeclaracao = ? AND idMes = ?
";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param('iii', $idEmpresa, $idDeclaracao, $idMes);

if ($stmt->execute()) {
    echo json_encode(["message" => "Declaração removida com sucesso"]);
} else {
    echo json_encode(["error" => "Erro ao remover declaração: " . $mysqli->error]);
}


$stmt->close();
$mysqli->close();
?>
