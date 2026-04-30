<?php

require_once __DIR__ . '/../auth/verificar_login.php';
require_once __DIR__ . '/../config/conexao.php';

$conexao = Conexao::getConexao();

// — filtros —
$where  = [];
$params = [];
$types  = "";

if (!empty($_GET['nome'])) {
    $where[]  = "nome LIKE ?";
    $params[] = "%" . $_GET['nome'] . "%";
    $types   .= "s";
}
if (!empty($_GET['cpf_cnpj'])) {
    $where[]  = "cpf_cnpj LIKE ?";
    $params[] = "%" . preg_replace('/[^0-9]/', '', $_GET['cpf_cnpj']) . "%";
    $types   .= "s";
}
if (!empty($_GET['num_cnh'])) {
    $where[]  = "num_cnh LIKE ?";
    $params[] = "%" . $_GET['num_cnh'] . "%";
    $types   .= "s";
}
if (!empty($_GET['pontos_de'])) {
    $where[]  = "pontos_cnh >= ?";
    $params[] = (int) $_GET['pontos_de'];
    $types   .= "i";
}
if (!empty($_GET['pontos_ate'])) {
    $where[]  = "pontos_cnh <= ?";
    $params[] = (int) $_GET['pontos_ate'];
    $types   .= "i";
}
if (!empty($_GET['validade_de'])) {
    $where[]  = "validade_cnh >= ?";
    $params[] = $_GET['validade_de'];
    $types   .= "s";
}
if (!empty($_GET['validade_ate'])) {
    $where[]  = "validade_cnh <= ?";
    $params[] = $_GET['validade_ate'];
    $types   .= "s";
}

$sql = "SELECT id, nome, email, cpf_cnpj, num_cnh, pontos_cnh, data_nascimento, validade_cnh FROM motoristas";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY nome ASC";

$stmt = $conexao->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$motoristas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$total        = count($motoristas);
$cnh_vencidas = count(array_filter($motoristas, fn($m) => !empty($m['validade_cnh']) && strtotime($m['validade_cnh']) < time()));
$pontos_altos = count(array_filter($motoristas, fn($m) => $m['pontos_cnh'] >= 15));
