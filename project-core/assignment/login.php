<?php

  require_once './pdo.php';
  session_start();
  require_once './util.php';

  if (isset($_POST['cancel_login'])) {
    header('location: ../assignment.php');
    return;
  }

  # Some data validation

  if (isset($_POST['email']) && isset($_POST['password'])):
    if (strlen($_POST['email']) < 1 || strlen($_POST['password']) < 1) {
      $_SESSION['error'] = 'Need to enter both email and password';
      header('location: ./login.php');
      return;
    } elseif (strpos($_POST['email'], '@') == false) {
      $_SESSION['error'] = 'This is not an email, pls enter correct email';
      header('location: ./login.php');
      return;
    }

    $hash_check = hash('md5', $_POST['password']);

    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':email'    => $_POST['email'],
      ':password' => $hash_check
    ));

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    switch ($row === false):
      case true:
        $_SESSION['error'] = "Wrong password";
        header('location: ./login.php');
        return;
      break;
      case false:
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['success'] = 'You are successfully logged in';
        header('location: ../assignment.php');
        return;
      break;
    endswitch;

  endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once './head.php' ?>
</head>
<body>

  <h2>Please Log In</h2>

  <?php

    # FLash messages

    flash_messages();

  ?>

  <form method="post" action="login.php">
    <p>
      <label for="email">Email:</label><br/>
      <input type="text" name="email" id="email" placeholder="Enter your email">
    </p>
    <p>
      <label for="password">Password:</label><br/>
      <input type="password" name="password" id="password" placeholder="Enter your password">
    </p>
    <p>
      <input type="submit" value="Log In" onclick="return doValidation();">
      <input type="submit" name="cancel_login" value="Cancel">
    </p>
  </form>

  <script>

    function doValidation() {
      console.log('Validating...');
      try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('password').value;
        console.log("Validating address: " + addr + "|| pw: " + pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
          alert("Both fields must be filled out");
          return false;
        }
        if (addr.indexOf('@') == -1 ) {
          alert("Invalid email address");
          return false;
        }
        return true;
      } catch(e) {
        return false;
      }
      return false;
    }

  </script>
</body>
</html>