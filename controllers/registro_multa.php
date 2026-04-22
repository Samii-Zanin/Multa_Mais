<?php

require_once __DIR__ . '/../auth/verificar_login.php';
require_once __DIR__ . '/../models/motorista.php';
require_once __DIR__ . '/../models/carro.php';
require_once __DIR__ . '/../models/multa.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_motorista = Motorista::getIdByCpfOrCnh($_POST['cpf_cnh']);
    if ($id_motorista === null) {
        $erro_motorista = "Motorista não encontrado. Verifique o CPF/CNPJ e CNH.";
        header("Location: ../views/errors/erroMotorista.php?erro=" . urlencode($erro_motorista));
        exit();
    }
    $id_veiculo      = Carro::getIdByPlaca($_POST['placa_veiculo']);
    if ($id_veiculo === null) {
        $erro_veiculo = "Veículo não encontrado. Verifique a placa.";
        header("Location: ../views/errors/erroVeiculo.php?erro=" . urlencode($erro_veiculo));
        exit();
    }

    $id_multante    = $_SESSION['policial_id'];

    $valor_multa = (float) $_POST['valor_multa'];
    $tipo_infracao     = $_POST['tipo_infracao'];
    $descricao     = $_POST['descricao'];
    $uf     = $_POST['uf'];
    $endereco     = $_POST['endereco'];

    
    
    $multa = new Multa($id_motorista, $id_veiculo, $id_multante, $valor_multa, $tipo_infracao, $descricao, $uf, $endereco);
    $resultado = $multa->save();

    if ($resultado === true) {
        header("Location: ../views/sucess/sucessMulta.php");
    }
    else {
        $erro_multa = $resultado;
        header("Location: ../views/errors/erroMulta.php?erro=" . urlencode($erro_multa));
    }
    exit();
}