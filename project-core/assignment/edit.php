<?php

  require_once './pdo.php';

  session_start();

  require_once './util.php';

  authorization(); # from util.php

  if (isset($_POST['cancel_edit'])) {
    header('location: ../assignment.php');
    return;
  }

  if (!isset($_REQUEST['profile_id'])) {
    $_SESSION['error'] = 'There is no selected profile';
    header('location: ../assignment.php');
    return;
  }

  # Some data validation from util.php - validate_data() & validate_pos() & validate_edu()

  if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])):

    $msg = validate_data();

    if (is_string($msg)) {
      $_SESSION['error'] = $msg;
      header('location: edit.php?profile_id=' . $_REQUEST['profile_id']);
      return;
    }

    $msg = validate_pos();

    if (is_string($msg)) {
      $_SESSION['error'] = $msg;
      header('location: edit.php?profile_id=' . $_REQUEST['profile_id']);
      return;
    }

    $msg = validate_edu();

    if (is_string($msg)) {
      $_SESSION['error'] = $msg;
      header('location: edit.php?profile_id=' . $_REQUEST['profile_id']);
      return;
    }

    $sql = "UPDATE profiles SET first_name = :fn, last_name = :ln, email = :em, headline = :hl, link = :lk, summary = :sum WHERE user_id = :uid AND profile_id = :pid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':uid'  => $_POST['user_id'],
      ':pid'  => $_REQUEST['profile_id'],
      ':fn'   => $_POST['first_name'],
      ':ln'   => $_POST['last_name'],
      ':em'   => $_POST['email'],
      ':hl'   => $_POST['headline'],
      ':lk'   => $_POST['link'],
      ':sum'  => $_POST['summary']
    ));

    # Clearing out the old events (position) entries

    $pos_stmt = $pdo->prepare('DELETE FROM positions WHERE profile_id = :pid');
    $pos_stmt->execute(array('pid' => $_REQUEST['profile_id']));

    # Inserting new events (position) entries with util.php

    insert_positions($pdo, $_REQUEST['profile_id']);

    # Clearing out the old education entries

    $stmt = $pdo->prepare('DELETE FROM educations WHERE profile_id = :pid');
    $stmt->execute(array(':pid' => $_REQUEST['profile_id']));

    # Inserting new education entries with util.php

    insert_educations($pdo, $_REQUEST['profile_id']);

    $_SESSION['success'] = 'Profile edited successfully';
    header('location: ../assignment.php');
    return;

  endif;

  # Loading up the profile

  $sql = "SELECT * FROM profiles WHERE profile_id = :pid AND user_id = :uid";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':pid'  => $_GET['profile_id'], ':uid' => $_SESSION['user_id']));
  $row_count = $stmt->rowCount();

  if ($row_count == 0):
    $row = [
      'user_id' => '',
      'first_name' => '',
      'last_name' => '',
      'email' => '',
      'headline' => '',
      'link' => '',
      'summary' => ''
    ];

    $_SESSION['error'] = 'This profile not belong to your account or not existed';
    header('location: ../assignment.php');
    return;
  else:
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

  endif;

  # Loading up the events (positions) and educations with util.php functions

  $pos_row = load_pos ($pdo, $_REQUEST['profile_id']);
  $edu_row = load_edu ($pdo, $_REQUEST['profile_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './head.php' ?>
</head>
<body>

  <h1>Editing profile for <?= htmlentities($_SESSION['name']) ?></h1>

  <?php

    # FLash messages

    flash_messages();

  ?>

  <form method="post" action="edit.php">
    <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
    <input type="hidden" name="profile_id" value="<?= $_REQUEST['profile_id'] ?>">
    <p><label for="firstName">First Name:</label>
    <input type="text" name="first_name" id="firstName" size="40" value="<?= htmlentities($row['first_name']) ?>"></p>
    <p><label for="lastName">Last Name:</label>
    <input type="text" name="last_name" id="lastName" size="40" value="<?= htmlentities($row['last_name']) ?>"></p>
    <p><label for="email">Email:</label><br/>
    <input type="text" name="email" id="email" size="30" value="<?= htmlentities($row['email']) ?>"></p>
    <p><label for="headline">Headline:</label><br/>
    <input type="text" name="headline" id="headline" size="65" value="<?= htmlentities($row['headline']) ?>"></p>
    <p><label for="link">Image link:</label><br/>
    <input type="url" name="link" id="link" size="65" value="<?= htmlentities($row['link']) ?>"></p>
    <p><label for="summary">Summary:</label><br/>
    <textarea name="summary" id="summary" rows="10" cols="60"><?= htmlentities($row['summary']) ?></textarea></p>
    <p>Educations: <input type="submit" id="addEdu" value="+" style="font-weight: 700;"></p>
    <div id="eduFields">

      <?php
        $edu = 0;

        if ($edu_row != false):

          foreach ($edu_row as $education) {
            $edu++;

            echo '<div id="edu' . $edu . '">';
            echo '<p>Year: <input type="text" name="edu_year' . $edu . '" value="' . htmlentities($education['year']) . '"> <input type="button" value="-" onclick="$(\'#edu' . $edu . '\').remove(); return false;" style="font-weight: 700;"></p>';
            echo '<p>School: <input type="text" size="60" name="edu_school' . $edu . '" class="school" value="' . htmlentities($education['name']) . '"></p>';
            echo '</div>';
          }

        endif;

      ?>

    </div>
    <p>Events: <input type="submit" id="addPos" value="+" style="font-weight: 700;"></p>
    <div id="posFields">

      <?php
        $pos = 0;

        if ($pos_row != false):

          foreach ($pos_row as $position) {
            $pos++;

            echo '<div id="position' . $pos . '">';
            echo '<p>Year: <input type="text" name="year' . $pos . '" value="' . htmlentities($position['year']) . '"> <input type="button" value="-" onclick="$(\'#position' . $pos . '\').remove(); return false;" style="font-weight: 700;"></p>';
            echo '<textarea name="desc' . $pos . '" rows="4" cols="60">';
            echo htmlentities($position['description']);
            echo '</textarea>';
            echo '</div>';
          }

        endif;

      ?>

    </div>
    <p>
      <input type="submit" value="Edit">
      <input type="submit" name="cancel_edit" value="Cancel">
    </p>
  </form>

  <div>
    <p>Current profile picture:</p>
    <img style="max-height: 400px;" src="<?= $link ?>" alt="<?= $msg ?>">
  </div>

  <script>

    let countPos = <?= $pos ?>;
    let countEdu = <?= $edu ?>;

    $(document).ready(function() {
      window.console && console.log('Document ready!');
      $('#addPos').click(function(event) {
        event.preventDefault();
        if ( countPos >= 4 ) {
          alert("Maximum of four position entries exceeded");
          return;
        }
        countPos++;
        window.console && console.log("Adding position " + countPos);
        $('#posFields').append(
          '<div id="position' + countPos + '"> \
          <p>Year: <input type="text" name="year' + countPos + '" value=""> \
          <input type="button" value="-" onclick="$(\'#position' + countPos + '\').remove(); return false;" style="font-weight: 700;"></p> \
          <textarea name="desc' + countPos + '" rows="4" cols="60"></textarea> \
          </div>'
        );
      });

      $('#addEdu').click(function(event) {
        event.preventDefault();
        if (countEdu >= 4) {
          alert('Maximum of four education entries exceeded');
          return;
        }
        countEdu++;
        window.console && console.log("Adding education " + countEdu);
        let source = $("#edu-template").html();
        $('#eduFields').append(source.replace(/@COUNT@/g, countEdu));
        $('.school').autocomplete({
          source: './school.php'
        });
      });

      $('.school').autocomplete({
          source: './school.php'
        });

    });

  </script>
  <script id="edu-template" type="text">
    <div id="edu@COUNT@">
      <p>Year: <input type="text" name="edu_year@COUNT@" value="">
      <input type="button" value="-" onclick="$('#edu@COUNT@').remove(); return false;" style="font-weight: 700;">
      <br>
      <p>School: <input type="text" size="60" name="edu_school@COUNT@" class="school" value=""></p>
    </div>
  </script>

</body>
</html>