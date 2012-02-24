<?php
  require_once("Database.php");
  class UserStorage {
    private $storageID;
    private $dir;
  
    public static function makeStoreScript() {
      echo "<script type='text/javascript'>
        $(document).ready(function() { 
          $('button#addFile').click(function() {
                     uploadFile(); 
                   });
              });
           </script>";
    }
    public static function makePage($uid, $msg) {
      global $db;
      $rs= $db->query("SELECT * FROM userstorage WHERE user_ID = '{$uid}'"); 
      $count = $rs->num_rows;
      echo $msg;
      echo "<button id='addFile'>Add a new file</button>";
      if ($count < 1)
        echo "<p>You currently have no files uploaded. Click the button above to upload something.</p>";
      else
      {
        echo "<p>Listed below are the files you've uploaded. Click a file to view it or download it to your local machine.</p>
              <div id='currentUploads'><ul>";
        while($row = $rs->fetch_array(MYSQLI_ASSOC))
        {
          echo "<li>".$row['item_name']."</li>";
        }
        echo "</ul></div>";
      }
    }
}

?>
