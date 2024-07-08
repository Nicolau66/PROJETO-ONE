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

$idImposto = $data->idImposto;
$nomeImposto = $data->nomeImposto;
$departamento = $data->departamento;

$query = "UPDATE imposto SET nomeImposto = ?, departamento = ? WHERE idImposto = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssi", $nomeImposto, $departamento, $idImposto);

if ($stmt->execute()) {
    echo json_encode(["message" => "Imposto atualizado com sucesso."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Erro ao atualizar imposto."]);
}
$stmt->close();
$mysqli->close();
?>
