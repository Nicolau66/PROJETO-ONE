<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With");
header('Content-Type: application/json');

require_once('../conexao.php');

$data = json_decode(file_get_contents("php://input"));

$idMes = $data->idMes ?? '';
$mes = $data->mes ?? '';
$ano = $data->ano ?? '';

$query = "UPDATE mes SET mes = ?, ano = ? WHERE idMes = ?";
$stmt = $mysqli->prepare($query);

if ($stmt === false) {
    error_log("Erro na preparação da consulta: " . $mysqli->error);
    http_response_code(500);
    echo json_encode(["message" => "Erro ao preparar a consulta"]);
    exit();
}

$stmt->bind_param("iii", $mes, $ano, $idMes);

if ($stmt->execute()) {
    echo json_encode(["message" => "Mês atualizado com sucesso"]);
} else {
    error_log("Erro na execução da consulta: " . $stmt->error);
    http_response_code(500);
    echo json_encode(["message" => "Erro ao atualizar mês"]);
}

$stmt->close();
$mysqli->close();
?>
