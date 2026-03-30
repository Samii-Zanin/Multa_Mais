<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SRMV — Registro de Agente</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/registro.css">
    <script>
    function mascara_cpf() {
        var cpf = document.getElementById("cpf");
        if (cpf.value.length == 3 || cpf.value.length == 7) {
            cpf.value += ".";
        } else if (cpf.value.length == 11) {
            cpf.value += "-";
        }}
    function validar_senha() {
        const senha = document.getElementById("senha").value;
        let valido = true;

        // — tamanho —
        if (senha.length < 8) {
            document.getElementById("erro-senha1").style.display = "block";
            valido = false;
        } else {
            document.getElementById("erro-senha1").style.display = "none";
        }

        // — maiúscula —
        if (!/[A-Z]/.test(senha)) {
            document.getElementById("erro-senha2").style.display = "block";
            valido = false;
        } else {
            document.getElementById("erro-senha2").style.display = "none";
        }

        // — caractere especial —
        if (!/[!@#$%^&*(),.?":{}|<>_\-\[\]=+;]/.test(senha)) {
            document.getElementById("erro-senha3").style.display = "block";
            valido = false;
        } else {
            document.getElementById("erro-senha3").style.display = "none";
        }

        return valido;
    }
    function validar_confirmacao_senha(){
        var senha_confirmada = document.getElementById("confirmar_senha"); 
        var senha = document.getElementById("senha");
        if (senha_confirmada.value !== senha.value) {
            document.getElementById("erro-confirmar").style.display = "block";
        } else {
            document.getElementById("erro-confirmar").style.display = "none";
        }

    }
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="sys-header">
            <div class="badge">
                <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.11V11c0 4.52-3.13 8.75-7 9.93-3.87-1.18-7-5.41-7-9.93V6.29l7-3.11zM11 7v6h2V7h-2zm0 8v2h2v-2h-2z"/></svg>
            </div>
            <div class="sys-title">
                <div class="acronym">SRMV</div>
                <div class="full-name">Sistema de Registro e Monitoramento de Violações</div>
            </div>
        </div>

        <div class="divider">
            <span>Cadastro de Agente Autorizado</span>
        </div>

        <div class="card">
            <p class="card-title">// Novo Registro de Agente</p>
            <p class="card-subtitle">Preencha todos os campos. O acesso será concedido após validação interna.</p>

            <div class="alert-box">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                <span>Este formulário é de uso exclusivo para agentes autorizados. O uso indevido é passível de sanção.</span>
            </div>

            <form method="POST" action="salvar_registro.php">

                <div class="section-label">Identificação Pessoal</div>
                <div class="grid-2">
                    <div class="field">
                        <label for="nome">Nome Completo</label>
                        <input type="text" id="nome" name="nome" placeholder="Nome do agente" required>
                        <div class="tooltip-error" id="erro-nome">Campo obrigatório</div>
                    </div>
                    <div class="field">
                        <label for="cpf">CPF</label>
                       <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" autocomplete="off" onkeyup="mascara_cpf()">
                        <div class="tooltip-error" id="erro-nome">Campo obrigatório</div>
                        <div class="tooltip-error" id="erro-cpf">Esse campo deve conter apenas números</div>
                    </div>
                </div>

                <div class="section-label">Dados Funcionais</div>
                <div class="grid-2">
                    <div class="field">
                        <label for="cargo">Cargo / Patente</label>
                        <select id="cargo" name="cargo" required>
                            <option value="" disabled selected>Selecionar...</option>
                            <option value="Soldado">Soldado</option>
                            <option value="Cabo">Cabo</option>
                            <option value="Sargento">Sargento</option>
                            <option value="Tenente">Tenente</option>
                            <option value="Capitão">Capitão</option>
                            <option value="Major">Major</option>
                            <option value="Delegado">Delegado</option>
                            <option value="Inspetor">Inspetor</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="departamento">Departamento</label>
                        <input type="text" id="departamento" name="departamento" placeholder="Ex: DETRAN / PM / PC" required>
                    </div>
                    <div class="field full">
                        <label for="local_servico">Local de Serviço</label>
                        <input type="text" id="local_servico" name="local_servico" placeholder="Ex: 4ª DP — Zona Sul" required>
                    </div>
                </div>

                <div class="section-label">Credenciais de Acesso</div>
                <div class="grid-2">
                    <div class="field full">
                        <label for="email">E-mail Institucional</label>
                        <input type="email" id="email" name="email" placeholder="agente@policia.gov.br" required>
                        <div class="tooltip-error" id="erro-email">E-mail inválido</div>
                    </div>
                    <div class="field">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Mínimo 8 caracteres" autocomplete="off" onkeyup="validar_senha()">
                        <div class="tooltip-error" id="erro-senha1">Senha não possui 8 caracteres</div>
                        <div class="tooltip-error" id="erro-senha2">Senha deve conter pelo menos uma letra maiúscula</div>
                        <div class="tooltip-error" id="erro-senha3">Senha deve conter pelo menos um caracter especial</div>
                    </div>
                    <div class="field">
                        <label for="confirmar_senha">Confirmar Senha</label>
                        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Repita a senha" autocomplete="off" onkeyup="validar_confirmacao_senha()">
                        <div class="tooltip-error" id="erro-confirmar">As senhas não coincidem</div>
                    </div>
                </div>

                <button type="submit" class="btn-primary">Registrar Agente</button>
            </form>

            <div class="link-row">
                <span>Já possui acesso?</span>
                <a href="login.php">← Voltar ao Login</a>
            </div>
        </div>
    </div>
    <script scr="../js/registro.js"></script>
</body>
</html>
