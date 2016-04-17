<?php
class DatabaseHandler{
  private static $instance = null;
  private $pdo;

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new DatabaseHandler();
    }
    return self::$instance;
  }

  public function getPDO(){
    if($this->pdo == null){
      $config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . 'phplogin/config.json'), true); // Get config.json as assoc array
      if($config !== false){ // parse $config
        $dsn = $config["database"]["dsn"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];

        try{
          $this->pdo = new PDO($dsn, $username, $password); //if parsing config.json was successful, attempt to connect
          $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $this->setupTables();
        }catch(PDOException $e){
          die("There was an error connecting to the database.");
        }

      }
    }
    return $this->pdo;
  }

  private function __construct(){}

  private function setupTables(){
    $tables = array(
      "usersTable" => "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
        `user_name` VARCHAR(50) NOT NULL UNIQUE,
        `password_hash` VARCHAR(50) NOT NULL,
        `last_login` DATETIME NOT NULL) ENGINE=InnoDB COLLATE utf8_unicode_ci;"
    );
    foreach($tables as $table){
      try{
        $result = $this->pdo->exec($table);
      }catch(PDOException $e){
        die("Couldn't create {$table}");
      }
    }
  }

}
?>
