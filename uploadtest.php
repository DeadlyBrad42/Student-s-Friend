<html>
<head>
  <title>Upload Test</title>
</head>
<body>
  
  <form action="uploadfile.php" method="post" enctype="multipart/form-data">
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file" />
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <br />
    <input type="submit" name="submit" value="Submit" />
  </form>
  
  <?php phpinfo() ?>
  
</body>
</html>