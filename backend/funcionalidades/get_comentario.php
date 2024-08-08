<?php
require_once('../conexao.php');
require_once('../cors.php');

if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');

$idEmpresa = $_GET['idEmpresa'] ?? null;
$mes = $_GET['mes'] ?? null;
$ano = $_GET['ano'] ?? null;

if ($idEmpresa === null || $mes === null || $ano === null) {
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

$sql = "SELECT comentario FROM empresa_mes WHERE idEmpresa = ? AND idMes = ?";
$stmt = $mysqli->prepare($sql);

if ($stmt) {
    $stmt->bind_param('ii', $idEmpresa, $idMes);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(["comentario" => $row['comentario']]);
    } else {
        echo json_encode(["comentario" => ""]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["error" => "Erro ao preparar a consulta: " . $mysqli->error]);
}

$mysqli->close();
?>
