<?php
require_once('../conexao.php');
require_once('../cors.php');

$query = "SELECT idEmpresa, razaoSocial FROM empresa";
$result = $mysqli->query($query);

$empresas = array();
while ($row = $result->fetch_assoc()) {
    $empresas[] = $row;
}

echo json_encode($empresas);
?>
