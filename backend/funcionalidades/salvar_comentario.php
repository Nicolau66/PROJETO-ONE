<?php
require_once('../conexao.php');
require_once('../cors.php');

if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$idEmpresa = $data['idEmpresa'] ?? null;
$mes = $data['mes'] ?? null;
$ano = $data['ano'] ?? null;
$comentario = $data['comentario'] ?? null;

if ($idEmpresa === null || $mes === null || $ano === null || $comentario === null) {
    echo json_encode(["error" => "Dados incompletos"]);
    exit();
}

// Procurar o idMes na tabela mes com base no mes e ano fornecidos
$idMes = null;
$sql = "SELECT idMes FROM mes WHERE mes = ? AND ano = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param('ii', $mes, $ano);
    $stmt->execute();
    $stmt->bind_result($idMes);
    $stmt->fetch();
    $stmt->close();
}

if ($idMes === null) {
    echo json_encode(["error" => "Mês e ano não encontrados"]);
    exit();
}

// Atualizar ou inserir o comentário na tabela empresa_mes
$sql = "INSERT INTO empresa_mes (idEmpresa, idMes, comentario) VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE comentario = VALUES(comentario)";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param('iis', $idEmpresa, $idMes, $comentario);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Erro ao atualizar o comentário: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
}

$mysqli->close();
?>
