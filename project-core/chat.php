<?php

  session_start();

  if (isset($_POST['reset'])):
    $_SESSION['chats'] = [];
    header('location: chat.php');
    return;
  endif;

  if (isset($_POST['message'])):
    if (!isset($_SESSION['chats'])) $_SESSION['chats'] = [];
    $_SESSION['chats'][] = array($_POST['message'], date(DATE_RFC2822));
    header('location: chat.php');
    return;
  endif;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
  <script type="text/javascript"
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
</head>
<body>

  <a href="./home.php" style="font-size: small; color: midnightblue; text-decoration: none;"><< Return to the projects menu</a>

  <h2 style="color: indigo;">Super Chat</h2>

  <form action="chat.php" method="post">
    <div>
      <input type="text" name="message" size="60">
      <input type="submit" value="Chat">
      <input type="submit" name="reset" value="Reset">
    </div>
  </form>

  <div id="chatContent" style="margin: 20px;">
    <img src="./chat/spinner.gif" alt="Loading...">
  </div>

  <script type="text/javascript">

    function updateMsg() {
      window.console && console.log("Requesting JSON");
      $.ajax({
        url: './chat/chatlist.php',
        cache: false,
        success: function(data) {
          window.console && console.log("JSON Received");
          window.console && console.log(data);
          $("#chatContent").empty();
          for (let i = 0; i < data.length; i++) {
            entry = data[i];
            $("#chatContent").append("<p><b>" + entry[0] + "</b><br/>" + entry[1] + "</p>");
          }
          setTimeout('updateMsg()', 1000);
        }
      });
    }

    window.console && console.log("Startup complete");
    updateMsg();

  </script>

</body>
</html>