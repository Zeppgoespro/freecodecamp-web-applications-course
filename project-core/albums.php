<?php

  require_once './albums/pdo.php';
  session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Albums</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

  </style>
  <script type="text/javascript"
  src="https://code.jquery.com/jquery-3.6.3.js"
  integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
  crossorigin="anonymous"></script>
  <script type="text/javascript">

    function htmlentities(str) {
      return $('<div/>').text(str).html();
    }

  </script>
</head>
<body>

  <a href="./home.php" style="font-size: small; color: midnightblue; text-decoration: none;"><< Return to the projects menu</a>

  <h2 style="color: indigo;">Great rock albums</h2>

  <?php

    # Flash messages

    if (isset($_SESSION['error'])):
      echo '<p style="color: crimson;">' . $_SESSION['error'] . '</p>';
      unset($_SESSION['error']);
    endif;

    if (isset($_SESSION['success'])):
      echo '<p style="color: gold;">' . $_SESSION['success'] . '</p>';
      unset($_SESSION['success']);
    endif;

  ?>

  <table border="1" style="margin-bottom: 20px;">
    <tbody id="myTab">
    </tbody>
  </table>

  <script type="text/javascript">

    $.getJSON('./albums/get-json.php', function(data) {
      $("#myTab").empty().append('<tr><th>Title</th><th>Year</th><th>Songs count</th><th>Actions</th></tr>');
      let found = false;
      for (let i = 0; i < data.length; i++) {
        let entry = data[i];
        found = true;
        window.console && console.log(data[i].title);
        $("#myTab").append('<tr><td>' + htmlentities(entry.title) + '</td><td>'
        + htmlentities(entry.year) + '</td><td style="display: flex; align-items: center; justify-content: center;">'
        + htmlentities(entry.songs) + '</td><td>'
        + '<a href="./albums/edit.php?album_id=' + htmlentities(entry.album_id) + '">'
        + 'Edit</a> | '
        + '<a href="./albums/delete.php?album_id=' + htmlentities(entry.album_id) + '">'
        + 'Delete</a></td></tr>');
      }

      if (!found) {
        $("#myTab").append('<tr><td>No entries found</td></tr>');
      }

    });

  </script>

  <a href="./albums/add.php">Add new</a>

</body>
</html>