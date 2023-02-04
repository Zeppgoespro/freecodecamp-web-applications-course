<?php

# Flash messages

function flash_messages() {
  switch (isset($_SESSION['error'])):
    case true:
      echo '<p style="color: crimson; font-weight: bold; text-transform: uppercase;">' . $_SESSION['error'] . '</p>';
      unset($_SESSION['error']);
    break;
  endswitch;

  switch (isset($_SESSION['success'])):
    case true:
      echo '<p style="color: gold; font-weight: bold; text-transform: uppercase;">' . $_SESSION['success'] . '</p>';
      unset($_SESSION['success']);
    break;
  endswitch;
}

# Add/Edit form data validation

function validate_data() {
  if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
    return 'Need to enter all required information';
  } elseif (strpos($_POST['email'], '@') == false) {
    return 'This is not an email, pls enter correct email';
  }
  return true;
}

function validate_pos() {
  for ($i = 1; $i <= 4; $i++) {
    if (!isset($_POST['year' . $i])) continue;
    if (!isset($_POST['desc' . $i])) continue;
    $year = $_POST['year' . $i];
    $desc = $_POST['desc' . $i];
    if (strlen($year) == 0 || strlen($desc) == 0) {
      return "All fields are required";
    }

    if (!is_numeric($year)) {
      return "Event year must be a number";
    }
  }
  return true;
}

function validate_edu() {
  for ($i = 1; $i <= 4; $i++) {
    if (!isset($_POST['edu_year' . $i])) continue;
    if (!isset($_POST['edu_school' . $i])) continue;
    $year = $_POST['edu_year' . $i];
    $school = $_POST['edu_school' . $i];
    if (strlen($year) == 0 || strlen($school) == 0) {
      return "All fields are required";
    }

    if (!is_numeric($year)) {
      return "Event year must be a number";
    }
  }
  return true;
}

# Inserting events (positions) and educations

function insert_positions($pdo, $profile_id) {

  $rank = 1;

  for ($i = 1; $i <= 4; $i++):
    if (!isset($_POST['year' . $i])) continue;
    if (!isset($_POST['desc' . $i])) continue;
    $year = $_POST['year' . $i];
    $desc = $_POST['desc' . $i];

    $sql = "INSERT INTO positions (profile_id, `rank`, year, description) VALUES (:pid, :rank, :year, :desc)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':pid' => $profile_id,
      ':rank' => $rank,
      ':year' => $year,
      ':desc' => $desc
    ));

    $rank++;

  endfor;

}

function insert_educations($pdo, $profile_id) {

  $rank = 1;

  for ($i = 1; $i <= 4; $i++):
    if (!isset($_POST['edu_year' . $i])) continue;
    if (!isset($_POST['edu_school' . $i])) continue;
    $year = $_POST['edu_year' . $i];
    $school = $_POST['edu_school' . $i];

    $institution_id = false;

    $stmt = $pdo->prepare('SELECT institution_id FROM institutions WHERE name = :nm');
    $stmt->execute(array(
      ':nm' => $school
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) $institution_id = $row['institution_id'];
    if ($institution_id === false):
      $stmt = $pdo->prepare('INSERT INTO institutions (name) VALUES (:nm)');
      $stmt->execute(array(':nm' => $school));
      $institution_id = $pdo->lastInsertId();
    endif;

    $stmt = $pdo->prepare('INSERT INTO educations (profile_id, `rank`, year, institution_id) VALUES (:pid, :rk, :yr, :iid)');
    $stmt->execute(array(
      ':pid'  => $profile_id,
      ':rk'   => $rank,
      ':yr'   => $year,
      ':iid'  => $institution_id
    ));

    $rank++;

  endfor;

}

# Loading the events (positions) and educations

function load_pos ($pdo, $profile_id) {
  $sql = "SELECT * FROM positions WHERE profile_id = :pid ORDER BY `rank`";
  $pos_stmt = $pdo->prepare($sql);
  $pos_stmt->execute(array(':pid' => $profile_id));
  $pos_row = $pos_stmt->fetchAll(PDO::FETCH_ASSOC);
  return $pos_row;
}

function load_edu ($pdo, $profile_id) {
  $sql = "SELECT year, name FROM educations JOIN institutions ON educations.institution_id = institutions.institution_id WHERE profile_id = :pid ORDER BY 'rank'";
  $edu_stmt = $pdo->prepare($sql);
  $edu_stmt->execute(array(':pid' => $profile_id));
  $edu_row = $edu_stmt->fetchAll(PDO::FETCH_ASSOC);
  return $edu_row;
}

# Check for authorization

function authorization() {
  if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'You need to log in first';
    die('<p style="font-family: Arial, Helvetica, sans-serif;">Access denied, you need to log in.<br/>Go to the <a href="../assignment.php">main page</a></p>');
    return;
  }
}

# Curl's image downloading

function curling($link_way) {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $link_way);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $curl_response = curl_exec($curl);
  curl_close($curl);
  $curl_file = "data:image/jpeg;base64," . base64_encode($curl_response);
  return $curl_file;
}

?>