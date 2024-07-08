<?php
require_once('../../conexao.php');
require_once('../../cors.php');



if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');


$input = json_decode(file_get_contents("php://input"), true);

$idEmpresa = $input['idEmpresa'] ?? null;
$idDeclaracao = $input['idDeclaracao'] ?? null;
$entregue = $input['entregue'] ? 1 : 0;


if (is_null($idEmpresa) || is_null($idDeclaracao)) {
    echo json_encode(["error" => "Parâmetros inválidos"]);
    exit();
}


$sql = "UPDATE entregadeclaracao SET entregue = ? WHERE idEmpresa = ? AND idDeclaracao = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iii", $entregue, $idEmpresa, $idDeclaracao);

if ($stmt->execute()) {
    echo json_encode(["message" => "Status atualizado com sucesso."]);
} else {
    echo json_encode(["error" => "Erro ao atualizar status: " . $mysqli->error]);
}


$stmt->close();
$mysqli->close();
?>
