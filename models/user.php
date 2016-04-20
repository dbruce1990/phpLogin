<?php
require_once 'base.php';
class UserModel extends BaseModel{
  private $id = null;
  private $username = null;
  private $password = null;
  private $last_login = null;

  public function __construct(){
    parent::__construct();
  }

  public function getId(){ return $this-id; }
  public function setId($id){ $this->id = $id; }

  public function getUsername(){ return $this->username; }
  public function setUsername($username){
    if($this->validateUsername($username)){
      $this->username = $username;
      return true;
    }
    return false;
  }

  public function getPassword(){ return $this->password; }
  public function setPassword($password, $password_confirmed){
    if($this->validatePasswords($password, $password_confirmed)){
      $this->password = password_hash($password, PASSWORD_DEFAULT); // hash the password
      echo $this->password;
      return true;
    }
    return false;
  }

  public function getLastLogin(){ return $this->last_login; }
  public function setLastLogin($date){ $this->last_login = $date; }

  public function getSafe(){
    $result = array();
    $result["id"] = $this->id;
    $result["username"] = $this->username;
    $result["password"] = $this->password;
    $result["last_login"] = $this->last_login;
    return $result;
  }

  public function create(){
    try{
      $stmt = $this->pdo->prepare("INSERT INTO users (user_name, password_hash) VALUES (?, ?)"); // Prepare SQL statement for execution
      $params = array($this->username, $this->password);
      if($stmt->execute($params)){ // try and execute statement with supplied params
        $this->id = $this->pdo->lastInsertId(); // if statement was executed successsfuly we can get ID
        return true;
      }
    }catch(PDOException $e){
      $this->db->errorHandler($e);
      exit();
    }
    return false;
  }

  public function authenticate($username, $password){
    try{
      $stmt = $this->pdo->prepare("SELECT password_hash from users WHERE user_name=? LIMIT 1");
      $params = [$username];
      if($stmt->execute($params)){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // print_r($row);
        if(password_verify($password, $row["password_hash"])){
          $stmt = $this->pdo->prepare("UPDATE users SET last_login=NOW() WHERE user_name=?");
          $params = array($username);
          $stmt->execute($params);
          if($stmt->rowCount() > 0){
            return true;
          }
        }
    }
    }catch(PDOException $e){
      $this->db->errorHandler($e);
    }
    return false;
  }

  private function validatePasswords($password, $password_confirmed){
    if($password === $password_confirmed){
      if(gettype($password) == "string"){
        if(!empty($password)){
          $length = strlen($password);
          if($length >= 4 && $length <= 32){
            return true;
          }
        }
      }
    }
    return false;
  }

  private function validateUsername($username){
    if(gettype($username) == "string"){
      if(!empty($username)){
        $length = strlen($username);
        if($length > 4 && $length <= 32){
          return true;
        }
      }
    }
    return false;
  }

}
?>
