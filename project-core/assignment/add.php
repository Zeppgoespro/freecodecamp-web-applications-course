<?php

  require_once './pdo.php';
  session_start();
  require_once './util.php';
  authorization(); # from util.php

  if (isset($_POST['cancel_add'])) {
    header('location: ../assignment.php');
    return;
  }

  # Some data validation from util.php - validate_data() & validate_pos() & validate_edu()

  if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])):

    $msg = validate_data();

    if (is_string($msg)) {
      $_SESSION['error'] = $msg;
      header('location: add.php');
      return;
    }

    $msg = validate_pos();

    if (is_string($msg)) {
      $_SESSION['error'] = $msg;
      header('location: add.php');
      return;
    }

    $msg = validate_edu();

    if (is_string($msg)) {
      $_SESSION['error'] = $msg;
      header('location: add.php');
      return;
    }

    $sql = "INSERT INTO profiles (user_id, first_name, last_name, email, headline, link, summary) VALUES (:uid, :fn, :ln, :em, :hl, :lk, :sum)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':uid'  => $_SESSION['user_id'],
      ':fn'   => $_POST['first_name'],
      ':ln'   => $_POST['last_name'],
      ':em'   => $_POST['email'],
      ':hl'   => $_POST['headline'],
      ':lk'   => $_POST['link'],
      ':sum'  => $_POST['summary']
    ));

    $profile_id = $pdo->lastInsertId();

    # Inserting events (position) entries with util.php

    insert_positions($pdo, $profile_id);

    # Inserting education entries with util.php

    insert_educations($pdo, $profile_id);

    $_SESSION['success'] = 'Profile added successfully';
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

  <h2>Add profile for <?= htmlentities($_SESSION['name']) ?></h2>

  <?php

    # FLash messages

    flash_messages();

  ?>

  <form method="post">
    <p><label for="firstName">First Name:</label>
    <input type="text" name="first_name" id="firstName" size="40"></p>
    <p><label for="lastName">Last Name:</label>
    <input type="text" name="last_name" id="lastName" size="40"></p>
    <p><label for="email">Email:</label><br/>
    <input type="text" name="email" id="email" size="30"></p>
    <p><label for="headline">Headline:</label><br/>
    <input type="text" name="headline" id="headline" size="65"></p>
    <p><label for="link">Image link:</label><br/>
    <input type="url" name="link" id="link" size="65"></p>
    <p><label for="summary">Summary:</label><br/>
    <textarea name="summary" id="summary" rows="10" cols="60"></textarea></p>
    <p>Educations: <input type="submit" id="addEdu" value="+" style="font-weight: 700;"></p>
    <div id="eduFields"></div>
    <p>Events: <input type="submit" id="addPos" value="+" style="font-weight: 700;"></p>
    <div id="posFields"></div>
    <p>
      <input type="submit" value="Add">
      <input type="submit" name="cancel_add" value="Cancel">
    </p>
  </form>

  <script>

    let countPos = 0;
    let countEdu = 0;

    $(document).ready(function() {
      window.console && console.log('Document ready!');
      $('#addPos').click(function(event) {
        event.preventDefault();
        if ( countPos >= 4 ) {
          alert('Maximum of four event entries exceeded');
          return;
        }
        countPos++;
        window.console && console.log("Adding event " + countPos);
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
        $('#eduFields').append(
          '<div id="edu' + countEdu + '"> \
          <p>Year: <input type="text" name="edu_year' + countEdu + '" value=""> \
          <input type="button" value="-" onclick="$(\'#edu' + countEdu + '\').remove(); return false;" style="font-weight: 700;"></p> \
          <p>School: <input type="text" size="60" name="edu_school' + countEdu + '" class="school" value=""> \
          </p></div>'
        );

        $('.school').autocomplete({
          source: './school.php'
        });
      });
    });

  </script>

</body>
</html>