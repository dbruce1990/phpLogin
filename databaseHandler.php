<?php
class DatabaseHandler{
  private static $instance = null;
  private $pdo;
  private $user;
  private $pass;

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new DatabaseHandler();
    }
    return self::$instance;
  }

  public function getPDO(){
    if($this->pdo != null){
      return $this->pdo;
    }
  }

  private function __construct(){
    $config = json_decode(file_get_contents('config.json'), true);
    if($config !== false){
      $dsn = $config["database"]["dsn"];
      $username = $config["database"]["username"];
      $password = $config["database"]["password"];

      try{
        $this->pdo = new PDO($dsn, $username, $password);
        $this->createTables();
      }catch(PDOException $e){
        die("There was an error connecting to the database.");
      }
    }
  }

  private function createTables(){
    $tables = array(
      "usersTable" => "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `user_name` VARCHAR(50) NOT NULL,
        `password_hash` VARCHAR(50) NOT NULL,
        `last_login` DATETIME NOT NULL) ENGINE=InnoDB COLLATE utf8_unicode_ci;"
    );
    foreach($tables as $table){
      try{
        $result = $this->pdo->exec($table);
        echo $result;
      }catch(PDOException $e){
        die("Couldn't create {$table}");
      }
    }
  }
}
?>
