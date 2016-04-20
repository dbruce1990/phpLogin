<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    require_once '../models/user.php';
    session_start();
    header("Content-type: application/json");

    $model = new UserModel();
    if($model->setPassword($_POST['password'], $_POST['password_confirmed'])){
      if($model->setUsername($_POST['username'])){
        if($model->create()){
          http_response_code(200);
          echo json_encode($model->getSafe());
        }
      }
    }else{
      http_response_code(400);
      echo json_encode(["error", "Woops. Ensure all required fields are filled out and try again."]);
    }

  }
}
?>
