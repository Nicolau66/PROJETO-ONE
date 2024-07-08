<?php
require_once('../conexao.php');
require_once('../cors.php');

$sql = "SELECT idEmpresa, razaoSocial, cnpj, telefone FROM empresa";
$result = $mysqli->query($sql);

$empresas = [];
while ($row = $result->fetch_assoc()) {
    $empresas[] = $row;
}

echo json_encode($empresas);
?>
