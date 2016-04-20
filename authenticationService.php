<?php
class APIKeyGen{
  private static $instance = null;

  private function __construct(){}

    public static function getInstance()
    {
      if (self::$instance == null) {
        self::$instance = new APIKeyGen();
      }
      return self::$instance;
    }



    public function generateApiKey(){
      $key = $this->getRandomKey();
      $ip = $
    }

    private function getRandomKey(){
      $key = "";
      return $key;
    }
}
?>
