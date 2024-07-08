<?php
require_once('../conexao.php');
require_once('../cors.php');


function sanitize_input($data) {
    global $mysqli;
    return $mysqli->real_escape_string(trim($data));
}


if (isset($_POST['idEmpresa'])) {
    $idEmpresa = sanitize_input($_POST['idEmpresa']);
    $razaoSocial = sanitize_input($_POST['razaoSocial']);
    $cnpj = sanitize_input($_POST['cnpj']);
    $inscricaoEstadual = sanitize_input($_POST['inscricaoEstadual']);
    $telefone = sanitize_input($_POST['telefone']);
    $idEstado = sanitize_input($_POST['idEstado']);
    $possuiFuncionarios = isset($_POST['possuiFuncionarios']) ? sanitize_input($_POST['possuiFuncionarios']) : 0;
    $possuiServicos = isset($_POST['possuiServicos']) ? sanitize_input($_POST['possuiServicos']) : 0;
    $idRegimeTributario = sanitize_input($_POST['idRegimeTributario']);
    $responsavelFiscal = sanitize_input($_POST['responsavelFiscal']);
    $responsavelDp = sanitize_input($_POST['ResponsavelDp']);
    $certificadoEmitido = isset($_POST['certificadoEmitido']) ? sanitize_input($_POST['certificadoEmitido']) : 0;
    $processoAberturaAlteracao = sanitize_input($_POST['processoAberturaAlteracao']);
    $status = sanitize_input($_POST['status']);
    $formaDeFechamento = sanitize_input($_POST['formaDeFechamento']);

    $sql = "UPDATE empresa SET 
                razaoSocial='$razaoSocial', 
                cnpj='$cnpj', 
                inscricaoEstadual='$inscricaoEstadual', 
                telefone='$telefone', 
                idEstado=$idEstado, 
                possuiFuncionarios=$possuiFuncionarios, 
                possuiServicos=$possuiServicos, 
                idRegimeTributario=$idRegimeTributario, 
                responsavelFiscal='$responsavelFiscal', 
                responsavelDp='$responsavelDp', 
                certificadoEmitido=$certificadoEmitido, 
                processoAberturaAlteracao='$processoAberturaAlteracao', 
                status='$status', 
                formaDeFechamento='$formaDeFechamento'
            WHERE idEmpresa=$idEmpresa";

    if ($mysqli->query($sql)) {
        $sqlDelete = "DELETE FROM empresa_forma_envio_rel WHERE idEmpresa = $idEmpresa";
        if ($mysqli->query($sqlDelete)) {
            $formaEnvio = isset($_POST['formaEnvio']) ? $_POST['formaEnvio'] : [];
            foreach ($formaEnvio as $envio) {
                $envio = sanitize_input($envio);
                $sqlInsert = "INSERT INTO empresa_forma_envio_rel (idEmpresa, idEnvio) VALUES ($idEmpresa, $envio)";
                $mysqli->query($sqlInsert);
            }
            echo json_encode(['success' => true, 'message' => 'Empresa atualizada com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao atualizar as formas de envio']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar a empresa']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID da empresa não fornecido']);
}
?>
