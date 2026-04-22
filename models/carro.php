<?php

class Carro {
    private $id;
    private $modelo;
    private $marca;
    private $placa;
    private $ano;
    private $motorista;

    public function __construct($modelo, $marca, $placa, $ano, $motorista_id = null) {
        $this->modelo = $modelo;
        $this->marca = $marca;
        $this->placa = $placa;
        $this->ano = $ano;
        $this->motorista_id = $motorista_id;
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

    public static function getIdByPlaca(string $placa){

        $conexao = Conexao::getConexao();
    
        $stmt = $conexao->prepare("
            SELECT id FROM carros WHERE placa = ? LIMIT 1
        ");
        $stmt->bind_param("s", $placa);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        if ($resultado->num_rows == 1){
            $dados = $resultado->fetch_assoc();
            return $dados["id"];
        }
       
        return null;
        
    }

    public function save(){
        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("
            INSERT INTO carros (modelo, marca, placa, ano, motorista_id)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("sssii", $this->modelo, $this->marca, $this->placa, $this->ano, $this->motorista_id);
        $stmt->execute();
        $stmt->close();
        return true;
}
}