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

  $pos_row = load_pos($pdo, $_REQUEST['profile_id']);
  $edu_row = load_edu($pdo, $_REQUEST['profile_id']);

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

  <h2>Profile information</h2>

  <div>

    <p>First name: <?= htmlentities($row['first_name']) ?></p>
    <p>Last name: <?= htmlentities($row['last_name']) ?></p>
    <p>Email:</br><?= htmlentities($row['email']) ?></p>
    <p>Headline:</br><?= htmlentities($row['headline']) ?></p>
    <p>Summary:</br><?= htmlentities($row['summary']) ?></p>

    <div id="eduFields" style="border: 1px solid black; margin: 10px 0 10px 0; max-width: 500px;">

      <h4>Educations:</h4>

      <?php

        $edu = 0;

        if ($edu_row != false):

          foreach ($edu_row as $education) {
            $edu++;

            echo '<div id="edu' . $edu . '">';
            echo '<p>Year: <span name="edu_year' . $edu . '">' . htmlentities($education['year']) . '</span></p>';
            echo '<p>School: <span name="edu_school' . $edu . '">' . htmlentities($education['name']) . '</span></p>';
            echo '</div>';
          }

        else:
          echo '<p>No educations set</p>';
        endif;

      ?>

    </div>

    <div id="posFields" style="border: 1px solid black; margin: 10px 0 10px 0; max-width: 500px;">

      <h4>Events:</h4>

      <?php

        $pos = 0;

        if ($pos_row != false):

          foreach ($pos_row as $position) {
            $pos++;

            echo '<div id="position' . $pos . '">';
            echo '<p>Year: <span name="year' . $pos . '">' . htmlentities($position['year']) . '</span></p>';
            echo '<p>Event: <span name="desc' . $pos . '">';
            echo htmlentities($position['description']);
            echo '</span></p>';
            echo '</div>';
          }

        else:
          echo '<p>No events set</p>';
        endif;

      ?>

    </div>

    <form method="post">
      <input type="submit" name="done" value="Done" style="display: block; margin-bottom: 15px; margin-top: 15px;">
    </form>

    <div>
      <img style="max-height: 400px;" src="<?= $link ?>" alt="<?= $msg ?>">
    </div>

  </div>

</body>
</html>