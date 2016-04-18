<?php
require_once '../databaseHandler.php';

class BaseModel{
  protected $db;
  protected $pdo;

  public function __construct(){
    $this->db = DatabaseHandler::getInstance();
    $this->pdo = $this->db->getPDO();
  }
}
?>
