<?php

  session_start();

  sleep(2);

  header('Content-Type: application/json; charset=utf8');

  if (!isset($_SESSION['chats'])) $_SESSION['chats'] = [];
  echo(json_encode($_SESSION['chats']));

?>