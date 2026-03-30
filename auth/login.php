<?php
session_start();

if (isset($_SESSION['policial_id'])) {
    header("Location: ../views/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRMV — Acesso ao Sistema</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css">

</head>
<body>
    <div class="wrapper">
        <div class="sys-header">
            <div class="badge">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.11V11c0 4.52-3.13 8.75-7 9.93-3.87-1.18-7-5.41-7-9.93V6.29l7-3.11zM11 7v6h2V7h-2zm0 8v2h2v-2h-2z"/>
                </svg>
            </div>
            <div class="sys-title">
                <span class="acronym">SRMV</span>
                <span class="full-name">Sistema de Registro e Monitoramento de Violações</span>
            </div>
        </div>

        <div class="divider">
            <span>Acesso Restrito</span>
        </div>

        <div class="card">
            <p class="card-title">// Autenticação de Agente</p>

            <form method="POST" action="autenticar.php">
                <div class="field">
                    <label for="email">Identificação — E-mail</label>
                    <input type="email" id="email" name="email" placeholder="agente@policia.gov.br" required>
                </div>

                <div class="field">
                    <label for="senha">Credencial — Senha</label>
                    <input type="password" id="senha" name="senha" placeholder="••••••••••••" required>
                </div>

                <button type="submit" class="btn-primary">Autenticar Acesso</button>
            </form>

            <div class="link-row">
                <span>Novo agente?</span>
                <a href="registro.php">Solicitar Registro →</a>
            </div>
        </div>
    </div>
</body>
</html>
