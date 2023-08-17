<?php

  require_once './assignment/pdo.php';
  session_start();
  require_once './assignment/util.php';

  function print_array($array):string {

    $msg = 'Results found: ';

    for ($i = 0; $i < count($array); $i++) {
      if ($i == count($array) - 1) {
        $msg .= '<a href="./assignment/view.php?profile_id=' . $array[$i]['profile_id'] . '">' . $array[$i]['first_name'] . ' ' . $array[$i]['last_name'] . '</a>';
      } else {
        $msg .= '<a href="./assignment/view.php?profile_id=' . $array[$i]['profile_id'] . '">' . $array[$i]['first_name'] . ' ' . $array[$i]['last_name'] . '</a>' . ', ';
      }
    }
    return $msg;
  }

  if (isset($_POST['search'])):

    $searching_term = htmlentities($_POST['search']);

    if ($searching_term != ''):
      $sql = "SELECT * FROM `profiles` WHERE CONCAT (first_name, ' ', last_name) LIKE :st";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(':st' => "%$searching_term%"));
      $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($row == false) {
        $_SESSION['error'] = 'There is nothing found';
        header('location: ./assignment.php');
        return;
      } else {
        $search_msg = '';
        $search_msg = print_array($row);
        $_SESSION['success'] = $search_msg;
        header('location: ./assignment.php');
        return;
      }
    else:
      unset($searching_term);
      $_SESSION['error'] = 'You need search for something';
      header('location: ./assignment.php');
      return;

    endif;
  endif;

  if (isset($_POST['all_profiles'])):
    header('location: ./assignment/all-profiles.php');
    return;
  endif;

  if (isset($_POST['return'])):
    unset($_SESSION['page']);
    unset($_GET['page']);
    header('location: ./assignment.php?page=1');
    return;
  endif;

  if (isset($_POST['next'])):
    ++$_SESSION['page'];
    header('location: ./assignment.php?page=' . $_SESSION['page']);
    return;
  endif;

  if (isset($_POST['back'])):
    --$_SESSION['page'];
    header('location: ./assignment.php?page=' . $_SESSION['page']);
    return;
  endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './assignment/head.php' ?>
</head>
<body>

  <a href="./home.php" style="font-size: small; color: midnightblue; text-decoration: none;"><< Return to the projects menu</a>

  <h1 style="color: indigo;"><a href="./assignment.php">Huge Next-Gen New Century Application</a></h1>

  <?php

    # FLash messages from util.php

    flash_messages();

  ?>

  <p>
    <?php

    switch (isset($_SESSION['user_id'])):
      case true:
        echo '<p><a href="./assignment/logout.php" style="color: crimson;">Log Out</a></p>';
        echo '<p><a href="./assignment/add.php" style="color: green;">Add New Entry</a></p>';
      break;
      case false:
        echo '<p><a href="./assignment/login.php" style="color: green;">Please Log In</a></p>';
        echo '<p><a href="./assignment/user-creation.php" style="color: green;">Create new user</a></p>';
      break;
    endswitch;

    ?>
  </p>

  <form method="post">
    <input type="search" style="margin: 10px 0" name="search" placeholder="Searh for profiles you need" size="30">
    <input type="submit" value="Search">
  </form>

  <?php

    if (isset($_SESSION['user_id'])):

      echo '<table border="1">';
      echo '<tr><th>Name</th><th>Headline</th><th>Summary</th><th>Picture</th><th>Action</th></tr>';

      $bingo = $_SESSION['user_id'];
      $stmt = $pdo->query("SELECT profile_id, user_id, first_name, last_name, headline, link, summary FROM profiles WHERE user_id = '$bingo'");

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
        echo '<a href="./assignment/edit.php?profile_id=' . $row['profile_id'] . '">Edit</a> | ';
        echo '<a href="./assignment/delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>';
        echo '</td></tr>';
      endwhile;

      echo '</table>';

      echo '<form method="post">';
      echo '<input type="submit" name="all_profiles" value="View all profiles" style="margin-top: 10px;">';
      echo '</form>';

    else:

      echo '<table border="1">';
      echo '<tr><th>Name</th><th>Headline</th><th>Summary</th><th>Picture</th></tr>';

      if (!isset($_SESSION['page'])):
        $_SESSION['page'] = 1;
      endif;

      $sql = "SELECT COUNT(*) as num_rows FROM `profiles`";
      $limit_stmt = $pdo->prepare($sql);
      $limit_stmt->execute();
      $limit_row = $limit_stmt->fetch(PDO::FETCH_ASSOC);
      $num_rows = $limit_row['num_rows'];

      switch ($num_rows > 6):
        case true:
          $limit = 6;
        break;
        case false:
          $limit = $num_rows;
        break;
      endswitch;

      $stmt = $pdo->prepare("SELECT profile_id, user_id, first_name, last_name, headline, link, summary FROM profiles LIMIT :lim OFFSET :offset");
      $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
      $stmt->bindValue(':offset', 6 * ($_SESSION['page'] - 1), PDO::PARAM_INT);
      $stmt->execute();

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
        echo '</td></tr>';
      endwhile;

      echo '</table>';

      $sql = "SELECT COUNT(*) as num_rows from `profiles` LIMIT :lim OFFSET :offset";
      $border_stmt = $pdo->prepare($sql);
      $border_stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
      $border_stmt->bindValue(':offset', 6 * ($_SESSION['page'] - 1), PDO::PARAM_INT);
      $border_stmt->execute();
      $num_rows = $stmt->rowCount();

      echo '<form method="post" style="margin: 15px 0;">';
      echo '<input type="hidden" name="page" value="' . $_SESSION['page'] . '">';

      if ($_SESSION['page'] > 1):
      echo '<input type="submit" value="Back" name="back" style="margin-right: 20px;">';
      endif;

      if ($num_rows >= 6):
        echo '<input type="submit" value="Next" name="next" style="margin-right: 20px;">';
      endif;

      if ($_SESSION['page'] > 2):
        echo '<input type="submit" value="Return to beginning" name="return">';
      endif;

      echo '<form>';

    endif;

  ?>

</body>
</html>