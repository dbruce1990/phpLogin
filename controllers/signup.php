<?php
header("Content-type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  require_once '../models/response.php';
  require_once '../models/user.php';
  // $dbh = DatabaseHandler::getInstance();
  // $pdo = $dbh->getPDO();

  $response = new Response(false);

  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    $model = new UserModel();
    if($model->setPassword($_POST['password'], $_POST['password_confirmed'])){
      if($model->setUsername($_POST['username'])){
        if($model->create()){
          $response->setSuccess(true);
          $response->setData($model->getSafe());
        }
      }else{
        $response->setMessage("Invalid username.");
      }
    }else{
      $response->setMessage("Invalid password.");
    }
  }
  echo $response;
}
?>
