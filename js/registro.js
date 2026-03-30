function mostrarErro(inputId, erroId, mensagem) {
  const input = document.getElementById(inputId);
  const erro = document.getElementById(erroId);
  erro.textContent = mensagem;
  erro.style.display = "block";
  input.classList.add("input-error");
}

function limparErro(inputId, erroId) {
  document.getElementById(erroId).style.display = "none";
  document.getElementById(inputId).classList.remove("input-error");
}

function validarEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validarCPF(cpf) {
  cpf = cpf.replace(/\D/g, "");
  if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
  return true;
}

document.querySelector("form").addEventListener("submit", function (e) {
  e.preventDefault();
  let valido = true;

  if (!validar_senha()) {
    valido = false;
  }
  if (!validar_confirmacao_senha()) {
    valido = false;
  }

  const camposObrigatorios = ["nome", "cargo", "departamento", "local_servico"];
  camposObrigatorios.forEach(function (campo) {
    const val = document.getElementById(campo).value.trim();
    if (!val) {
      mostrarErro(campo, "erro-" + campo, "Campo obrigatório");
      valido = false;
    } else {
      limparErro(campo, "erro-" + campo);
    }
  });

  const cpf = document.getElementById("cpf").value.trim();
  if (!cpf) {
    mostrarErro("cpf", "erro-cpf", "Campo obrigatório");
    valido = false;
  } else if (!validarCPF(cpf)) {
    mostrarErro("cpf", "erro-cpf", "CPF inválido");
    valido = false;
  } else {
    limparErro("cpf", "erro-cpf");
  }

  // — e-mail —
  const email = document.getElementById("email").value.trim();
  if (!email) {
    mostrarErro("email", "erro-email", "Campo obrigatório");
    valido = false;
  } else if (!validarEmail(email)) {
    mostrarErro(
      "email",
      "erro-email",
      "Formato inválido — use nome@dominio.com",
    );
    valido = false;
  } else {
    limparErro("email", "erro-email");
  }

  // adicione essa função
  function validar_senha() {
    const senha = document.getElementById("senha").value;
    let valido = true;

    if (senha.length < 8) {
      document.getElementById("erro-senha1").style.display = "block";
      valido = false;
    } else {
      document.getElementById("erro-senha1").style.display = "none";
    }

    if (!/[A-Z]/.test(senha)) {
      document.getElementById("erro-senha2").style.display = "block";
      valido = false;
    } else {
      document.getElementById("erro-senha2").style.display = "none";
    }

    if (!/[!@#$%^&*(),.?":{}|<>_\-\[\]=+;]/.test(senha)) {
      document.getElementById("erro-senha3").style.display = "block";
      valido = false;
    } else {
      document.getElementById("erro-senha3").style.display = "none";
    }

    return valido;
  }
  function validar_confirmacao_senha() {
    var senha_confirmada = document.getElementById("confirmar_senha");
    var senha = document.getElementById("senha");
    let valido = true;
    if (senha_confirmada.value !== senha.value) {
      document.getElementById("erro-confirmar").style.display = "block";
      valido = false;
    } else {
      document.getElementById("erro-confirmar").style.display = "none";
    }
    return valido;
  }

  if (valido) this.submit();
});

document.querySelectorAll("input, select").forEach(function (el) {
  el.addEventListener("input", function () {
    limparErro(el.id, "erro-" + el.id);
  });
});
