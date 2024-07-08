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


$queryCheck = "SELECT COUNT(*) FROM empresa_declaracao WHERE idDeclaracao = ?";
$stmtCheck = $mysqli->prepare($queryCheck);
$stmtCheck->bind_param("i", $idDeclaracao);
$stmtCheck->execute();
$stmtCheck->bind_result($count);
$stmtCheck->fetch();
$stmtCheck->close();

if ($count > 0) {
    http_response_code(400);
    echo json_encode(["message" => "A declaração está vinculada a uma empresa e não pode ser excluída."]);
} else {
    $query = "DELETE FROM declaracao WHERE idDeclaracao = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $idDeclaracao);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Declaração removida com sucesso."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Erro ao remover declaração."]);
    }
    $stmt->close();
}
$mysqli->close();
?>
