<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With");
header('Content-Type: application/json');

error_log("CORS headers set");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

require_once('../conexao.php');

$data = json_decode(file_get_contents("php://input"));

$idDeclaracao = $data->idDeclaracao;
$nomeDeclaracao = $data->nomeDeclaracao;
$departamento = $data->departamento;

$query = "UPDATE declaracao SET nomeDeclaracao = ?, departamento = ? WHERE idDeclaracao = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssi", $nomeDeclaracao, $departamento, $idDeclaracao);

if ($stmt->execute()) {
    echo json_encode(["message" => "Declaração atualizada com sucesso."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Erro ao atualizar declaração."]);
}
$stmt->close();
$mysqli->close();
?>
