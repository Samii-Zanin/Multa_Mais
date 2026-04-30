<?php

require_once __DIR__ . '/../config/conexao.php';


class Multa {

    private $id;
    private $id_motorista;
    private $id_carro;
    private $id_policial;
    private $valor;
    private $tipo_infracao;
    private $descricao;
    private $data;
    private $uf;
    private $endereco;
    private $data_vencimento;
    private $status;


    public function __construct(
        int $id_motorista,
        int $id_carro,
        int $id_policial,
        float $valor,
        string $tipo_infracao,
        string $descricao,
        string $uf,
        string $endereco,
        string $data_vencimento = null,
        string $status = 'Pendente'

    ){
        $this->id_motorista = $id_motorista;
        $this->id_carro = $id_carro;
        $this->id_policial = $id_policial;
        $this->valor = $valor;
        $this->tipo_infracao = $tipo_infracao;
        $this->descricao = $descricao;
        $this->uf = $uf;
        $this->endereco = $endereco;
        $this->data_vencimento = $data_vencimento;
        $this->status = $status;
    }


    public function getIdMotorista(){
        return $this->id_motorista;
    }

    public function getIdCarro(){
        return $this->id_carro;
    }
    public function getIdPolicial(){
        return $this->id_policial;
    }

    public function setMotorista(Motorista $motorista) {
        $this->id_motorista = $motorista;
    }
    public function setCarro(Carro $carro) {
        $this->id_carro = $carro;
    }
    public function setPolicial(Policial $policial) {
        $this->id_policial = $policial;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao(string $descricao){
        $this->descricao = $descricao;
    }

    public function getValor(){
        return $this->valor;
    }
    public function setValor(float $valor){
        $this->valor = $valor;
    }

    public function getTipoInfracao(){
        return $this->tipo_infracao;
    }

    public function setTipoInfracao(string $tipo_infracao){
        $this->tipo_infracao = $tipo_infracao;
    }

    public function getData(){
        return $this->data;
    }

    public function setEndereco(string $endereco){
        $this->endereco = $endereco;
    }
    public function getEndereco(){
        return $this->endereco;
    }

    public function getId(){
        return $this->id;
    }
    public function save(){
        $conexao = Conexao::getConexao();

        $stmt = $conexao->prepare("
            INSERT INTO multa (id_motorista, id_carro, id_policial, valor, tipo_infracao, descricao, uf, endereco, data_vencimento, status)

            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiidssssss",
            $this->id_motorista,
            $this->id_carro,
            $this->id_policial,
            $this->valor,
            $this->tipo_infracao,
            $this->descricao,
            $this->uf,
            $this->endereco,
            $this->data_vencimento,
            $this->status
        );

        $stmt->execute();

        $this->id = $conexao->insert_id;

        $stmt->close();
        return true;
    }

}