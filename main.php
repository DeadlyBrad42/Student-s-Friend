<?php
  session_start();
?>
<html>
<head>
  <script src="http://connect.facebook.net/en_US/all.js" async="true"></script>
</head>
<body>
  <?php require_once("layout/header.php"); ?>
    <div id="wrapper">
      <p id='userWelcome'></p>
    </div>
  <?php require_once("layout/footer.php"); ?>
</body>
</html>
