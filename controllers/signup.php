<?php
header("Content-type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  session_start();
  require_once '../models/user.php';

  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    $model = new UserModel();
    if($model->setPassword($_POST['password'], $_POST['password_confirmed'])){
      if($model->setUsername($_POST['username'])){
        if($model->create()){
          http_response_code(200);
          echo json_encode($model->getSafe());
        }
      }
    }
  }
}
?>
