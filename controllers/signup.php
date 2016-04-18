<?php
session_start();
require_once '../models/response.php';
require_once '../models/user.php';
$dbh = DatabaseHandler::getInstance();
$pdo = $dbh->getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirmed'])){
    $model = new UserModel();
    $model->setUsername($_POST['username']);
    $model->setPassword($_POST['password'], $_POST['password_confirmed']);
    $result = $model->save();
    echo $result;
  }
}
?>
