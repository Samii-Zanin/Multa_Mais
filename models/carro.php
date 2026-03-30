<?php

class Carro {
    private $id;
    private $modelo;
    private $marca;
    private $placa;
    private $ano;
    private $motorista;

    public function __construct($modelo, $marca, $placa, $ano, $motorista = null) {
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->placa = $placa;
        $this->ano = $ano;
        $this->motorista = $motorista;
    }
    public function getModelo() {
        return $this->modelo;
    }
    public function getMarca() {
        return $this->marca;
    }
    public function getPlaca() {
        return $this->placa;
    }
    public function getAno() {
        return $this->ano;
    }
    public function getId() {
        return $this->id;
    }

    public function setMotorista(Motorista $motorista) {
        $this->motorista = $motorista;
    }

    public function save(){
        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("
            INSERT INTO carros (modelo, marca, placa, ano, motorista_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        $motorista_id = $this->motorista ? $this->motorista->getId() : null;

        $stmt->bind_param(
        "sssii",
        $this->modelo,
        $this->marca,
        $this->placa,
        $this->ano,
        $motorista_id
    );
        $stmt->execute();
        $stmt->close();
}
}