<?php

class UsuarioCliente {

    //criando variáveis do objeto
    private $id_cli;
    private $nome_cli;
    private $empresa_cli;
    private $email_cli;
    private $senha_cli;
    private $telefone_cli;
    private $data_hora_cadastro;
    private $situacao_cli;
    private $data_limite_acesso;

    //criando as funções que vão aplicar e buscar valores das variaveis

    public function getIdCli() {
        return $this->id_cli;
    }

    public function setIdCli($ic) {
        $this->id_cli = trim($ic);
    }

    public function getNomeCli() {
        return $this->nome_cli;
    }

    public function setNomeCli($nc) {
        $this->nome_cli = trim($nc);
    }

    public function getEmpresaCli() {
        return $this->empresa_cli;
    }

    public function setEmpresaCli($ec) {
        $this->empresa_cli = trim($ec);
    }

    public function getEmailCli() {
        return $this->email_cli;
    }

    public function setEmailCli($ec) {
        $this->email_cli = trim($ec);
    }

    public function getSenhaCli() {
        return $this->senha_cli;
    }

    public function setSenhaCli($sc) {
        $this->senha_cli = password_hash(trim($sc), PASSWORD_DEFAULT);
    } 

    public function getTelefoneCli() {
        return $this->telefone_cli;
    }

    public function setTelefoneCli($tc) {
        $this->telefone_cli = trim($tc);
    }

    public function getDataHoraCadastro() {
        return $this->data_hora_cadastro;
    }

    public function setDataHoraCadastro($dhc) {
        $this->data_hora_cadastro = trim($dhc);
    }

    public function getSituacaoCli() {
        return $this->situacao_cli;
    }

    public function setSituacaoCli($sc) {
        $this->situacao_cli = trim($sc);
    }

    public function getDataLimiteAcesso() {
        return $this->data_limite_acesso;
    }

    public function setDataLimiteAcesso($dla) {
        $this->data_limite_acesso = trim($dla);
    }

}

//criando o DAO para ajudar na criação do CRUD do sistema
interface UsuarioClienteDAO {

    public function add(UsuarioCliente $uc);

    public function findAll();

    public function findById($id_cli);

    public function update(UsuarioCliente $uc);

    public function delete($id_cli);
}


?>