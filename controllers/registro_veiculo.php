<?php

require_once __DIR__ . '/../auth/verificar_login.php';
require_once __DIR__ . '/../models/motorista.php';
require_once __DIR__ . '/../models/carro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cpf_cnpj   = preg_replace('/[^0-9]/', '', $_POST['cpf_cnh']);
    $modelo       = $_POST['modelo'];
    $marca      = $_POST['marca'];
    $placa    = $_POST['placa'];
    $ano = (int) $_POST['ano'];
    $motorista_id = Motorista::getIdByCpfOrCnh($_POST['cpf_cnh']);
     if ($motorista_id === null) {
        $erro_motorista = "Motorista não encontrado. Verifique o CPF/CNPJ e CNH.";
        header("Location: ../views/errors/erroMotorista.php?erro=" . urlencode($erro_motorista));
        exit();
    }

    $carro = new Carro($modelo, $marca, $placa, $ano, $motorista_id);
    $resultado = $carro->save();
    var_dump($resultado);
    die();

    if ($resultado === true) {
        header("Location: ../views/sucess/sucessVeiculo.php");
    }
    else {
        $erro_veiculo = $resultado;
        header("Location: ../views/errors/erroVeiculo.php?erro=" . urlencode($erro_veiculo));
    }
    exit();
}