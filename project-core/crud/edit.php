<?php

require_once './pdo.php';
session_start();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['user_id'])):

  # Data validation should go here

  $sql = "UPDATE users SET name = :name, email = :email, password = :password WHERE user_id = :user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':name'     => $_POST['name'],
    ':email'    => $_POST['email'],
    ':password' => $_POST['password'],
    ':user_id'  => $_POST['user_id']
  ));
  $_SESSION['success'] = 'Record updated';
  header('location: ../crud.php');
  return;
endif;

$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :xyz");
$stmt->execute(array(':xyz' => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

switch ($row === false):
  case true:
    $_SESSION['error'] = 'Bad value for user id';
    header('location: ../crud.php');
    return;
  break;
endswitch;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <?php
    $n = htmlentities($row['name']);
    $e = htmlentities($row['email']);
    $p = htmlentities($row['password']);
    $user_id = $row['user_id'];
  ?>

  <h3>Edit user</h3>

  <form method="post">
    <p><input type="text" name="name" value="<?= $n ?>"></p>
    <p><input type="email" name="email" value="<?= $e ?>"></p>
    <p><input type="password" name="password" value="<?= $p ?>"></p>
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <p><input type="submit" value="Update"></p>
    <p><a href="../crud.php">Cancel</a></p>
  </form>

</body>
</html>