<?php

class UsuarioAdministrador {
    private $id_adm;
    private $nome_adm;
    private $email_adm;
    private $telefone_adm;
    private $senha_adm;

    public function getIdAdm() {
        return $this->id_adm;
    }

    public function setIdAdm($ia) {
        $this->id_adm = trim($ia);
    }

    public function getNomeAdm() {
        return $this->nome_adm;
    }

    public function setNomeAdm($na) {
        $this->nome_adm = trim($na);
    }

    public function getEmailAdm() {
        return $this->email_adm;
    }

    public function setEmailAdm($ea) {
        $this->email_adm = trim($ea);
    }

    public function getTelefoneAdm() {
        return $this->telefone_adm;
    }

    public function setTelefoneAdm($ta) {
        $this->telefone_adm = trim($ta);
    }

    public function getSenhaAdm() {
        return $this->senha_adm;
    }

    public function setSenhaAdm($sa) {
        $this->senha_adm = password_hash(trim($sa), PASSWORD_DEFAULT);
    }
}

interface UsuarioAdministradorDAO {
    public function add(UsuarioAdministrador $ua);

    public function findAll();

    public function findById($id_adm);

    public function findByEmail($email_adm);
}
?>