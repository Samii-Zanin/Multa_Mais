<?php

require_once __DIR__ . '/../auth/verificar_login.php';
require_once __DIR__ . '/../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/motoristas.php");
    exit();
}

$id           = (int) $_POST['id'];
$email        = trim($_POST['email']);
$validade_cnh = trim($_POST['validade_cnh']);

if (!$id || !$email || !$validade_cnh) {
    $erro = "Todos os campos são obrigatórios.";
    header("Location: ../views/motoristas.php?erro=" . urlencode($erro));
    exit();
}

$conexao = Conexao::getConexao();

$stmt = $conexao->prepare("
    UPDATE motoristas SET email = ?, validade_cnh = ? WHERE id = ?
");
$stmt->bind_param("ssi", $email, $validade_cnh, $id);

if ($stmt->execute()) {
    header("Location: ../views/motoristas.php?sucesso=1");
} else {
    $erro = "Erro ao atualizar motorista.";
    header("Location: ../views/motoristas.php?erro=" . urlencode($erro));
}

$stmt->close();
exit();
