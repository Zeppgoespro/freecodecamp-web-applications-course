<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>App section</title>
  <style>

    body {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

<h2>Cool application</h2>

<?php

  switch (isset($_SESSION['success'])):
    case true:
      echo '<p style="color:green">' . $_SESSION['success'] . '</p><br/>';
      unset($_SESSION['success']);
    break;
  endswitch;

  // Check if we are logged in

  $match_message = match (!isset($_SESSION['account'])) {
    true => '<p><a href="./login-logout-1.php">Log in pls</a> to start!</p>',
    false => '<p>This is where the cool app would be!</p><p>Please <a href="./login-logout-3.php">Log out</a> for now...</p>',
  };

  echo $match_message;

?>

</body>
</html>