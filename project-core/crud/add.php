<?php

require_once './pdo.php';
session_start();

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])):

  # Some validation

  if (strlen($_POST['name']) < 1 || strlen($_POST['password']) < 1) {
    $_SESSION['error'] = 'Missing data';
    header('location: add.php');
    return;
  } elseif (strpos($_POST['email'], '@') === false) {
    $_SESSION['error'] = 'Bad data';
    header('location: add.php');
    return;
  }

  $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':name'     => $_POST['name'],
    ':email'    => $_POST['email'],
    ':password' => $_POST['password']
  ));
  $_SESSION['success'] = 'Record added';
  header('location: ../crud.php');
  return;
endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New user creation</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <h3>Add a New User</h3>

  <?php

    # Flash message

    if (isset($_SESSION['error'])):
      echo '<p style="color:red">' . $_SESSION['error'] . '</p><br/>';
      unset($_SESSION['error']);
    endif;

  ?>

  <form method="post">
    <p>Name: <input type="text" name="name"></p>
    <p>Email: <input type="email" name="email"></p>
    <p>Password: <input type="password" name="password"></p>
    <p><input type="submit" value="Add New"></p>
    <a href="../crud.php">Cancel</a>
  </form>

</body>
</html>