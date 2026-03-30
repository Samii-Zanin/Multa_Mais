<?php

require_once __DIR__ . '/../config/conexao.php';

class Policial {
    private $id;
    private $cpf;
    private $email;
    private $senha;
    private $nome;
    private $cargo;
    private $local_servico;
    private $departamento;

    public function __construct($cpf, $email, $senha, $nome, $cargo, $local_servico, $departamento) {
        $this->cpf = $cpf;
        $this->email = $email;
        $this->senha = $senha;
        $this->nome = $nome;
        $this->cargo = $cargo;
        $this->local_servico = $local_servico;
        $this->departamento = $departamento;
    }
    
    public function getId() {
        return $this->id;
    }
    public function getCpfCnpj() {
        return $this->cpf;
    }
    public function getNome() {
        return $this->nome;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getCargo() {    
        return $this->cargo;
    }       
    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }
    public function getLocalServico() {
        return $this->local_servico;
    }
    public function setLocalServico($local_servico) {
        $this->local_servico = $local_servico;
    }
    public function getDepartamento() {
        return $this->departamento;
    }
    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }
    


    public function save(){
        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("
            INSERT INTO policial (cpf, email, senha, nome, cargo, local_servico, departamento)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
        "sssssss",
        $this->cpf,
        $this->email,
        $this->senha,
        $this->nome,
        $this->cargo,
        $this->local_servico,
        $this->departamento
        );
        $stmt->execute();
        $stmt->close();
}
    public static function getPolicialById($id) {
        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("
            SELECT id, cpf, email, nome, cargo, local_servico, departamento
            FROM policial
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $dados = $resultado->fetch_assoc();
            return new Policial(
                $dados['cpf'],
                $dados['email'],
                null,
                $dados['nome'],
                $dados['cargo'],
                $dados['local_servico'],
                $dados['departamento']
            );
        }

        return null;
    }

    public function multar(Motorista $motorista, Carro $carro, float $valor, string $descricao, string $tipo_infracao) {
        $conexao = Conexao::getConexao();
        $motorista_id = $motorista->getId();
        $carro_id = $carro->getId();
        $policial_id = $this->getId();
    


        $stmt = $conexao->prepare("
            INSERT INTO multa (id_motorista, id_carro, id_policial, valor, descricao, tipo_infracao)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "iiidss",
            $motorista_id,
            $carro_id,
            $policial_id,
            $valor,
            $descricao,
            $tipo_infracao
        );
        $stmt->execute();
        $stmt->close();
    }

    public static function login($email, $senha){

        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("
            SELECT id, senha
            FROM policial
            WHERE email = ?
        ");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1){

            $dados = $resultado->fetch_assoc();

            if (password_verify($senha, $dados["senha"])){

                return $dados["id"];
            }
        }

        return false;
    }
}