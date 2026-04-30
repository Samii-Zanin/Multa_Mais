<?php
require_once __DIR__ . '/../controllers/motoristas_controller.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRMV — Motoristas</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        #0a0c0f;
            --surface:   #111318;
            --surface-2: #161a23;
            --border:    #1e2330;
            --accent:    #1a6fff;
            --accent-dim:#0f4ab5;
            --danger:    #c0392b;
            --success:   #27ae60;
            --warning:   #e67e22;
            --text:      #e2e6ef;
            --muted:     #5a6478;
            --scan:      rgba(26,111,255,0.025);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'IBM Plex Sans', sans-serif;
            background: var(--bg); color: var(--text);
            min-height: 100vh; display: flex; flex-direction: column;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: repeating-linear-gradient(0deg, transparent, transparent 2px, var(--scan) 2px, var(--scan) 4px);
            pointer-events: none; z-index: 0;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: var(--surface); border-bottom: 1px solid var(--border);
            display: flex; align-items: center; padding: 0 32px; height: 60px; gap: 16px;
        }
        .topbar-logo { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .topbar-logo .badge { width: 32px; height: 32px; border: 1.5px solid var(--accent); display: flex; align-items: center; justify-content: center; }
        .topbar-logo .badge svg { width: 16px; height: 16px; fill: var(--accent); }
        .topbar-logo .acronym { font-family: 'Bebas Neue', sans-serif; font-size: 20px; letter-spacing: 3px; }
        .topbar-sep { width: 1px; height: 28px; background: var(--border); }
        .topbar-breadcrumb { font-family: 'IBM Plex Mono', monospace; font-size: 10px; letter-spacing: 1.5px; color: var(--muted); text-transform: uppercase; }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 20px; }
        .agent-info .agent-name { font-size: 13px; font-weight: 500; }
        .agent-info .agent-role { font-family: 'IBM Plex Mono', monospace; font-size: 9px; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; }
        .logout-btn { background: transparent; border: 1px solid var(--border); color: var(--muted); font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 2px; text-transform: uppercase; padding: 7px 14px; cursor: pointer; text-decoration: none; display: inline-block; transition: border-color 0.2s, color 0.2s; }
        .logout-btn:hover { border-color: var(--danger); color: #e07070; }

        /* ── LAYOUT ── */
        .layout { display: grid; grid-template-columns: 220px 1fr; flex: 1; position: relative; z-index: 1; }

        /* ── SIDEBAR NAV ── */
        .sidebar-nav { background: var(--surface); border-right: 1px solid var(--border); padding: 28px 0; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
        .nav-section-label { font-family: 'IBM Plex Mono', monospace; font-size: 8px; letter-spacing: 2.5px; color: var(--muted); text-transform: uppercase; padding: 0 20px 10px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 20px; font-size: 13px; color: var(--muted); text-decoration: none; border-left: 2px solid transparent; transition: color 0.15s, background 0.15s, border-color 0.15s; }
        .nav-item svg { width: 15px; height: 15px; fill: currentColor; flex-shrink: 0; }
        .nav-item:hover { color: var(--text); background: var(--surface-2); }
        .nav-item.active { color: var(--accent); border-left-color: var(--accent); background: rgba(26,111,255,0.06); }

        /* ── CONTENT AREA ── */
        .content-area { display: grid; grid-template-columns: 260px 1fr; min-height: calc(100vh - 60px); }

        /* ── FILTER SIDEBAR ── */
        .filter-sidebar { background: var(--surface); border-right: 1px solid var(--border); padding: 28px 20px; position: sticky; top: 60px; height: calc(100vh - 60px); overflow-y: auto; }
        .filter-title { font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 3px; color: var(--accent); text-transform: uppercase; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; }
        .filter-title svg { width: 12px; height: 12px; fill: var(--accent); }
        .filter-group { margin-bottom: 16px; }
        .filter-group label { display: block; font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 2px; color: var(--muted); text-transform: uppercase; margin-bottom: 7px; }
        .filter-group input { width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); font-family: 'IBM Plex Mono', monospace; font-size: 12px; padding: 9px 11px; outline: none; transition: border-color 0.2s; border-radius: 0; }
        .filter-group input:focus { border-color: var(--accent); }
        .filter-group input::placeholder { color: var(--muted); }
        .filter-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .filter-sep { height: 1px; background: var(--border); margin: 16px 0; }
        .btn-filter { width: 100%; background: var(--accent); border: none; color: #fff; font-family: 'IBM Plex Mono', monospace; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; padding: 11px; cursor: pointer; transition: background 0.2s; margin-bottom: 8px; }
        .btn-filter:hover { background: var(--accent-dim); }
        .btn-clear { width: 100%; background: transparent; border: 1px solid var(--border); color: var(--muted); font-family: 'IBM Plex Mono', monospace; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; padding: 10px; cursor: pointer; text-decoration: none; display: block; text-align: center; transition: border-color 0.2s, color 0.2s; }
        .btn-clear:hover { border-color: var(--danger); color: #e07070; }

        /* ── MAIN ── */
        .main { padding: 32px; overflow-x: auto; animation: fadeUp 0.4s ease both; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .page-header { margin-bottom: 28px; }
        .page-header .label { font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 3px; color: var(--accent); text-transform: uppercase; margin-bottom: 6px; }
        .page-header h1 { font-family: 'Bebas Neue', sans-serif; font-size: 36px; letter-spacing: 2px; line-height: 1; }
        .page-header .sub { font-size: 12px; color: var(--muted); margin-top: 6px; }

        /* ── FLASH ── */
        .flash { display: flex; align-items: center; gap: 10px; padding: 12px 16px; margin-bottom: 20px; font-family: 'IBM Plex Mono', monospace; font-size: 11px; letter-spacing: 0.5px; }
        .flash.sucesso { background: rgba(39,174,96,0.08); border: 1px solid rgba(39,174,96,0.3); color: #5dba7d; }
        .flash.erro    { background: rgba(192,57,43,0.08); border: 1px solid rgba(192,57,43,0.3); color: #e07070; }
        .flash svg { width: 14px; height: 14px; fill: currentColor; flex-shrink: 0; }

        /* ── STATS ── */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 24px; }
        .stat-mini { background: var(--surface); border: 1px solid var(--border); padding: 14px 16px; display: flex; align-items: center; gap: 12px; }
        .stat-mini .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .stat-mini .info .val { font-family: 'Bebas Neue', sans-serif; font-size: 24px; line-height: 1; }
        .stat-mini .info .lbl { font-family: 'IBM Plex Mono', monospace; font-size: 8px; letter-spacing: 1.5px; color: var(--muted); text-transform: uppercase; }

        /* ── TABLE ── */
        .table-wrap { background: var(--surface); border: 1px solid var(--border); overflow-x: auto; }
        .table-head-bar { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); }
        .table-head-bar .ttl { font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 2px; color: var(--muted); text-transform: uppercase; }
        .table-head-bar .count { font-family: 'IBM Plex Mono', monospace; font-size: 10px; color: var(--accent); }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        thead tr { border-bottom: 1px solid var(--border); }
        thead th { font-family: 'IBM Plex Mono', monospace; font-size: 8px; letter-spacing: 2px; color: var(--muted); text-transform: uppercase; padding: 12px 16px; text-align: left; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid var(--border); transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--surface-2); }
        tbody td { padding: 13px 16px; font-size: 13px; vertical-align: middle; }
        .td-mono { font-family: 'IBM Plex Mono', monospace; font-size: 11px; color: var(--muted); }
        .td-bold { font-weight: 500; }

        .cnh-badge {
            display: inline-block; font-family: 'IBM Plex Mono', monospace;
            font-size: 8px; letter-spacing: 1px; text-transform: uppercase;
            padding: 3px 9px; border: 1px solid;
        }
        .cnh-badge.valida   { color: #5dba7d; border-color: rgba(39,174,96,0.4);  background: rgba(39,174,96,0.08); }
        .cnh-badge.vencida  { color: #e07070; border-color: rgba(192,57,43,0.4);  background: rgba(192,57,43,0.08); }
        .cnh-badge.alerta   { color: #f0a76b; border-color: rgba(230,126,34,0.4); background: rgba(230,126,34,0.08); }

        .btn-edit { background: transparent; border: 1px solid var(--border); color: var(--muted); font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 1px; text-transform: uppercase; padding: 5px 10px; cursor: pointer; transition: border-color 0.2s, color 0.2s; white-space: nowrap; }
        .btn-edit:hover { border-color: var(--accent); color: var(--accent); }

        .empty-row td { text-align: center; padding: 48px; font-family: 'IBM Plex Mono', monospace; font-size: 11px; color: var(--muted); letter-spacing: 1px; }

        /* ── MODAL ── */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 200; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
        .modal-overlay.aberto { display: flex; }
        .modal { background: var(--surface); border: 1px solid var(--border); padding: 32px; width: 100%; max-width: 460px; position: relative; animation: fadeUp 0.25s ease; }
        .modal::before, .modal::after { content: ''; position: absolute; width: 16px; height: 16px; border-color: var(--accent); border-style: solid; }
        .modal::before { top: -1px; left: -1px; border-width: 2px 0 0 2px; }
        .modal::after  { bottom: -1px; right: -1px; border-width: 0 2px 2px 0; }
        .modal-head { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 24px; }
        .modal-tag { font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 3px; color: var(--accent); text-transform: uppercase; margin-bottom: 4px; }
        .modal-title { font-family: 'Bebas Neue', sans-serif; font-size: 26px; letter-spacing: 2px; }
        .modal-close { background: none; border: 1px solid var(--border); color: var(--muted); font-size: 14px; width: 32px; height: 32px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: border-color 0.2s, color 0.2s; }
        .modal-close:hover { border-color: var(--danger); color: #e07070; }

        .modal-info { background: var(--bg); border: 1px solid var(--border); padding: 12px 14px; margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .modal-info .mi-item .mi-label { font-family: 'IBM Plex Mono', monospace; font-size: 8px; letter-spacing: 1.5px; color: var(--muted); text-transform: uppercase; }
        .modal-info .mi-item .mi-val   { font-size: 13px; font-weight: 500; margin-top: 2px; }

        .field { margin-bottom: 16px; }
        .field label { display: block; font-family: 'IBM Plex Mono', monospace; font-size: 9px; letter-spacing: 2px; color: var(--muted); text-transform: uppercase; margin-bottom: 7px; }
        .field input { width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); font-family: 'IBM Plex Mono', monospace; font-size: 13px; padding: 11px 13px; outline: none; transition: border-color 0.2s; border-radius: 0; }
        .field input:focus { border-color: var(--accent); }

        .btn-primary { width: 100%; background: var(--accent); border: none; color: #fff; font-family: 'IBM Plex Mono', monospace; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; padding: 13px; cursor: pointer; transition: background 0.2s; margin-top: 4px; }
        .btn-primary:hover { background: var(--accent-dim); }
    </style>
</head>
<body>

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-logo">
            <div class="badge"><svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg></div>
            <span class="acronym">SRMV</span>
        </div>
        <div class="topbar-sep"></div>
        <span class="topbar-breadcrumb">Motoristas</span>
        <div class="topbar-right">
            <div class="agent-info">
                <div class="agent-name"><?php echo htmlspecialchars($_SESSION['policial_nome'] ?? 'Agente'); ?></div>
                <div class="agent-role">Agente Autenticado</div>
            </div>
            <a href="../auth/logout.php" class="logout-btn">Encerrar Sessão</a>
        </div>
    </div>

    <div class="layout">

        <!-- SIDEBAR NAV -->
        <aside class="sidebar-nav">
            <div class="nav-section-label">Navegação</div>
            <a class="nav-item" href="dashboard.php">
                <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Painel
            </a>
            
            <a class="nav-item active" href="motoristas.php">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>Motoristas
            </a>
            <a class="nav-item" href="#">
                <svg viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"/></svg>Veículos
            </a>
            <a class="nav-item" href="viewMultas.php">
                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>Histórico de Multas
            </a>
        </aside>

        <div class="content-area">

            <!-- FILTER SIDEBAR -->
            <aside class="filter-sidebar">
                <div class="filter-title">
                    <svg viewBox="0 0 24 24"><path d="M4.25 5.61C6.27 8.2 10 13 10 13v6c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-6s3.72-4.8 5.74-7.39A.998.998 0 0 0 18.95 4H5.04c-.83 0-1.32.95-.79 1.61z"/></svg>
                    Filtros
                </div>
                <form method="GET" action="motoristas.php">
                    <div class="filter-group">
                        <label>Nome</label>
                        <input type="text" name="nome" placeholder="Nome do motorista" value="<?php echo htmlspecialchars($_GET['nome'] ?? ''); ?>">
                    </div>
                    <div class="filter-group">
                        <label>CPF / CNPJ</label>
                        <input type="text" name="cpf_cnpj" placeholder="000.000.000-00" value="<?php echo htmlspecialchars($_GET['cpf_cnpj'] ?? ''); ?>">
                    </div>
                    <div class="filter-group">
                        <label>Nº CNH</label>
                        <input type="text" name="num_cnh" placeholder="Número da CNH" value="<?php echo htmlspecialchars($_GET['num_cnh'] ?? ''); ?>">
                    </div>
                    <div class="filter-sep"></div>
                    <div class="filter-group">
                        <label>Pontos CNH</label>
                        <div class="filter-row">
                            <input type="number" name="pontos_de"  placeholder="De"  min="0" max="40" value="<?php echo htmlspecialchars($_GET['pontos_de'] ?? ''); ?>">
                            <input type="number" name="pontos_ate" placeholder="Até" min="0" max="40" value="<?php echo htmlspecialchars($_GET['pontos_ate'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="filter-group">
                        <label>Validade CNH</label>
                        <div class="filter-row">
                            <input type="date" name="validade_de"  value="<?php echo htmlspecialchars($_GET['validade_de'] ?? ''); ?>">
                            <input type="date" name="validade_ate" value="<?php echo htmlspecialchars($_GET['validade_ate'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="filter-sep"></div>
                    <button type="submit" class="btn-filter">Aplicar Filtros</button>
                    <a href="motoristas.php" class="btn-clear">Limpar Filtros</a>
                </form>
            </aside>

            <!-- MAIN -->
            <main class="main">
                <div class="page-header">
                    <div class="label">// Condutores Registrados</div>
                    <h1>Motoristas</h1>
                    <p class="sub"><?php echo $total; ?> registro(s) encontrado(s)</p>
                </div>

                <?php if (!empty($_GET['sucesso'])): ?>
                    <div class="flash sucesso">
                        <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        Motorista atualizado com sucesso.
                    </div>
                <?php endif; ?>
                <?php if (!empty($_GET['erro'])): ?>
                    <div class="flash erro">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                        <?php echo htmlspecialchars($_GET['erro']); ?>
                    </div>
                <?php endif; ?>

                <!-- STATS -->
                <div class="stats-row">
                    <div class="stat-mini">
                        <div class="dot" style="background:var(--accent)"></div>
                        <div class="info">
                            <div class="val" style="color:var(--accent)"><?php echo $total; ?></div>
                            <div class="lbl">Total</div>
                        </div>
                    </div>
                    <div class="stat-mini">
                        <div class="dot" style="background:var(--danger)"></div>
                        <div class="info">
                            <div class="val" style="color:var(--danger)"><?php echo $cnh_vencidas; ?></div>
                            <div class="lbl">CNH Vencida</div>
                        </div>
                    </div>
                    <div class="stat-mini">
                        <div class="dot" style="background:var(--warning)"></div>
                        <div class="info">
                            <div class="val" style="color:var(--warning)"><?php echo $pontos_altos; ?></div>
                            <div class="lbl">+15 Pontos</div>
                        </div>
                    </div>
                </div>

                <!-- TABLE -->
                <div class="table-wrap">
                    <div class="table-head-bar">
                        <span class="ttl">// Registros</span>
                        <span class="count"><?php echo $total; ?> resultado(s)</span>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Nome</th>
                                <th>CPF / CNPJ</th>
                                <th>CNH</th>
                                <th>Validade CNH</th>
                                <th>Pontos</th>
                                <th>E-mail</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($motoristas)): ?>
                                <tr class="empty-row">
                                    <td colspan="8">// Nenhum motorista encontrado para os filtros aplicados</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($motoristas as $m):
                                    $hoje        = time();
                                    $validade_ts = !empty($m['validade_cnh']) ? strtotime($m['validade_cnh']) : null;
                                    $dias_restantes = $validade_ts ? (int)(($validade_ts - $hoje) / 86400) : null;

                                    if ($validade_ts === null)          $cnhClass = 'alerta';
                                    elseif ($validade_ts < $hoje)       $cnhClass = 'vencida';
                                    elseif ($dias_restantes <= 60)      $cnhClass = 'alerta';
                                    else                                $cnhClass = 'valida';

                                    $cnhLabel = match($cnhClass) {
                                        'vencida' => 'Vencida',
                                        'alerta'  => $dias_restantes !== null ? "Vence em {$dias_restantes}d" : 'Sem data',
                                        default   => 'Válida'
                                    };
                                ?>
                                <tr>
                                    <td class="td-mono">#<?php echo str_pad($m['id'], 4, '0', STR_PAD_LEFT); ?></td>
                                    <td class="td-bold"><?php echo htmlspecialchars($m['nome']); ?></td>
                                    <td class="td-mono"><?php echo htmlspecialchars($m['cpf_cnpj']); ?></td>
                                    <td class="td-mono"><?php echo htmlspecialchars($m['num_cnh']); ?></td>
                                    <td>
                                        <span class="cnh-badge <?php echo $cnhClass; ?>"><?php echo $cnhLabel; ?></span>
                                        <div class="td-mono" style="margin-top:4px"><?php echo $validade_ts ? date('d/m/Y', $validade_ts) : '—'; ?></div>
                                    </td>
                                    <td>
                                        <span style="color:<?php echo $m['pontos_cnh'] >= 20 ? 'var(--danger)' : ($m['pontos_cnh'] >= 15 ? 'var(--warning)' : 'var(--text)'); ?>">
                                            <?php echo $m['pontos_cnh']; ?> pts
                                        </span>
                                    </td>
                                    <td class="td-mono"><?php echo htmlspecialchars($m['email']); ?></td>
                                    <td>
                                        <button class="btn-edit" onclick="abrirEdicao(
                                            <?php echo $m['id']; ?>,
                                            '<?php echo htmlspecialchars(addslashes($m['nome'])); ?>',
                                            '<?php echo htmlspecialchars($m['cpf_cnpj']); ?>',
                                            '<?php echo htmlspecialchars($m['email']); ?>',
                                            '<?php echo $m['validade_cnh'] ?? ''; ?>'
                                        )">Editar</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- MODAL EDIÇÃO -->
    <div class="modal-overlay" id="modal-edicao">
        <div class="modal">
            <div class="modal-head">
                <div>
                    <div class="modal-tag">// Atualizar Registro</div>
                    <div class="modal-title">Editar Motorista</div>
                </div>
                <button class="modal-close" onclick="fecharModal()">✕</button>
            </div>

            <div class="modal-info">
                <div class="mi-item">
                    <div class="mi-label">Nome</div>
                    <div class="mi-val" id="info-nome">—</div>
                </div>
                <div class="mi-item">
                    <div class="mi-label">CPF / CNPJ</div>
                    <div class="mi-val" id="info-cpf">—</div>
                </div>
            </div>

            <form method="POST" action="../controllers/editar_motorista.php">
                <input type="hidden" name="id" id="edit-id">

                <div class="field">
                    <label>E-mail</label>
                    <input type="text" name="email" id="edit-email" placeholder="novo@email.com" required>
                </div>
                <div class="field">
                    <label>Validade da CNH</label>
                    <input type="date" name="validade_cnh" id="edit-validade" required>
                </div>

                <button type="submit" class="btn-primary">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        function abrirEdicao(id, nome, cpf, email, validade) {
            document.getElementById('edit-id').value       = id;
            document.getElementById('edit-email').value    = email;
            document.getElementById('edit-validade').value = validade;
            document.getElementById('info-nome').textContent = nome;
            document.getElementById('info-cpf').textContent  = cpf;
            document.getElementById('modal-edicao').classList.add('aberto');
        }
        function fecharModal() {
            document.getElementById('modal-edicao').classList.remove('aberto');
        }
        document.getElementById('modal-edicao').addEventListener('click', function(e) {
            if (e.target === this) fecharModal();
        });
    </script>

</body>
</html>
