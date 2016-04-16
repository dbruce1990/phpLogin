<?php
class DatabaseHandler{
  private static $instance = null;
  private $dbh = null;
  private $user = "root";
  private $pass = "";

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new DatabaseHandler();
    }
    return self::$instance;
  }

  public function getDBHandler(){
    if($this->dbh == null){
      $this=>dbh = new PDO('mysql:host=localhost;dbname=phpLogin', $this->user, $this->pass);
    }
    else{
      return $this->dbh;
    }
  }

  private function __construct(){

  }

  private function init(){

  }

  private function createTables(){
    $tables = array(
      "usersTable" => "CREATE TABLE IF NOT EXISTS `phpLogin`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `user_name` VARCHAR NOT NULL , `password_hash` VARCHAR NOT NULL , `last_login` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
    );
  }
}
?>
