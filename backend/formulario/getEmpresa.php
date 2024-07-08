<?php
require_once('../conexao.php');
require_once('../cors.php');


if (isset($_GET['idEmpresa'])) {
  
    $idEmpresa = intval($_GET['idEmpresa']);
    
   
    $sql = "SELECT * FROM empresa WHERE idEmpresa = $idEmpresa";
    $result = $mysqli->query($sql);

 
    if ($result && $result->num_rows > 0) {
        $empresa = $result->fetch_assoc();
        echo json_encode($empresa);
    } else {
        echo json_encode(['success' => false, 'message' => 'Empresa não encontrada']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID da empresa não fornecido']);
}
?>
