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

// Obter dados da solicitação
$data = json_decode(file_get_contents('php://input'), true);

// Verificar se os dados estão definidos
if (isset($data['idEmpresa']) && isset($data['idImposto']) && isset($data['valorImposto']) && isset($data['idMes'])) {
    $idEmpresa = $data['idEmpresa'];
    $idImposto = $data['idImposto'];
    $valorImposto = $data['valorImposto'];
    $idMes = $data['idMes'];

    // Preparar e executar a consulta SQL
    $query = "UPDATE entregaimposto SET valorImposto = ? WHERE idEmpresa = ? AND idImposto = ? AND idMes = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('siii', $valorImposto, $idEmpresa, $idImposto, $idMes);

    $response = [];
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['error'] = $stmt->error;
    }

    // Enviar resposta JSON
    echo json_encode($response);
} else {
    // Enviar resposta de erro caso os parâmetros não estejam definidos
    $missing_params = [];
    if (!isset($data['idEmpresa'])) $missing_params[] = 'idEmpresa';
    if (!isset($data['idImposto'])) $missing_params[] = 'idImposto';
    if (!isset($data['valorImposto'])) $missing_params[] = 'valorImposto';
    if (!isset($data['idMes'])) $missing_params[] = 'idMes';

    echo json_encode(['success' => false, 'error' => 'Parâmetros não definidos: ' . implode(', ', $missing_params)]);
}
?>
