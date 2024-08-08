<?php
require_once('../conexao.php');
require_once('../cors.php');

header('Content-Type: application/json');

// Consultas SQL
$sql_impostos = "
    SELECT 
        imposto.nomeImposto as nome, 
        mes.mes,
        mes.ano,
        COUNT(CASE WHEN entregaimposto.entregue = 1 THEN 1 END) as entregues, 
        COUNT(CASE WHEN entregaimposto.entregue = 0 THEN 1 END) as naoEntregues 
    FROM 
        entregaimposto
    JOIN 
        imposto ON entregaimposto.idImposto = imposto.idImposto
    JOIN
        mes ON entregaimposto.idMes = mes.idMes
    GROUP BY 
        imposto.nomeImposto, mes.mes, mes.ano
";

$sql_declaracoes = "
    SELECT 
        declaracao.nomeDeclaracao as nome, 
        mes.mes,
        mes.ano,
        COUNT(CASE WHEN entregadeclaracao.entregue = 1 THEN 1 END) as entregues, 
        COUNT(CASE WHEN entregadeclaracao.entregue = 0 THEN 1 END) as naoEntregues 
    FROM 
        entregadeclaracao
    JOIN 
        declaracao ON entregadeclaracao.idDeclaracao = declaracao.idDeclaracao
    JOIN
        mes ON entregadeclaracao.idMes = mes.idMes
    GROUP BY 
        declaracao.nomeDeclaracao, mes.mes, mes.ano
";

// Executar consultas
$result_impostos = $mysqli->query($sql_impostos);
$result_declaracoes = $mysqli->query($sql_declaracoes);

if ($result_impostos === false || $result_declaracoes === false) {
    echo json_encode(["error" => "Erro na consulta SQL: " . $mysqli->error]);
    exit();
}

// Processar resultados
$data = [
    "impostos" => [],
    "declaracoes" => []
];

if ($result_impostos->num_rows > 0) {
    while ($row = $result_impostos->fetch_assoc()) {
        $data["impostos"][] = $row;
    }
}

if ($result_declaracoes->num_rows > 0) {
    while ($row = $result_declaracoes->fetch_assoc()) {
        $data["declaracoes"][] = $row;
    }
}

// Fechar conexão
$mysqli->close();

// Retornar JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>
