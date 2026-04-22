<?php
    echo "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='refresh' content='5;url=../dashboard.php'>
    <title>SRMV — Multa Cadastrada</title>
    <link href='https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@400;500&display=swap' rel='stylesheet'>
    <style>
        :root { --bg: #0a0c0f; --surface: #111318; --border: #1e2330; --accent: #1a6fff; --success: #27ae60; --text: #e2e6ef; --muted: #5a6478; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'IBM Plex Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: var(--surface); border: 1px solid var(--border); padding: 48px 40px; text-align: center; max-width: 420px; width: 100%; position: relative; }
        .card::before, .card::after { content: ''; position: absolute; width: 20px; height: 20px; border-color: var(--success); border-style: solid; }
        .card::before { top: -1px; left: -1px; border-width: 2px 0 0 2px; }
        .card::after  { bottom: -1px; right: -1px; border-width: 0 2px 2px 0; }
        .icon { width: 56px; height: 56px; border: 2px solid var(--success); display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; }
        .icon svg { width: 26px; height: 26px; fill: var(--success); }
        .tag { font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 3px; color: var(--success); text-transform: uppercase; margin-bottom: 10px; }
        h1 { font-family: 'Bebas Neue', sans-serif; font-size: 32px; letter-spacing: 2px; margin-bottom: 12px; }
        p  { font-size: 13px; color: var(--muted); line-height: 1.6; margin-bottom: 28px; }
        .progress-bar { height: 2px; background: var(--border); width: 100%; margin-bottom: 16px; }
        .progress-fill { height: 100%; background: var(--success); width: 0%; animation: fill 3s linear forwards; }
        @keyframes fill { to { width: 100%; } }
        .redirect-msg { font-family: 'IBM Plex Mono', monospace; font-size: 10px; letter-spacing: 1px; color: var(--muted); text-transform: uppercase; }
        a { color: var(--accent); font-family: 'IBM Plex Mono', monospace; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; text-decoration: none; display: inline-block; margin-top: 16px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class='card'>
        <div class='icon'>
            <svg viewBox='0 0 24 24'><path d='M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z'/></svg>
        </div>
        <div class='tag'>// Registro Confirmado</div>
        <h1>Multa Cadastrada</h1>
        <p>A multa foi registrada com sucesso no sistema.<br>Redirecionando para o painel...</p>
        <div class='progress-bar'><div class='progress-fill'></div></div>
        <div class='redirect-msg'>Redirecionando em 5 segundos</div>
        <a href='../dashboard.php'>Ir agora →</a>
    </div>
</body>
</html>
";