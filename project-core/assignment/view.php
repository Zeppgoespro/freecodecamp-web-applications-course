<?php

  require_once './pdo.php';

  session_start();

  require_once './util.php';

  $sql = "SELECT * FROM profiles where profile_id = :pid";
  $stmt = $pdo->prepare($sql);
  $stmt-> execute(array(':pid' => $_GET['profile_id']));

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  $url_parts = parse_url($row['link']);
  $url_parts['scheme'] = isset($url_parts['scheme']) === true ? $url_parts['scheme'] : 'empty';

  if ($url_parts['scheme'] === 'https' || $url_parts['scheme'] === 'http') {
    $link = curling($row['link']); # caurling() from util.php;
    $msg = 'This is profile image';
  } else {
    $link = '';
    $msg = 'There is no picture set for this profile';
  }

  switch (isset($_POST['done'])):
    case true:
      header('location: ../assignment.php');
      return;
    break;
  endswitch;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './head.php' ?>
</head>
<body>

  <h1>Profile information</h1>

  <div>

    <p>First name: <?= htmlentities($row['first_name']) ?></p>
    <p>Last name: <?= htmlentities($row['last_name']) ?></p>
    <p>Email:</br><?= htmlentities($row['email']) ?></p>
    <p>Headline:</br><?= htmlentities($row['headline']) ?></p>
    <p>Summary:</br><?= htmlentities($row['summary']) ?></p>

    <form method="post">
      <input type="submit" name="done" value="Done" style="display: block; margin-bottom: 15px;">
    </form>

    <div>
      <img style="max-height: 400px;" src="<?= $link ?>" alt="<?= $msg ?>">
    </div>

  </div>

</body>
</html>