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

    $sql = 'INSERT INTO albums (title, year, songs) VALUES (:tt, :yr, :sg)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':tt' => $_POST['title'],
      ':yr' => $_POST['year'],
      ':sg' => $_POST['songs']
    ));

    $_SESSION['success'] = 'Album added';
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
  <title>Add album</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <?php

    # Flash message

    switch (isset($_SESSION['error'])):
      case true:
        echo '<p style="color: crimson">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    endswitch;

  ?>

  <h2>Adding album into database</h2>

  <form method="post" action="add.php">
    <p><input type="text" name="title" size="40" placeholder="Enter album's name"></p>
    <p><input type="number" name="year" min="1900" placeholder="Enter album's year"></p>
    <p><input type="number" name="songs" min="1" placeholder="Enter songs count"></p>
    <p><input type="submit" value="Add"> <input type="submit" name="cancel" value="Cancel"></p>
  </form>

</body>
</html>