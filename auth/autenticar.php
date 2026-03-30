<?php

session_start();

require_once __DIR__ . '/../models/policial.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$policial_id = Policial::login($email, $senha);

if ($policial_id) {

    $policial = Policial::getPolicialById($policial_id);

    $_SESSION['policial_id']   = $policial_id;
    $_SESSION['policial_nome'] = $policial->getNome();

    header("Location: ../views/dashboard.php");
    exit;

} else {
    header("Location: ../auth/login.php?erro=1");
    exit;
}