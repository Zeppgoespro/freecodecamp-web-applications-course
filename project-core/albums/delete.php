<?php

  require_once './pdo.php';
  session_start();

  if (isset($_POST['cancel'])):
    header('location: ../albums.php');
    return;
  endif;

  if (isset($_POST['delete']) && isset($_POST['album_id'])):
    $sql = 'DELETE FROM albums WHERE album_id = :aid';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':aid' => $_POST['album_id']));

    $_SESSION['success'] = 'Album deleted';
    header('location: ../albums.php');
    return;
  endif;

  # Guardian: some validation for album_id

  if (!isset($_GET['album_id'])):
    $_SESSION['error'] = 'Missing album id';
    header('location: ../albums.php');
    return;
  endif;

  $sql = "SELECT * FROM albums WHERE album_id = :aid";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':aid' => $_GET['album_id']));
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row === false):
    $_SESSION['error'] = 'Bad value for album id';
    header('location: ../albums.php');
    return;
  endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete album</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <p>You want to delete <b style="color: indigo;"><?= $row['title'] ?></b>?</p>

  <form action="delete.php" method="post">
    <input type="hidden" name="album_id" value="<?= $row['album_id'] ?>">
    <input type="submit" name="delete" value="Delete">
    <input type="submit" name="cancel" value="Cancel">
  </form>

</body>
</html>