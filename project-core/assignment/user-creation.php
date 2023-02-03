<?php

  require_once './pdo.php';

  session_start();

  require_once './util.php';

  if (isset($_POST['return'])):
    unset($_SESSION['page']);
    unset($_SESSION['error']);
    header('location: ../assignment.php');
    return;
  endif;

  if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])):

    if (strlen($_POST['name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
      $_SESSION['error'] = 'Need to enter all required information';
      header('location: ./user-creation.php');
      return;
    } elseif (strpos($_POST['email'], '@') == false) {
      $_SESSION['error'] = 'This is not an email, pls enter correct email';
      header('location: ./user-creation.php');
      return;
    }

    $hashed_password = md5($_POST['password']);

    $sql = "INSERT INTO users (name, email, password) VALUES (:nm, :em, :pw)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':nm'=> $_POST['name'],
      ':em'=> $_POST['email'],
      ':pw'=> $hashed_password
    ));

    $_SESSION['success'] = 'User created';
    header('location: ../assignment.php');
    return;

  endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './head.php' ?>
</head>
<body>

  <?php

  # FLash messages

  flash_messages();

  ?>

  <h1>Create new user</h1>

  <form method="post">
    <p>Account name:<br/><input type="text" name="name" placeholder="Enter account name" size="30"></p>
    <p>Email:<br/><input type="email" name="email" placeholder="Enter email" size="30"></p>
    <p>Password:<br/><input type="password" name="password" placeholder="Enter new password" size="30"></p>
    <div>
      <input type="submit" value="Create">
      <input type="submit" name="return" value="Cancel">
    </div>
  </form>

</body>
</html>