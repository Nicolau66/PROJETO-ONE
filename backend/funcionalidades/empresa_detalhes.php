<?php
require_once('../conexao.php');
require_once('../cors.php');


if (!isset($_GET['idEmpresa'])) {
    echo json_encode(["error" => "idEmpresa não fornecido"]);
    exit();
}

$idEmpresa = intval($_GET['idEmpresa']);


error_log("idEmpresa recebido: " . $idEmpresa);


$sql = "SELECT 
            empresa.razaoSocial,
            empresa.cnpj,
            empresa.inscricaoEstadual,
            empresa.telefone,
            estado.nomeEstado AS nomeEstado,
            regimetributario.tipoRegime AS tipoRegimeTributario,
            empresa.possuiFuncionarios,
            empresa.responsavelFiscal,
            empresa.ResponsavelDp,
            empresa.certificadoEmitido,
            empresa.processoAberturaAlteracao,
            empresa.status,
            GROUP_CONCAT(empresa_formaenvio.formaEnvio SEPARATOR ', ') AS formaEnvio,
            empresa.formaDeFechamento
        FROM 
            empresa
        LEFT JOIN 
            estado ON empresa.idEstado = estado.idEstado
        LEFT JOIN 
            regimetributario ON empresa.idRegimeTributario = regimetributario.idRegimeTributario
        LEFT JOIN 
            empresa_forma_envio_rel ON empresa.idEmpresa = empresa_forma_envio_rel.idEmpresa
        LEFT JOIN 
            empresa_formaenvio ON empresa_forma_envio_rel.idEnvio = empresa_formaenvio.idEnvio
        WHERE 
            empresa.idEmpresa = $idEmpresa
        GROUP BY 
            empresa.idEmpresa";


error_log("Consulta SQL: " . $sql);

$result = $mysqli->query($sql);

if ($result === false) {
    
    error_log("Erro na consulta SQL: " . $mysqli->error);
    echo json_encode(["error" => "Erro na consulta SQL: " . $mysqli->error]);
    exit();
}

$empresa = $result->fetch_assoc();

if (!$empresa) {
    echo json_encode(["error" => "Empresa não encontrada"]);
    exit();
}


error_log("Dados da empresa: " . print_r($empresa, true));

echo json_encode($empresa);
?>
