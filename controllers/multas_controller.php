<?php

require_once __DIR__ . '/../auth/verificar_login.php';
require_once __DIR__ . '/../config/conexao.php';

$conexao = Conexao::getConexao();

$where  = [];
$params = [];
$types  = "";

if (!empty($_GET['uf'])) {
    $where[]  = "m.uf = ?";
    $params[] = $_GET['uf'];
    $types   .= "s";
}
if (!empty($_GET['status'])) {
    $where[]  = "m.status = ?";
    $params[] = $_GET['status'];
    $types   .= "s";
}
if (!empty($_GET['tipo_infracao'])) {
    $where[]  = "m.tipo_infracao LIKE ?";
    $params[] = "%" . $_GET['tipo_infracao'] . "%";
    $types   .= "s";
}
if (!empty($_GET['motorista'])) {
    $where[]  = "mo.nome LIKE ?";
    $params[] = "%" . $_GET['motorista'] . "%";
    $types   .= "s";
}
if (!empty($_GET['policial'])) {
    $where[]  = "p.nome LIKE ?";
    $params[] = "%" . $_GET['policial'] . "%";
    $types   .= "s";
}
if (!empty($_GET['data_de'])) {
    $where[]  = "m.data >= ?";
    $params[] = $_GET['data_de'];
    $types   .= "s";
}
if (!empty($_GET['data_ate'])) {
    $where[]  = "m.data <= ?";
    $params[] = $_GET['data_ate'];
    $types   .= "s";
}
$sql = "
    SELECT
        m.id, m.valor, m.tipo_infracao, m.descricao,
        m.uf, m.endereco, m.status, m.data, m.data_vencimento,
        mo.nome  AS motorista_nome,
        mo.cpf_cnpj,
        p.nome   AS policial_nome,
        c.modelo AS carro_modelo,
        c.placa  AS carro_placa
    FROM multa m
    LEFT JOIN motoristas mo ON mo.id = m.id_motorista
    LEFT JOIN policial   p  ON p.id  = m.id_policial
    LEFT JOIN carros     c  ON c.id  = m.id_carro
";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY m.data DESC";

$stmt = $conexao->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$multas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS',
        'MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];

$total       = count($multas);
$aguardando  = count(array_filter($multas, fn($m) => $m['status'] === 'Aguardando pagamento'));
$pagas       = count(array_filter($multas, fn($m) => $m['status'] === 'paga'));
$vencidas    = count(array_filter($multas, fn($m) => $m['status'] === 'vencida'));
$contestadas = count(array_filter($multas, fn($m) => $m['status'] === 'contestada'));