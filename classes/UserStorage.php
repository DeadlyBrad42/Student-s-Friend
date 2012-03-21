<?php
require_once("Database.php");
class UserStorage {
  private static $dir;

  public static function setDir($id, $isCrs=0) {
    self::$dir = $isCrs == 1 ? "uploads/Courses/{$id}" : "uploads/Users/{$id}";
  }

  public static function getDir() {
    echo self::$dir;
    return self::$dir;
  }

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
      $rs= $db->query("CALL getStorageItems('{$uid}')"); 
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
          $jpg = strpos($row['item_name'], ".jpg");
          $png = strpos($row['item_name'], ".png");
          $gif = strpos($row['item_name'], ".gif");
          $bmp = strpos($row['item_name'], ".bmp");
          
          // Construct the list item with dynamic <a> tag
          if ($jpg !== false || $png !== false || $gif !== false || $bmp !== false )
            echo "<li><a class='cursorPter' onclick='showUploadPic(\"" . self::$dir . "/" . $row['item_name'] . "\", \"". $row['item_name'] ."\")'>" 
                  . $row['item_name'] . "</a></li>";
          else
            echo "<li><a href='" . self::$dir . "/" . $row['item_name'] . "'>" . $row['item_name'] . "</a></li>";
        }
        echo "</ul></div>";
      }
    }

    public static function addItem($uid, $item) {
     global $db;
     $rs = $db->query("CALL insertStorageItem('{$uid}', '".self::$dir."', '{$item}')"); 
    }

    public static function makeUploadDir() {
      $path = "../".self::$dir;
      if (!file_exists($path))
      {
        mkdir($path, 0777);
      }
    }
  }
?>
