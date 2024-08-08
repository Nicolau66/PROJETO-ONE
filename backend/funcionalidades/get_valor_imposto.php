<?php
// Configurar CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

// Responder à solicitação OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Definir cabeçalho de conteúdo JSON
header('Content-Type: application/json');

// Incluir arquivo de conexão com o banco de dados
require_once('../conexao.php');

// Obter parâmetros da solicitação
$idEmpresa = isset($_GET['idEmpresa']) ? $_GET['idEmpresa'] : null;
$idImposto = isset($_GET['idImposto']) ? $_GET['idImposto'] : null;
$mes = isset($_GET['idMes']) ? $_GET['idMes'] : null;

if ($idEmpresa !== null && $idImposto !== null && $mes !== null) {
    // Preparar e executar a consulta SQL
    $query = "SELECT valorImposto FROM entregaimposto WHERE idEmpresa = ? AND idImposto = ? AND idMes = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('iii', $idEmpresa, $idImposto, $mes);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row) {
            $response = ['valorImposto' => $row['valorImposto']];
        } else {
            $response = ['valorImposto' => null];
        }
    } else {
        $response = ['success' => false, 'error' => $stmt->error];
    }
    echo json_encode($response);
} else {
    error_log("Parâmetros não definidos. idEmpresa: $idEmpresa, idImposto: $idImposto, mes: $mes");
    echo json_encode(['success' => false, 'error' => 'Parâmetros não definidos.']);
}
?>
