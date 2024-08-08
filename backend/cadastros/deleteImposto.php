<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

require_once('../conexao.php');

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->idImposto)) {
    error_log("Dados inválidos recebidos: " . json_encode($data));
    http_response_code(400);
    echo json_encode(["message" => "Dados inválidos"]);
    exit();
}

$idImposto = $data->idImposto;

$queryCheck = "SELECT COUNT(*) FROM empresa_imposto WHERE idImposto = ?";
$stmtCheck = $mysqli->prepare($queryCheck);
if (!$stmtCheck) {
    error_log("Erro ao preparar queryCheck: " . $mysqli->error);
    http_response_code(500);
    echo json_encode(["message" => "Erro interno no servidor"]);
    exit();
}
$stmtCheck->bind_param("i", $idImposto);
$stmtCheck->execute();
$stmtCheck->bind_result($count);
$stmtCheck->fetch();
$stmtCheck->close();

if ($count > 0) {
    error_log("Imposto está vinculado a uma empresa, não pode ser excluído: idImposto = $idImposto");
    http_response_code(400);
    echo json_encode(["message" => "O imposto está vinculado a uma empresa e não pode ser excluído."]);
} else {
    $query = "DELETE FROM imposto WHERE idImposto = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) {
        error_log("Erro ao preparar query: " . $mysqli->error);
        http_response_code(500);
        echo json_encode(["message" => "Erro interno no servidor"]);
        exit();
    }
    $stmt->bind_param("i", $idImposto);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Imposto removido com sucesso."]);
    } else {
        error_log("Erro ao executar query: " . $stmt->error);
        http_response_code(500);
        echo json_encode(["message" => "Erro ao remover imposto."]);
    }
    $stmt->close();
}
$mysqli->close();
?>
