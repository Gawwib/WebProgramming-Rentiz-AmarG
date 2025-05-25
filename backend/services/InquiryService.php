<?php
class InquiryService {
    private $dao;

    public function __construct() {
        $this->dao = new InquiryDAO(Flight::get('pdo'));
    }

    public function get_all() {
        return $this->dao->getAll();
    }

    public function get_by_id($id) {
        return $this->dao->getById($id);
    }

    public function add($data) {
        return $this->dao->create($data);
    }

    public function update($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}

?>
