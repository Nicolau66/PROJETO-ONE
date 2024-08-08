<?php
require_once('../../conexao.php');
require_once('../../cors.php');

if ($mysqli->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $mysqli->connect_error]));
}

header('Content-Type: application/json');

$sql = "
    SELECT 
        empresa.idEmpresa,
        empresa.razaoSocial, 
        empresa.responsavelFiscal, 
        empresa.formaDeFechamento, 
        declaracao.idDeclaracao, 
        declaracao.nomeDeclaracao,
        mes.idMes,         /* Adiciona idMes à seleção */
        mes.mes, 
        mes.ano, 
        entregadeclaracao.entregue,
        estado.nomeEstado,
        GROUP_CONCAT(empresa_formaenvio.formaEnvio SEPARATOR ', ') AS formaEnvio
    FROM 
        entregadeclaracao
    JOIN 
        empresa ON entregadeclaracao.idEmpresa = empresa.idEmpresa
    JOIN 
        declaracao ON entregadeclaracao.idDeclaracao = declaracao.idDeclaracao
    JOIN 
        mes ON entregadeclaracao.idMes = mes.idMes
    JOIN 
        estado ON empresa.idEstado = estado.idEstado
    JOIN 
        regimetributario ON empresa.idRegimeTributario = regimetributario.idRegimeTributario
    LEFT JOIN 
        empresa_forma_envio_rel ON empresa.idEmpresa = empresa_forma_envio_rel.idEmpresa
    LEFT JOIN 
        empresa_formaenvio ON empresa_forma_envio_rel.idEnvio = empresa_formaenvio.idEnvio
    WHERE 
        regimetributario.tipoRegime = 'Lucro Real' AND 
        declaracao.departamento = 'Fiscal'  -- Filtrando apenas declarações do departamento fiscal
    GROUP BY 
        empresa.idEmpresa, declaracao.idDeclaracao, mes.idMes, mes.mes, mes.ano
";

$result = $mysqli->query($sql);

if ($result === false) {
    echo json_encode(["error" => "Erro na consulta SQL: " . $mysqli->error]);
    exit();
}

$data = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = [
            "idEmpresa" => $row["idEmpresa"],
            "razaoSocial" => $row["razaoSocial"],
            "responsavelFiscal" => $row["responsavelFiscal"],
            "formaDeFechamento" => $row["formaDeFechamento"],
            "idDeclaracao" => $row["idDeclaracao"],
            "nomeDeclaracao" => $row["nomeDeclaracao"],
            "idMes" => $row["idMes"],    /* Adiciona idMes ao array de dados */
            "mes" => $row["mes"],
            "ano" => $row["ano"],
            "entregue" => $row["entregue"] ? true : false,
            "nomeEstado" => $row["nomeEstado"],
            "formaEnvio" => $row["formaEnvio"]
        ];
    }
} else {
    $data = ["message" => "Nenhum dado encontrado"];
}

$mysqli->close();

echo json_encode($data);
?>
