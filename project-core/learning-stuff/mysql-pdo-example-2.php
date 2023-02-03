<?php

$pdo = new PDO('mysql:host=mysql-wa4e; dbname=misc', 'root', 'yesenin');

# See the "errors" folder for details... Stop script when error is arrived
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
# Need to require_once or include_once

$stmt = $pdo->query("SELECT user_id, name, email, password FROM users");

if (isset($_POST['delete']) && isset($_POST['user_id'])):
  $sql = "DELETE FROM users WHERE user_id = :zip";
  echo '<p style="font-weight: bold;">'.$sql.'</p>';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['user_id']));
endif;

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])):
  $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)"; # :something - placeholder
  echo '<p style="font-weight: bold;">'.$sql.'</p>';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':name'     => $_POST['name'],
    ':email'    => $_POST['email'],
    ':password' => $_POST['password']
  ));
endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MySQL PDO Example 2</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <h3>Add a new user!</h3>

  <form method="post">
    <p>Name: <input type="text" name="name" size="40"></p>
    <p>Email: <input type="text" name="email" size="40"></p>
    <p>Password: <input type="password" name="password"></p>
    <p><input type="submit" value="add new" style="text-transform: capitalize"></p>
  </form>

  <?php

  $stmt = $pdo->query("SELECT user_id, name, email, password FROM users");

  echo '<table border="1">';
  echo '<tr><th>Name</th><th>Email</th><th>Password</th><th>Action</th></tr>';

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    echo '<tr><td>';
    echo $row['name'];
    echo '</td><td>';
    echo $row['email'];
    echo '</td><td>';
    echo $row['password'];
    echo '</td><td>';
    echo '<form method="post"><input type="hidden"';
    echo 'name="user_id" value="' . $row['user_id'] . '"><br/>';
    echo '<input type="submit" value="del" name="delete" style="text-transform: capitalize"><br/>';
    echo '</form>';
    echo '</td></tr>';
  endwhile;
  echo '</table>';

  ?>

</body>
</html>