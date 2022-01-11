<?php

class RelatorioUsuarios {
    private $id_rel;
    private $name_link_rel;
    private $link_rel;
    private $data_rel;

    public function getIdRel() {
        return $this->id_rel;
    }

    public function setIdRel($ir) {
        $this->id_rel = trim($ir);
    }

    public function getNameLinkRel() {
        return $this->name_link_rel;
    }

    public function setNameLinkRel($nlr) {
        $this->name_link_rel = trim($nlr);
    }

    public function getLinkRel() {
        return $this->link_rel;
    }

    public function setLinkRel($lr) {
        $this->link_rel = trim($lr);
    }

    public function getDataRel() {
        return $this->data_rel;
    }

    public function setDataRel($dr) {
        $this->data_rel = trim($dr);
    }
}

interface RelatorioUsuariosDAO {
    public function add(RelatorioUsuarios $ru);

    public function findAll();

    public function verifyRowByLink($link_rel);

    public function delete($id_rel);
}
?>