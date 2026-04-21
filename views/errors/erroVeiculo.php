<?php
$erro_veiculo = isset($_GET['erro']) ? htmlspecialchars($_GET['erro']) : 'Erro desconhecido.';
echo "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='refresh' content='10;url=../../views/dashboard.php?modal=veiculo'>
    <title>SRMV — Erro ao Cadastrar</title>
    <link href='https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@400;500&display=swap' rel='stylesheet'>
    <style>
        :root { --bg: #0a0c0f; --surface: #111318; --border: #1e2330; --accent: #1a6fff; --danger: #c0392b; --text: #e2e6ef; --muted: #5a6478; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'IBM Plex Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: var(--surface); border: 1px solid var(--border); padding: 48px 40px; text-align: center; max-width: 420px; width: 100%; position: relative; }
        .card::before, .card::after { content: ''; position: absolute; width: 20px; height: 20px; border-color: var(--danger); border-style: solid; }
        .card::before { top: -1px; left: -1px; border-width: 2px 0 0 2px; }
        .card::after  { bottom: -1px; right: -1px; border-width: 0 2px 2px 0; }
        .icon { width: 56px; height: 56px; border: 2px solid var(--danger); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
        .icon svg { width: 26px; height: 26px; fill: var(--danger); }
        .tag { font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 3px; color: var(--danger); text-transform: uppercase; margin-bottom: 10px; }
        h1 { font-family: 'Bebas Neue', sans-serif; font-size: 32px; letter-spacing: 2px; margin-bottom: 12px; }
        p  { font-size: 13px; color: var(--muted); line-height: 1.6; margin-bottom: 28px; }
        .progress-bar { height: 2px; background: var(--border); width: 100%; margin-bottom: 16px; }
        .progress-fill { height: 100%; background: var(--danger); width: 0%; animation: fill 10s linear forwards; }
        @keyframes fill { to { width: 100%; } }
        .redirect-msg { font-family: 'IBM Plex Mono', monospace; font-size: 10px; letter-spacing: 1px; color: var(--muted); text-transform: uppercase; }
        a { color: var(--accent); font-family: 'IBM Plex Mono', monospace; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-block; margin-top: 16px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class='card'>
        <div class='icon'>
            <svg viewBox='0 0 24 24'><path d='M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z'/></svg>
        </div>
        <div class='tag'>// Falha no Registro</div>
        <h1>Erro ao Cadastrar</h1>
        <p>Não foi possível registrar o veículo.<br>Verifique os dados e tente novamente.</p>
        <p class='erro-detalhe'>Erro: " . $erro_veiculo . "</p>
        <div class='progress-bar'><div class='progress-fill'></div></div>
        <div class='redirect-msg'>Retornando em 10 segundos</div>
        <a href='../dashboard.php?modal=veiculo'>← Voltar agora</a>
    </div>
</body>
</html>"
;
