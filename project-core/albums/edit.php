<?php

  require_once './pdo.php';
  session_start();

  if (isset($_POST['cancel'])):
    header('location: ../albums.php');
    return;
  endif;

  if (isset($_POST['title']) && isset($_POST['year']) && isset($_POST['songs'])):

    # Validation

    if (strlen($_POST['title'] < 1) || $_POST['year'] < 1 || $_POST['songs'] < 1):
      $_SESSION['error'] = "Enter all required data";
      header('location: ./add.php');
      return;
    endif;

    $sql = 'UPDATE albums SET title = :tt, year = :yr, songs = :sg WHERE album_id = :aid';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':aid'  => $_POST['album_id'],
      ':tt'   => $_POST['title'],
      ':yr'   => $_POST['year'],
      ':sg'   => $_POST['songs']
    ));

    $_SESSION['success'] = 'Album edited';
    header('location: ../albums.php');
    return;

  endif;

  $stmt = $pdo->prepare("SELECT * FROM albums WHERE album_id = :aid");
  $stmt->execute(array(':aid' => $_GET['album_id']));
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
  <title>Add album</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <?php
    $t = htmlentities($row['title']);
    $y = htmlentities($row['year']);
    $s = htmlentities($row['songs']);
    $album_id = $row['album_id'];
  ?>

  <?php

    # Flash message

    switch (isset($_SESSION['error'])):
      case true:
        echo '<p style="color: crimson">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
      break;
    endswitch;

  ?>

  <h2>Editing current album</h2>

  <form method="post" action="edit.php">
    <input type="hidden" name="album_id" value="<?= $album_id ?>">
    <p><input type="text" name="title" size="40" value="<?= $t ?>"></p>
    <p><input type="number" name="year" min="1900" value="<?= $y ?>"></p>
    <p><input type="number" name="songs" min="1" value="<?= $s ?>"></p>
    <p><input type="submit" value="Edit"> <input type="submit" name="cancel" value="Cancel"></p>
  </form>

</body>
</html>