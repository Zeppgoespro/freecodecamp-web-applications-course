<?php

  session_start();

  switch (isset($_POST['account']) && isset($_POST['pw'])):
    case true:
      unset($_SESSION['account']); # logout current user
      switch ($_POST['pw'] == 'umsi'):
        case true:
          $_SESSION['account'] = $_POST['account'];
          $_SESSION['success'] = "Logged in!";
          header('location: login-logout-2.php');
          return;
        break;
        case false:
          $_SESSION['error'] = 'Incorrect password';
          header('location: login-logout-1.php');
          return;
        break;
      endswitch;

    break;
  endswitch;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login example</title>
  <style>

    body {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <h2>Please log in</h2>

  <?php

    # Flash messages

    switch (isset($_SESSION['error'])):
      case true:
        echo '<p style="color:red">' . $_SESSION['error'] . '</p><br/>';
        unset($_SESSION['error']);
      break;
    endswitch;

    switch (isset($_SESSION['success'])):
      case true:
        echo '<p style="color:green">' . $_SESSION['success'] . '</p><br/>';
        unset($_SESSION['success']);
      break;
    endswitch;

  ?>

  <form method="post">
    <p>Account: <input type="text" name="account" value="" placeholder="Enter account name"></p>
    <p>Password: <input type="text" name="pw" value="" placeholder="Enter password"></p>
    <!-- Password is umsi / Any user name -->
    <p><input type="submit" value="Log in">
    <a href="./login-logout-1.php">Cancel</a></p>
  </form>

</body>
</html>