<?php

  require_once './pdo.php';

  session_start();

  require_once './util.php';

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

<p>
<?php

switch (isset($_SESSION['user_id'])):
  case true:
    echo '<p><a href="../assignment.php" style="color: crimson;">Return to user\'s profiles</a></p>';
    echo '<p><a href="./add.php" style="color: green;">Add New Entry</a></p>';
  break;
  case false:
    echo '<p><a href="./login.php" style="color: green;">Please Log In</a></p>';
    echo '<p><a href="./user-creation.php" style="color: green;">Create new user</a></p>';
  break;
endswitch;

?>
</p>

<?php

if (isset($_SESSION['user_id'])):

  echo '<table border="1">';
  echo '<tr><th>Name</th><th>Headline</th><th>Summary</th><th>Picture</th><th>Action</th></tr>';

  $stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, headline, link, summary FROM profiles");

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):

    $url_parts = parse_url($row['link']);
    $url_parts['scheme'] = isset($url_parts['scheme']) === true ? $url_parts['scheme'] : 'empty';

    if ($url_parts['scheme'] === 'https' || $url_parts['scheme'] === 'http') {
      $link = curling($row['link']); # caurling() from util.php
      $msg = 'This is profile image';
    } else {
      $link = '';
      $msg = 'There is no picture set for this profile';
    }

    echo '<tr><td>';
    echo '<a href="./assignment/view.php?profile_id=' . $row['profile_id'] . '">' . htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']) . '</a>';
    echo '</td><td>';
    echo htmlentities($row['headline']);
    echo '</td><td>';
    echo htmlentities($row['summary']);
    echo '</td><td style="display: flex; align-items: center; justify-content: space-around;">';
    echo '<img style="max-height: 110px;" src="' . $link . '" alt="' . $msg . '">';
    echo '</td><td>';

    switch ($_SESSION['user_id'] === $row['user_id']):
      case true:
        echo '<a href="./edit.php?profile_id=' . $row['profile_id'] . '">Edit</a> | ';
        echo '<a href="./delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>';
      break;
      case false:
        echo '<p style="margin: 0;">Someone\'s profile</p>';
      break;
    endswitch;

    echo '</td></tr>';

  endwhile;

  echo '</table>';

else:

  echo '<table border="1">';
  echo '<tr><th>Name</th><th>Headline</th><th>Summary</th><th>Picture</th></tr>';

  $stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline, link, summary FROM profiles");

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):

    $url_parts = parse_url($row['link']);
    $url_parts['scheme'] = isset($url_parts['scheme']) === true ? $url_parts['scheme'] : 'empty';

    if ($url_parts['scheme'] === 'https' || $url_parts['scheme'] === 'http') {
      $link = curling($row['link']); # caurling() from util.php;
      $msg = 'This is profile image';
    } else {
      $link = '';
      $msg = 'There is no picture set for this profile';
    }

    echo '<tr><td>';
    echo '<a href="./assignment/view.php?profile_id=' . $row['profile_id'] . '">' . htmlentities($row['first_name']) . ' ' . htmlentities($row['last_name']) . '</a>';
    echo '</td><td>';
    echo htmlentities($row['headline']);
    echo '</td><td>';
    echo htmlentities($row['summary']);
    echo '</td><td style="display: flex; align-items: center; justify-content: space-around;">';
    echo '<img style="max-height: 110px;" src="' . $link . '" alt="' . $msg . '">';
    echo '</td></tr>';
  endwhile;

  echo '</table>';

endif;

?>

</body>
</html>