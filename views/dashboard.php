<?php

require_once __DIR__ . '/../auth/verificar_login.php';

?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SRMV — Painel de Controle</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/dashboard.css" />
  </head>
  <body>
    <div class="topbar">
      <div class="topbar-logo">
        <div class="badge">
          <svg viewBox="0 0 24 24">
            <path
              d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"
            />
          </svg>
        </div>
        <span class="acronym">SRMV</span>
      </div>
      <div class="topbar-sep"></div>
      <span class="topbar-breadcrumb">Painel Principal</span>

      <div class="topbar-right">
        <div class="agent-info">
          <div class="agent-name">
            <?php echo htmlspecialchars($_SESSION['policial_nome'] ?? 'Agente');
            ?>
          </div>
          <div class="agent-role">Identificador do Agente:
          <?php echo htmlspecialchars($_SESSION['policial_id'] ?? 'Identificador não encontrado');
            ?></div>
        </div>
        <a href="../auth/logout.php" class="logout-btn">Encerrar Sessão</a>
      </div>
    </div>

    <div class="layout">
      <aside class="sidebar">
        <div class="nav-section">
          <div class="nav-section-label">Navegação</div>
          <a class="nav-item active" href="dashboard.php">
            <svg viewBox="0 0 24 24">
              <path
                d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"
              />
            </svg>
            Painel
          </a>
          <a class="nav-item" onclick="abrirModalMulta()">
            <svg viewBox="0 0 24 24">
              <path
                d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-5 14H4v-4h11v4zm0-5H4V9h11v4zm5 5h-4V9h4v9z"
              />
            </svg>
            Registrar Multa
          </a>
          <a class="nav-item" href="../views/motoristas.php">
            <svg viewBox="0 0 24 24">
              <path
                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
              />
            </svg>
            Motoristas
          </a>
          <a class="nav-item" href="../views/veiculos.php">
            <svg viewBox="0 0 24 24">
              <path
                d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"
              />
            </svg>
            Veículos
          </a>
          <a class="nav-item" href="../views/viewMultas.php">
            <svg viewBox="0 0 24 24">
              <path
                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"
              />
            </svg>
            Histórico de Multas
          </a>
        </div>
      </aside>

      <main class="main" style="padding-bottom: 60px">
        <div class="page-header">
          <div class="label">// Painel de Controle</div>
          <h1>Visão Geral do Sistema</h1>
        </div>

        <div class="actions-grid">
          <a class="action-card" href="#" onclick="abrirModalMulta()">
            <svg viewBox="0 0 24 24">
              <path
                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"
              />
            </svg>
            <div>
              <div class="ac-title">Nova Multa</div>
              <div class="ac-desc">Registrar infração de trânsito</div>
            </div>
          </a>
          <a class="action-card" onclick="abrirModalMotorista()">
            <svg viewBox="0 0 24 24">
              <path
                d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
              />
            </svg>
            <div>
              <div class="ac-title">Cadastrar Motorista</div>
              <div class="ac-desc">Adicionar condutor ao sistema</div>
            </div>
          </a>
          <a class="action-card" onclick="abrirModalVeiculo()">
            <svg viewBox="0 0 24 24">
              <path
                d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99z"
              />
            </svg>
            <div>
              <div class="ac-title">Cadastrar Veículo</div>
              <div class="ac-desc">Registrar novo veículo</div>
            </div>
          </a>
        </div>

        </div>
      </main>
    </div>
    <script src="../js/actions_dashboard.js"></script>
  </body>
  <div class="modal-overlay" id="modal-motorista">
    <div class="modal">
        <div class="modal-head">
            <div>
                <div class="modal-tag">// Novo Registro</div>
                <div class="modal-title">Cadastrar Motorista</div>
            </div>
            <button class="modal-close" onclick="fecharModalMotorista()">✕</button>
        </div>

        <form method="POST" action="../controllers/registro_motorista.php">
            <div class="grid-2">
                <div class="field full">
                    <label>Nome Completo</label>
                    <input type="text" name="name" placeholder="Nome do condutor" required>
                </div>
                <div class="field">
                    <label>CPF</label>
                    <input type="text" name="cpf_cnpj" id="cpf-motorista" placeholder="000.000.000-00" maxlength="14" required>
                </div>
                <div class="field">
                    <label>E-mail</label>
                    <input type="text" name="email" placeholder="email@dominio.com" required>
                </div>
                <div class="field">
                    <label>Nº CNH</label>
                    <input type="text" name="num_cnh" placeholder="00000000000" required>
                </div>
                <div class="field">
                    <label>Pontos CNH</label>
                    <input type="text" name="pontos_cnh" placeholder="Máximo: 40" required>
                </div>
                <div class="field">
                    <label>Data de Nascimento</label>
                    <input type="date" name="data_nascimento" placeholder="Ex: 01/01/200" min="18" max="100" required>
                </div>
                <div class="field">
                    <label>Validade CNH</label>
                    <input type="date" name="validade_cnh" placeholder="Ex: 01/30/2029" min="1" max="40" required>
                </div>
            </div>

            <button type="submit" class="btn-primary">Registrar Motorista</button>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modal-veiculo">
    <div class="modal">
        <div class="modal-head">
            <div>
                <div class="modal-tag">// Novo Registro</div>
                <div class="modal-title">Cadastrar Veículo</div>
            </div>
            <button class="modal-close" onclick="fecharModalVeiculo()">✕</button>
        </div>

        <form method="POST" action="../controllers/registro_veiculo.php">
            <div class="grid-2">
                <div class="field full">
                    <label>Modelo</label>
                    <input type="text" name="modelo" placeholder="Modelo do veículo" required>
                </div>
                <div class="field">
                    <label>Marca</label>
                    <input type="text" name="marca" placeholder="Marca do veículo" required>
                </div>
                <div class="field">
                    <label>Placa</label>
                    <input type="text" name="placa" placeholder="ABC-1234" required>
                </div>
                <div class="field">
                    <label>Ano</label>
                    <input type="text" name="ano" placeholder="0000" required>
                </div>
                <div class="field">
                    <label>Motorista</label>
                    <input type="text" name="cpf_cnh" placeholder="CPF do Motorista Proprietário do Veículo" required>
                </div>
            </div>

            <button type="submit" class="btn-primary">Registrar Veículo</button>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modal-multa">
    <div class="modal">
        <div class="modal-head">
            <div>
                <div class="modal-tag">// Novo Registro</div>
                <div class="modal-title">Cadastrar Multa</div>
            </div>
            <button class="modal-close" onclick="fecharModalMulta()">✕</button>
        </div>

        <form method="POST" action="../controllers/registro_multa.php">
            <div class="grid-2">
                <div class="field full">
                    <label>CPF do Motorista</label>
                    <input type="text" name="cpf_cnh" placeholder="000.000.000-00" required>
                </div>
                <div class="field">
                    <label>Placa do Carro </label>
                    <input type="text" name="placa_veiculo" placeholder="ABC-1234" required>
                </div>
                <div class="field">
                  <label>Tipo de Infração</label>
                  <input type="text" name="tipo_infracao" placeholder="Tipo de infração" required>
                </div>
                <div class="field">
                  <label>UF da Ocorrência</label>
                  <input type="text" name="uf" placeholder="EX: SP/RS/PR" required>
                </div>
                <div class="field">
                  <label>Endereço da Ocorrência</label>
                  <input type="text" name="endereco" placeholder="Endereço" required>
                </div>
                <div class="field">
                  <label>Descrição</label>
                  <input type="text" name="descricao" placeholder="Descrição da infração" required>
                </div>
                <div class="field">
                    <label>Valor</label>
                    <input type="number" name="valor_multa" placeholder="00,00" step="0.01" required>
                </div>
              </div>

            <button type="submit" class="btn-primary">Registrar Multa</button>
        </form>
    </div>
</div>
</html>
