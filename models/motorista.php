<?php

require_once __DIR__ . '/../config/conexao.php';


class Motorista {

    private $id;
    private $cpf_cnpj;
    private $name;
    private $email;
    private $num_cnh;
    private $idade;
    private $carros = [];
    private $pontos_cnh;

    public function __construct(
        string $cpf_cnpj,
        string $name,
        string $email,
        string $num_cnh,
        int $pontos_cnh,
        int $idade
    ){
        $this->cpf_cnpj = $cpf_cnpj;
        $this->name = $name;
        $this->email = $email;
        $this->num_cnh = $num_cnh;
        $this->pontos_cnh = $pontos_cnh;
        $this->idade = $idade;
    }

    public function add_carro(Carro $carro){
        $this->carros[] = $carro;
        $carro->setMotorista($this);
    }

    public function get_carros(){
        return $this->carros;
    }

    public function getId(){
        return $this->id;
    }
    public function save(){
        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("
            INSERT INTO motoristas (cpf_cnpj, nome, email, num_cnh, idade, pontos_cnh)

            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssii",
            $this->cpf_cnpj,
            $this->name,
            $this->email,
            $this->num_cnh,
            $this->idade,
            $this->pontos_cnh
        );

        $stmt->execute();

        $this->id = $conexao->insert_id;

        $stmt->close();
    }

}