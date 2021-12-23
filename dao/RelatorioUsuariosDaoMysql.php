<?php

require_once 'models/RelatorioUsuarios.php';

class RelatorioUsuariosDaoMysql implements RelatorioUsuariosDAO {
    private $pdo;

    public function __construct($drivers) {
        $this->pdo = $drivers;
    }

    public function add(RelatorioUsuarios $ru) {
        $sql = $this->pdo->prepare('INSERT INTO 
        relatorio_usuarios(link_rel, data_rel)
            VALUES
        (:link_rel, :data_rel);');

        $sql->bindValue(':link_rel', $ru->getLinkRel());
        $sql->bindValue(':data_rel', $ru->getDataRel());
        $sql->execute();

        return $ru;
    }

    public function findAll() {
        $array = [];

        $sql = $this->pdo->query('SELECT * FROM relatorio_usuarios');

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $ru = new RelatorioUsuarios;
                $ru->setIdRel($item['id_rel']);
                $ru->setLinkRel($item['link_rel']);
                $ru->setDataRel($item['data_rel']);
    
                $array[] = $ru;
            }
            return $array;
        } else {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $ru = new RelatorioUsuarios;
                $ru->setIdRel($item['']);
                $ru->setLinkRel($item['']);
                $ru->setDataRel($item['']);
    
                $array[] = $ru;
            }
            return $array;
        }

        
    }

    public function delete($id_rel) {

        $id = $id_rel;

        $sql = $this->pdo->prepare('DELETE FROM relatorio_usuarios WHERE id_rel ='.$id.';');
        $sql->execute();
    }
}
?>