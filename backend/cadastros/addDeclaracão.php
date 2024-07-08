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


error_log("Conexão com o banco de dados estabelecida");

$data = json_decode(file_get_contents("php://input"));


if ($data === null) {
    error_log("Erro ao decodificar JSON");
    http_response_code(400);
    echo json_encode(["message" => "Dados inválidos"]);
    exit();
}

$nomeDeclaracao = $data->nomeDeclaracao ?? '';
$departamento = $data->departamento ?? '';

error_log("nomeDeclaracao: " . $nomeDeclaracao);
error_log("departamento: " . $departamento);

$query = "INSERT INTO declaracao (nomeDeclaracao, departamento) VALUES (?, ?)";
$stmt = $mysqli->prepare($query);


if ($stmt === false) {
    error_log("Erro na preparação da consulta: " . $mysqli->error);
    http_response_code(500);
    echo json_encode(["message" => "Erro ao preparar a consulta"]);
    exit();
}

$stmt->bind_param("ss", $nomeDeclaracao, $departamento);


if ($stmt->execute()) {
    $data->idDeclaracao = $mysqli->insert_id;
    echo json_encode($data);
} else {
    error_log("Erro na execução da consulta: " . $stmt->error);
    http_response_code(500);
    echo json_encode(["message" => "Erro ao adicionar declaração"]);
}

$stmt->close();
$mysqli->close();
?>
