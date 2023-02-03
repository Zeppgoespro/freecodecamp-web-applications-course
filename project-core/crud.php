<?php

require_once './crud/pdo.php';
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crud</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <h3>Table representation</h3>

  <?php

    # Flash messages

    if (isset($_SESSION['error'])):
      echo '<p style="color:red">' . $_SESSION['error'] . '</p><br/>';
      unset($_SESSION['error']);
    endif;

    if (isset($_SESSION['success'])):
      echo '<p style="color:green">' . $_SESSION['success'] . '</p><br/>';
      unset($_SESSION['success']);
    endif;

    echo '<table border="1">';

    $stmt = $pdo->query("SELECT user_id, name, email, password FROM users");

    echo '<tr><th>Name</th><th>Email</th><th>Password</th><th>User id</th><th>Actions</th></tr>';

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
      echo '<tr><td>';
      echo htmlentities($row['name']);
      echo '</td><td>';
      echo htmlentities($row['email']);
      echo '</td><td>';
      echo htmlentities($row['password']);
      echo '</td><td>';
      echo htmlentities($row['user_id']);
      echo '</td><td>';
      echo '<a href="./crud/edit.php?user_id=' . $row['user_id'] . '">Edit</a> | ';
      echo '<a href="./crud/delete.php?user_id=' . $row['user_id'] . '">Delete</a>';
      echo '</td></tr>';
    endwhile;

    echo '</table>';

  ?>

  <p style="margin-top: 20px;"><a href="./crud/add.php">Add New</a></p>

</body>
</html>