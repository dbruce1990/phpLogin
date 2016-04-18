<?php
require_once 'base.php';
class UserModel extends BaseModel{
  private $id;
  private $username;
  private $password;
  private $last_login;

  public function __construct(){
    parent::__construct();
  }

  public function getId(){ return $this-id; }
  public function setId($id){
    if(!empty($id)){
      $this->id = $id;
    }
  }

  public function getUsername(){ return $this->username; }
  public function setUsername($username){
    if(!empty($username)){
      $this->username = $username;
    }
  }

  public function getPassword(){ return $this->password; }
  public function setPassword($password, $password_confirmed){
    if(!empty($password) && !empty($password_confirmed) && $password === $password_confirmed){
      $this->password = $password;
    }
  }

  public function getLastLogin(){ return $this->last_login; }
  public function setLastLogin($date){
    if(!empty($date)){
      $this->last_login = $date;
    }
  }

  public function safe(){
    $result = array(
      "username" => $this->username
    );
    return $result;
  }

  public function save(){
    try{
      $stmt = $this->pdo->prepare("INSERT INTO `users` (`user_name`, `password_hash`) VALUES (?, ?)");
      $params = array($this->username, $this->password);
      if($stmt->execute($params)){
        $this->id = $this->pdo->lastInsertId();
        return new Response(true, "Successfuly created new User.", $this->safe(), null);
      }
      return new Response(false, "Couldn't create new User.", null, null);
    }catch(PDOException $e){
      return $this->db->errorHandler($e);
    }
  }
}
?>
