<?php
class UserService
{
    private $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function get_all() {
        return $this->dao->get_all();
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
