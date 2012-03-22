<?php
require_once("Database.php");
class UserStorage {
  private static $dir;
  private static $isCourse;

  public static function setDir($id, $isCrs=0) {
    self::$dir = ($isCrs == 1 ? "uploads/Courses/{$id}" : "uploads/Users/{$id}");
    self::$isCourse = $isCrs;
    $path = $_SERVER['DOCUMENT_ROOT'] . "sf/" . self::$dir;
    // Whether this directory is being set from user or course space, check to see if it exists...if not, create it 
    if (!file_exists($path))
    {
      mkdir($path, 0777);
    }
  }

  public static function getDir() {
    return self::$dir;
  }

  public static function getCrsStatus() {
    return self::$isCourse;
  }

  public static function makeStoreScript($id="''") {
     $ic = self::$isCourse;
     echo "<script type='text/javascript'>
       $(document).ready(function() { 
        $('button#addFile').click(function() {
            uploadFile({$ic},{$id}); 
              });
        });
        </script>";
    }

    public static function makePage($uid) {
      global $db;
      $rs= $db->query("CALL getStorageItems('{$uid}')"); 
      $count = $rs->num_rows;
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

      echo "<iframe id='uploadFrame' src='#' name='uploadFrame'></iframe>"; // We want the iframe on the page in either case
    }

    public static function addItem($id, $item) {
     global $db;
     $rs = $db->query("CALL insertStorageItem('{$id}', '".self::$dir."', '{$item}')"); 
    }
  }
?>
