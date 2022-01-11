<?php

require_once 'models/UsuarioAdministrador.php';

class UsuarioAdministradorDaoMysql implements UsuarioAdministradorDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

   

    public function add(UsuarioAdministrador $ua) {
        $sql = $this->pdo->prepare("INSERT INTO 
        usuarios_administrador(nome_adm, email_adm_ctt, email_adm, telefone_adm, senha_adm)
            VALUES
        (:nome_adm, :email_adm_ctt, :email_adm, :telefone_adm, :senha_adm);");

        $sql->bindValue(':nome_adm', $ua->getNomeAdm());
        $sql->bindValue(':email_adm_ctt', $ua->getEmailAdmCtt());
        $sql->bindValue(':email_adm', $ua->getEmailAdm());
        $sql->bindValue(':telefone_adm', $ua->getTelefoneAdm());
        $sql->bindValue(':senha_adm', $ua->getSenhaAdm());
        $sql->execute();


        return $ua;
    }

    public function verifyRowByEmail($email_adm) {
        $email = $email_adm;

        $sql = $this->pdo->query("SELECT * FROM usuarios_administrador WHERE email_adm = '".$email."';");

        return $sql->rowCount() > 0;
    }

    public function verifyRow() {
        $sql = $this->pdo->query("select * from usuarios_administrador");
        return $sql->rowCount() > 0;
    }

    public function findAll() {
        $array = [];

        $sql = $this->pdo->query("select * from usuarios_administrador");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $ua = new UsuarioAdministrador;
                $ua->setIdAdm($item['id_adm']);
                $ua->setNomeAdm($item['nome_adm']);
                $ua->setEmailAdmCtt($item['email_adm_ctt']);
                $ua->setEmailAdm($item['email_adm']);
                $ua->setTelefoneAdm($item['telefone_adm']);
                $ua->setSenhaAdm($item['senha_adm']);
        
                $array[] = $ua;
            }
    
        }

        return $array;
    }

    public function findById($id_adm) {
        $array = [];

        $id = $id_adm;

        $sql = $this->pdo->query("SELECT * FROM usuarios_administrador WHERE id_cli = ".$id.";");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        foreach($data as $item) {
            $ua = new UsuarioAdministrador;
            $ua->setIdAdm($item['id_adm']);
            $ua->setNomeAdm($item['nome_adm']);
            $ua->setEmailAdmCtt($item['email_adm_ctt']);
            $ua->setEmailAdm($item['email_adm']);
            $ua->setTelefoneAdm($item['telefone_adm']);
            $ua->setSenhaAdm($item['senha_adm']);
            
    
            $array[] = $ua;
        }
        return $array;
    }

    public function findByEmail($email_adm) {
        $array = [];

        $email = $email_adm;

        $sql = $this->pdo->query("SELECT * FROM usuarios_administrador WHERE email_adm = '".$email."';");
        
      

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        foreach($data as $item) {
            $ua = new UsuarioAdministrador;
            $ua->setIdAdm($item['id_adm']);
            $ua->setNomeAdm($item['nome_adm']);
            $ua->setEmailAdmCtt($item['email_adm_ctt']);
            $ua->setEmailAdm($item['email_adm']);
            $ua->setTelefoneAdm($item['telefone_adm']);
            $ua->setSenhaAdm($item['senha_adm']);
            
    
            $array[] = $ua;
        }

        return $array;
    }
}

?>