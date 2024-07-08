<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With");
header('Content-Type: application/json');

require_once('../conexao.php');

$data = json_decode(file_get_contents("php://input"));

$idMes = $data->idMes ?? '';


$queryCheck = "SELECT COUNT(*) FROM entregadeclaracao WHERE idMes = ?";
$stmtCheck = $mysqli->prepare($queryCheck);
$stmtCheck->bind_param("i", $idMes);
$stmtCheck->execute();
$stmtCheck->bind_result($count);
$stmtCheck->fetch();
$stmtCheck->close();

if ($count > 0) {
    http_response_code(400);
    echo json_encode(["message" => "O mês está vinculado a uma empresa e não pode ser excluído."]);
} else {
    $query = "DELETE FROM mes WHERE idMes = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $idMes);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Mês removido com sucesso."]);
    } else {
        error_log("Erro na execução da consulta: " . $stmt->error);
        http_response_code(500);
        echo json_encode(["message" => "Erro ao remover mês"]);
    }
    $stmt->close();
}

$mysqli->close();
?>
