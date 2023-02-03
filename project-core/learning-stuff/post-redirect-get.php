<?php

/* Bad

$guess = '';
$message = false;

if (isset($_POST['guess'])) {
  $guess = $_POST['guess'] + 0;
  if ($guess == 42):
    $message = 'Great job!';
  elseif ($guess < 42):
    $message = 'Too low';
  else:
    $message = 'Too high';
  endif;
}

*/

/* Good */

session_start();

if (isset($_POST['guess'])) {
  $guess = $_POST['guess'] + 0;
  $_SESSION['guess'] = $guess;
  if ($guess == 42):
    $_SESSION['message'] = 'Great job!';
  elseif ($guess < 42):
    $_SESSION['message'] = 'Too low';
  else:
    $_SESSION['message'] = 'Too high';
  endif;

  header('location: ./post-redirect-get.php');
  return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Guessing game</title>
</head>
<body>

  <?php

    $guess = isset($_SESSION['guess']) ? $_SESSION['guess'] : '';
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : false;

  ?>

  <h3>Guessing game</h3>

  <?php
    if ($message !== false ) echo '<p style="font-weight: bold; color: indigo;">'.$message.'</p><br/>';
  ?>

  <form method="post">
    <p><label for="guess">Input Guess</label>
    <input type="text" name="guess" id="guess" size="40" value="<?=htmlentities($guess)?>"></p>
    <input type="submit">
  </form>

</body>
</html>