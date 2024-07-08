<?php
require_once('../conexao.php');
require_once('../cors.php');

if (!isset($_POST['idEmpresa'])) {
    echo json_encode(['success' => false, 'message' => 'ID da empresa não fornecido']);
    exit;
}


$idEmpresa = $_POST['idEmpresa'];
$errores = [];


$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");


$sql_declaracao = "DELETE FROM empresa_declaracao WHERE idEmpresa = $idEmpresa";
if (!$mysqli->query($sql_declaracao)) {
    $errores[] = "Erro ao remover da tabela empresa_declaracao: " . $mysqli->error;
}


$sql_entrega_declaracao = "DELETE FROM entregadeclaracao WHERE idEmpresa = $idEmpresa";
if (!$mysqli->query($sql_entrega_declaracao)) {
    $errores[] = "Erro ao remover da tabela entregadeclaracao: " . $mysqli->error;
}


$sql_imposto = "DELETE FROM empresa_imposto WHERE idEmpresa = $idEmpresa";
if (!$mysqli->query($sql_imposto)) {
    $errores[] = "Erro ao remover da tabela empresa_imposto: " . $mysqli->error;
}


$sql_entrega_imposto = "DELETE FROM entregaimposto WHERE idEmpresa = $idEmpresa";
if (!$mysqli->query($sql_entrega_imposto)) {
    $errores[] = "Erro ao remover da tabela entregaimposto: " . $mysqli->error;
}


$sql_forma_envio = "DELETE FROM empresa_forma_envio_rel WHERE idEmpresa = $idEmpresa";
if (!$mysqli->query($sql_forma_envio)) {
    $errores[] = "Erro ao remover da tabela empresa_forma_envio_rel: " . $mysqli->error;
}


$sql_empresa_mes = "DELETE FROM empresa_mes WHERE idEmpresa = $idEmpresa";
if (!$mysqli->query($sql_empresa_mes)) {
    $errores[] = "Erro ao remover da tabela empresa_mes: " . $mysqli->error;
}


$sql_empresa = "DELETE FROM empresa WHERE idEmpresa = $idEmpresa";
if (!$mysqli->query($sql_empresa)) {
    $errores[] = "Erro ao remover da tabela empresa: " . $mysqli->error;
}


$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");


if (empty($errores)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao remover a empresa', 'errors' => $errores]);
}
?>
