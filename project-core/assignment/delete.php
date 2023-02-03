<?php

  require_once './pdo.php';

  session_start();

  require_once './util.php';

  authorization(); # from util.php

  if (isset($_POST['cancel_delete'])) {
    header('location: ../assignment.php');
    return;
  }

  if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = 'There is no selected profile';
    header('location: ../assignment.php');
    return;
  }

  if (isset($_POST['delete']) && isset($_POST['profile_id'])) {
    $sql = "DELETE FROM profiles WHERE profile_id = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':pid' => $_POST['profile_id']));

    $_SESSION['success'] = 'Profile successfully deleted';
    header('location: ../assignment.php');
    return;
  }

  $stmt = $pdo->prepare("SELECT first_name, last_name FROM profiles WHERE profile_id = :pid AND user_id = :uid");
  $stmt->execute(array(':pid' => $_GET['profile_id'], ':uid' => $_SESSION['user_id']));
  $row_count = $stmt->rowCount();

  if  ($row_count == 0):
    $row = [
      'first_name' => '',
      'last_name' => ''
    ];

    $_SESSION['error'] = 'This profile not belong to your account or not existed';
    header('location: ../assignment.php');
    return;
  else:
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row === false):
      $_SESSION['error'] = 'There is no such profile';
      header('location: ../assignment.php');
      return;
    endif;
  endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './head.php' ?>
</head>
<body>

  <h1>Deleting profile</h1>

  <form method="post" action="delete.php">
    <input type="hidden" name="profile_id" value="<?= $_GET['profile_id'] ?>">
    <p>Profile name: <?= htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']) ?></p>
    <div>
      <input type="submit" name="delete" value="Delete">
      <input type="submit" name="cancel_delete" value="Cancel">
    </div>
  </form>

</body>
</html>