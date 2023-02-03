<?php

require_once './pdo.php';
session_start();

if (isset($_POST['delete']) && isset($_POST['user_id'])):

  $sql = "DELETE FROM users WHERE user_id = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['user_id']));

  $_SESSION['success'] = 'Record deleted';
  header('location: ../crud.php');
  return;

endif;

# Guardian: some validation for user_id

if (!isset($_GET['user_id'])):
  $_SESSION['error'] = 'Missing user id';
  header('location: ../crud.php');
  return;
endif;

$stmt = $pdo->prepare("SELECT name, user_id FROM users where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false):
  $_SESSION['error'] = 'Bad value for user id';
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
  <title>Deletion</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

<p style="margin: 30px 0 10px 0;">Confirm deleting - Name: <?= htmlentities($row['name']) ?></p>
<p style="margin: 10px 0 30px 0;">Confirm deleting - ID: <?= htmlentities($row['user_id']) ?></p>

<form method="post">
  <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
  <input type="submit" value="Delete" name="delete">
  <p><a href="../crud.php">Cancel</a></p>
</form>

</body>
</html>