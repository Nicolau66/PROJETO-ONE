<?php
require_once('../../conexao.php');
require_once('../../cors.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request method"]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

$idEmpresa = $data['idEmpresa'] ?? null;
$idImposto = $data['idImposto'] ?? null;
$entregue = $data['entregue'] ?? null;

if ($idEmpresa === null || $idImposto === null || $entregue === null) {
    echo json_encode(["error" => "Missing parameters"]);
    exit();
}

$entregue = $entregue ? 1 : 0;

$sql = "
    UPDATE entregaimposto
    SET entregue = ?
    WHERE idEmpresa = ? AND idImposto = ?
";

$stmt = $mysqli->prepare($sql);
if ($stmt === false) {
    echo json_encode(["error" => "Prepare failed: " . $mysqli->error]);
    exit();
}

$stmt->bind_param('iii', $entregue, $idEmpresa, $idImposto);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Execute failed: " . $stmt->error]);
}

$stmt->close();
$mysqli->close();
?>
