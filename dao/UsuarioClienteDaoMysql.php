<?php

require_once 'models/UsuarioCliente.php';

class UsuarioClienteDaoMysql implements UsuarioClienteDAO {

    //criando o CRUD do sistema

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function add(UsuarioCliente $uc) {
        $sql = $this->pdo->prepare("
        insert into usuarios_cliente(nome_cli, empresa_cli, email_cli, senha_cli, telefone_cli, data_hora_cadastro, situacao_cli, data_limite_acesso)
        values
        (:nome_cli, :empresa_cli, :email_cli, :senha_cli, :telefone_cli, :data_hora_cadastro, :situacao_cli, :data_limite_acesso);");

        $sql->bindValue(':nome_cli', $uc->getNomeCli());
        $sql->bindValue(':empresa_cli', $uc->getEmpresaCli());
        $sql->bindValue(':email_cli', $uc->getEmailCli());
        $sql->bindValue(':senha_cli', $uc->getSenhaCli());
        $sql->bindValue(':telefone_cli', $uc->getTelefoneCli());
        $sql->bindValue(':data_hora_cadastro', $uc->getDataHoraCadastro());
        $sql->bindValue(':situacao_cli', $uc->getSituacaoCli());
        $sql->bindValue(':data_limite_acesso', $uc->getDataLimiteAcesso());
        $sql->execute();

        $uc->setIdCli($this->pdo->lastInsertId());

        return $uc;
    }

    public function findAll() {
        $array = [];

        $sql = $this->pdo->query("select * from usuarios_cliente");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        foreach($data as $item) {
            $uc = new UsuarioCliente;
            $uc->setIdCli($item['id_cli']);
            $uc->setNomeCli($item['nome_cli']);
            $uc->setEmpresaCli($item['empresa_cli']);
            $uc->setEmailCli($item['email_cli']);
            $uc->setSenhaCli($item['senha_cli']);
            $uc->setTelefoneCli($item['telefone_cli']);
            $uc->setDataHoraCadastro($item['data_hora_cadastro']);
            $uc->setSituacaoCli($item['situacao_cli']);
            $uc->setDataLimiteAcesso($item['data_limite_acesso']);
    
            $array[] = $uc;
        }

        return $array;
    }

    public function findByEmail($email_cli) {
        $array = [];

        $email = $email_cli;

        $sql = $this->pdo->query("SELECT * FROM usuarios_cliente WHERE email_cli = '".$email."';");
        
      

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        foreach($data as $item) {
            $uc = new UsuarioCliente;
            $uc->setIdCli($item['id_cli']);
            $uc->setNomeCli($item['nome_cli']);
            $uc->setEmpresaCli($item['empresa_cli']);
            $uc->setEmailCli($item['email_cli']);
            $uc->setSenhaCli($item['senha_cli']);
            $uc->setTelefoneCli($item['telefone_cli']);
            $uc->setDataHoraCadastro($item['data_hora_cadastro']);
            $uc->setSituacaoCli($item['situacao_cli']);
            $uc->setDataLimiteAcesso($item['data_limite_acesso']);
    
            $array[] = $uc;
        }

        return $array;
    }

    public function findById($id_cli) {
        $array = [];

        $id = $id_cli;

        $sql = $this->pdo->query("SELECT * FROM usuarios_cliente WHERE id_cli = ".$id.";");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        foreach($data as $item) {
            $uc = new UsuarioCliente;
            $uc->setIdCli($item['id_cli']);
            $uc->setNomeCli($item['nome_cli']);
            $uc->setEmpresaCli($item['empresa_cli']);
            $uc->setEmailCli($item['email_cli']);
            $uc->setSenhaCli($item['senha_cli']);
            $uc->setTelefoneCli($item['telefone_cli']);
            $uc->setDataHoraCadastro($item['data_hora_cadastro']);
            $uc->setSituacaoCli($item['situacao_cli']);
            $uc->setDataLimiteAcesso($item['data_limite_acesso']);
    
            $array[] = $uc;
        }
        return $array;
    }

    public function update(UsuarioCliente $uc) {
        $sql = $this->pdo->prepare("UPDATE usuarios_cliente SET 
        nome_cli = :nome_cli,
        empresa_cli = :empresa_cli,
        email_cli = :email_cli,
        senha_cli = :senha_cli,
        telefone_cli = :telefone_cli,
        data_hora_cadastro = :data_hora_cadastro,
        situacao_cli = :situacao_cli,
        data_limite_acesso = :data_limite_acesso
        WHERE id_cli = :id_cli");

        $sql->bindValue(':nome_cli', $uc->getNomeCli());
        $sql->bindValue(':empresa_cli', $uc->getEmpresaCli());
        $sql->bindValue(':email_cli', $uc->getEmailCli());
        $sql->bindValue(':senha_cli', $uc->getSenhaCli());
        $sql->bindValue(':telefone_cli', $uc->getTelefoneCli());
        $sql->bindValue(':data_hora_cadastro', $uc->getDataHoraCadastro());
        $sql->bindValue(':situacao_cli', $uc->getSituacaoCli());
        $sql->bindValue(':data_limite_acesso', $uc->getDataLimiteAcesso());
        $sql->bindValue(':id_cli', $uc->getIdCli());
        $sql->execute();

        return $uc;
    }

    public function delete($id_cli) {

    }
}

?>