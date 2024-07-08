<?php
require_once('../conexao.php');
require_once('../cors.php');


$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$inscricaoEstadual = $_POST['inscricaoEstadual'];
$telefone = $_POST['telefone'];
$idEstado = $_POST['idEstado'];
$possuiFuncionarios = isset($_POST['possuiFuncionarios']) ? 1 : 0; 
$possuiServicos = isset($_POST['possuiServicos']) ? 1 : 0; 
$idRegimeTributario = $_POST['idRegimeTributario'];
$responsavelFiscal = $_POST['responsavelFiscal'];
$responsavelDp = $_POST['ResponsavelDp'];
$certificadoEmitido = isset($_POST['certificadoEmitido']) ? 1 : 0;
$processoAberturaAlteracao = $_POST['processoAberturaAlteracao'];
$status = $_POST['status'];
$declaracoes = $_POST['declaracoes'];
$impostos = $_POST['impostos'];
$mes = $_POST['mes'];
$formaDeFechamento = $_POST['formaDeFechamento']; 


if (isset($_POST['formaEnvio']) && is_array($_POST['formaEnvio'])) {
    $formaEnvio = $_POST['formaEnvio'];
    $formaEnvioStr = implode(',', $formaEnvio);
} else {
    $formaEnvioStr = ''; 
}


$sql_empresa = "INSERT INTO empresa (razaoSocial, cnpj, inscricaoEstadual, telefone, idEstado, idRegimeTributario, possuiFuncionarios, possuiServicos, responsavelFiscal, ResponsavelDp, certificadoEmitido, processoAberturaAlteracao, status, formaEnvio, formaDeFechamento) VALUES ('$razaoSocial', '$cnpj', '$inscricaoEstadual', '$telefone', $idEstado, $idRegimeTributario, $possuiFuncionarios, $possuiServicos, '$responsavelFiscal', '$responsavelDp', $certificadoEmitido, '$processoAberturaAlteracao', '$status', '$formaEnvioStr', '$formaDeFechamento')";
$success = $mysqli->query($sql_empresa);

if ($success) {
    $idEmpresa = $mysqli->insert_id;

    foreach ($declaracoes as $idDeclaracao) {
        $sql_declaracao = "INSERT INTO empresa_declaracao (idEmpresa, idDeclaracao) VALUES ($idEmpresa, $idDeclaracao)";
        $mysqli->query($sql_declaracao);

        
        $sql_entrega_declaracao = "INSERT INTO entregadeclaracao (idEmpresa, idDeclaracao, idMes, entregue) VALUES ($idEmpresa, $idDeclaracao, $mes, 0)";
        $mysqli->query($sql_entrega_declaracao);
    }

    foreach ($impostos as $idImposto) {
        $sql_imposto = "INSERT INTO empresa_imposto (idEmpresa, idImposto) VALUES ($idEmpresa, $idImposto)";
        $mysqli->query($sql_imposto);

        
        $sql_entrega_imposto = "INSERT INTO entregaimposto (idEmpresa, idImposto, idMes, entregue) VALUES ($idEmpresa, $idImposto, $mes, 0)";
        $mysqli->query($sql_entrega_imposto);
    }

   
    if (!empty($formaEnvio)) {
        foreach ($formaEnvio as $idEnvio) {
            $sql_forma_envio_rel = "INSERT INTO empresa_forma_envio_rel (idEmpresa, idEnvio) VALUES ($idEmpresa, $idEnvio)";
            $mysqli->query($sql_forma_envio_rel);
        }
    }

    // Associar mês à empresa
    $sql_empresa_mes = "INSERT INTO empresa_mes (idEmpresa, idMes) VALUES ($idEmpresa, $mes)";
    $mysqli->query($sql_empresa_mes);

    $message = "Dados inseridos com sucesso!";
} else {
    $message = "Erro ao inserir dados: " . $mysqli->error;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Bem-Sucedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: <?php echo $success ? '#4CAF50' : '#F44336'; ?>;
            margin-bottom: 16px;
        }
        p {
            color: #333333;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: <?php echo $success ? '#4CAF50' : '#F44336'; ?>;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: <?php echo $success ? '#45a049' : '#D32F2F'; ?>;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $success ? 'Cadastro Bem-Sucedido!' : 'Erro no Cadastro'; ?></h1>
        <p><?php echo $message; ?></p>
        <button onclick="window.history.back()" class="btn">Voltar</button>
    </div>
</body>
</html>
