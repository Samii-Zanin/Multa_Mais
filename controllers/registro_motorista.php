<?php

require_once __DIR__ . '/../auth/verificar_login.php';
require_once __DIR__ . '/../models/motorista.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cpf_cnpj   = preg_replace('/[^0-9]/', '', $_POST['cpf_cnpj']);
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $num_cnh    = $_POST['num_cnh'];
    $pontos_cnh = (int) $_POST['pontos_cnh'];
    $data_nascimento     = $_POST['data_nascimento'];
    $validade_cnh     = $_POST['validade_cnh'];

    $motorista = new Motorista($cpf_cnpj, $name, $email, $num_cnh, $pontos_cnh, $data_nascimento, $validade_cnh);
    $resultado = $motorista->save();

     if ($resultado === true) {
        header("Location: ../views/sucess/sucessMotorista.php");
    }
    else {
        $erro_motorista = $resultado;
        header("Location: ../views/errors/erroMotorista.php?erro=" . urlencode($erro_motorista));
    }
    exit();
}