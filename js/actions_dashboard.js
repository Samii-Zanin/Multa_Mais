function abrirModalMotorista() {
  document.getElementById("modal-motorista").classList.add("aberto");
}
function fecharModalMotorista() {
  document.getElementById("modal-motorista").classList.remove("aberto");
}
document
  .getElementById("modal-motorista")
  .addEventListener("click", function (e) {
    if (e.target === this) fecharModalMotorista();
  });

function abrirModalVeiculo() {
  document.getElementById("modal-veiculo").classList.add("aberto");
}
function fecharModalVeiculo() {
  document.getElementById("modal-veiculo").classList.remove("aberto");
}
document
  .getElementById("modal-veiculo")
  .addEventListener("click", function (e) {
    if (e.target === this) fecharModalVeiculo();
  });

function abrirModalMulta() {
  document.getElementById("modal-multa").classList.add("aberto");
}
function fecharModalMulta() {
  document.getElementById("modal-multa").classList.remove("aberto");
}
document.getElementById("modal-multa").addEventListener("click", function (e) {
  if (e.target === this) fecharModalMulta();
});
