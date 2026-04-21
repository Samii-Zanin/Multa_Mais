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

    public static function getIdByCpfOrCnh(string $cpf_cnh) {
    $conexao = Conexao::getConexao();

    $stmt = $conexao->prepare("
        SELECT id FROM motoristas WHERE cpf_cnpj = ? OR num_cnh = ? LIMIT 1
    ");
    $stmt->bind_param("ss", $cpf_cnh, $cpf_cnh);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $stmt->close();

    if ($resultado->num_rows === 1) {
        $dados = $resultado->fetch_assoc();
        return $dados['id'];
    }

    return null;
    }

    public function validaMotorista($cpf, $num_cnh){
        $erro_motorista = "CPF ou CNH já cadastrados para outro motorista.";

        $conexao = Conexao::getConexao();
        $stmt = $conexao->prepare("
        SELECT * FROM motoristas WHERE cpf_cnpj = ? OR num_cnh = ?
        ");
        $stmt->bind_param("ss", $cpf, $num_cnh);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $erro_motorista;
        }
            return true;
    }
    public function save(){
         
        $validacao = $this->validaMotorista($this->cpf_cnpj, $this->num_cnh);

        if ($validacao !== true) {
            return $validacao; 
        }
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
        return true;
    }}

