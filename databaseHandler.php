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
        $dbname= $config["database"]["dbname"];
        $username = $config["database"]["username"];
        $password = $config["database"]["password"];

        try{
          $this->pdo = new PDO($dsn, $username, $password); //if parsing config.json was successful, attempt to connect
          $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $this->pdo->query("CREATE DATABASE IF NOT EXISTS $dbname DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci; SET default_storage_engine=INNODB;");
          $this->pdo->query("use $dbname;");
          $this->setupTables();
        }catch(PDOException $e){
          // die("There was an error connecting to the database.");
          $this->errorHandler($e);
        }

      }
    }
    return $this->pdo;
  }

  private function __construct(){}

    private function setupTables(){
      $tables = array(
        "usersTable" => "CREATE TABLE IF NOT EXISTS `users` (
          `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY UNIQUE,
          `user_name` VARCHAR(32) NOT NULL UNIQUE,
          `password_hash` VARCHAR(255) NOT NULL,
          `last_login` DATETIME DEFAULT NOW() NOT NULL);",
          "deleteMe" => "CREATE TABLE IF NOT EXISTS deleteMe (x VARCHAR(10), y VARCHAR(10), z VARCHAR(10));"
        );
        foreach($tables as $table){
          try{
            $result = $this->pdo->exec($table);
          }catch(PDOException $e){
            // die("Couldn't create $table");
            $this->errorHandler($e);
          }
        }
      }

      public function errorHandler($e){
        switch($e->getCode()){
          case "23000": //duplicate found.
          // echo new Response(false, "Username already taken.", $e, $e->getCode());
          http_response_code(409);
          break;
          default:
          // echo new Response(false, "Woops, an error occured in the database.", $e, $e->getCode());
          http_response_code(500);
        }
      }

    }
    ?>
