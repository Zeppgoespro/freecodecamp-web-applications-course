<?php

$pdo = new PDO('mysql:host=mysql-wa4e; dbname=misc', 'root', 'yesenin');

# See the "errors" folder for details... Stops script when error is arrived
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
# Need to require_once or include_once

$stmt = $pdo->query("SELECT user_id, name, email, password FROM users");

echo '<table border="1">';
echo '<tr><th>id</th><th>Name</th><th>Email</th><th>Password</th></tr>';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
  echo '<tr><td>';
  echo $row['user_id'];
  echo '</td><td>';
  echo $row['name'];
  echo '</td><td>';
  echo $row['email'];
  echo '</td><td>';
  echo $row['password'];
  echo '</td></tr>';
endwhile;
echo '</table>';

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

if (isset($_POST['user_id'])):
  $sql="DELETE FROM users WHERE user_id = :zip";
  echo '<p style="font-weight: bold;">'.$sql.'</p>';
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip'=>$_POST['user_id']));
endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MySQL PDO Example 1</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
</head>
<body>

  <p>Add a new user!</p>
  <form method="post">
    <p>Name: <input type="text" name="name" size="40"></p>
    <p>Email: <input type="text" name="email" size="40"></p>
    <p>Password: <input type="password" name="password"></p>
    <p><input type="submit" value="add new" style="text-transform:capitalize"></p>
  </form>

  <p>Delete a user</p>
  <form action="" method="post">
    <p>ID to delete: <input type="text" name ="user_id"></p>
    <input type="submit" value="delete" style="text-transform: capitalize">
  </form>

</body>
</html>