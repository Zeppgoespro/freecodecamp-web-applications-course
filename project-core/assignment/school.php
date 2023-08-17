<?php

  require_once './pdo.php';
  require_once './util.php';

  if (!isset($_GET['term'])) die('Missing searching parameter');
  if (!isset($_COOKIE[session_name()])) die('Need to be logged in');

  session_start();
  authorization(); # from util.php

  header('Content-type: application/json; charset=utf-8');

  $term = $_GET['term'];
  error_log('Looking up typeahead term = ' . $term);

  $stmt = $pdo->prepare('SELECT name FROM institutions WHERE name LIKE :pre');
  $stmt->execute(array(':pre' => $term . "%"));

  $retval = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    $retval[] = $row['name'];
  endwhile;

  echo json_encode($retval, JSON_PRETTY_PRINT);

?>