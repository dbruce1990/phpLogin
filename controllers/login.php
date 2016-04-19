<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password'])){
    session_start();

    require_once '../databaseHandler.php';
    $dbh = DatabaseHandler::getInstance();
    $pdo = $dbh->getPDO();

    try{
      $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name=? AND password_hash=? LIMIT 1;");
      $params = array($_POST["username"], $_POST["password"]);
      if($stmt->execute($params)){
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($results) > 0){
          echo new Response(true, null, $results);
        }else{
          echo new Response(false, "Invalid username or password.");
        }
      }
    }catch(PDOException $e){
      // echo $e-getCode();
    }
  }else{
    echo new Response(false, "Woops something went wrong while trying to log you in.");
  }
}
?>
