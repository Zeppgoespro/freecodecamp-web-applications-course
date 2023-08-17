<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crossroads</title>
  <style>

    * {
      font-family: Arial, Helvetica, sans-serif;
    }

    p {
      margin-bottom: 30px;
    }

  </style>
</head>
<body>

<div style="margin-top: 30px;">

  <a href="./assignment.php" title="Final Assignment"><b>Final Assignment - Huge Next-Gen New Century Application</b></a>

  <p>
    Большая, хорошо управляемая база данных, по классике новичкового жанра, представленная в виде обычной таблицы.<br/>
    БД - <b>MySQL</b>, взаимодействие с которой осуществляется через <b>PDO</b> + <b>Named Parameters</b>. <b>POST-REDIRECT-GET</b> + <b>Flash Messages</b> из <b>$_SESSION</b>.<br/>
    Общие функции, разные валидации и загрузки находятся в файле <b>util.php</b> внутри папки <b>assignment</b>.<br/>
  </p>

  <p>
    Верстки никакой особо нет, так как нет смысла здесь её делать. На страницах <b>'add.php'</b> и <b>'edit.php'</b> есть возможность динамически добавлять/убирать поля ввода данных об образовании и важных событиях жизни не перезагружая страницу, осуществлённая с помощью <b>JavaScript - JQuery</b>.
  </p>

  <p><b>TL;DR: PHP + MySQL(PDO) + JavaScript(JQuery)</b></p>

  <p>
    <b>Внимание!</b><br/>
    Некоторые использующиеся тут штуки негативно влияют на скорость загрузки страниц.<br/>
    Например, загрузка <b>curl'ом</b> картинок c сайтов <b>Disney/Britannica</b> для использования их в профилях.<br/>
    Однако, мне нужно было поковырять разные технолоджис, чтобы, хотя бы таким образом, посмотреть на них. Вот я и поковырял.<br/>
  </p>

  <p>
    <b>Users for login + their passwords:</b><br/>
    mando@bookex.com - <b>grogu</b><br/>
    jiga@bookex.com - <b>grogz</b><br/>
  </p>

  <hr style="margin: 30px 0;">

  <a href="./albums.php" title="Third Exercise">Course third exercise - Albums Table</a>
  <p>
    Маленький крадик, ничего примечательного, кроме того, что таблица на главной станице формируется из распакованного <b>JavaScript'ом JSON'а</b>.<br/>
    Запаковка производится с помощью <b>PHP</b> + <b>json_encode()</b> в файле <b>get-json.php</b> внутри папки <b>albums</b>.<br/>
  </p>

  <hr style="margin: 30px 0;">

  <a href="./chat.php" title="Second Exercise">Course second exercise - Simple Chat</a>
  <p>
    Имитация чата в реальном времени c возможностью ввода сообщений в разных окнах браузера с помощью распаковки (<b>JQuery</b>) и запаковки (<b>PHP</b>) <b>JSON'а</b> из <b>$_SESSION</b>.
  </p>

  <hr style="margin: 30px 0;">

  <a href="./crud.php" title="First Exercise">Course first exercise - CRUD</a>
  <p>Самый простейший крад. Можно сказать, здесь абсолютно нечего смотреть.</p>

</div>

</body>
</html>