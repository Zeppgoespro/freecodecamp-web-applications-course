<?php

  require_once './pdo.php';
  session_start();

  $sql = 'SELECT title, year, songs, album_id FROM albums';
  $stmt = $pdo->query($sql);
  $rows = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $row;
  }

  echo json_encode($rows);

?>