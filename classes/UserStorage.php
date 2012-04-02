<?php
require_once("Database.php");
require_once("Course.php");
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
      chmod($path, 0777); // Used to make sure the mkdir call doesn't default to 0755
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

    public static function makePage($id) {
      global $db;
      $rs= $db->query("CALL getStorageItems('{$id}',1)"); 
      $count = $rs->num_rows;
      echo "<button id='addFile'>Add a new file</button>";
      if ($count < 1)
        echo "<p>You currently have no uploaded/approved files. Click the button above to upload something.</p>";
      else
      {
      	if (self::$isCourse == 1)
				{
        	echo "<p>Listed below are the approved uploads for this course. You may download files by right clicking and \"Saving As\"</p>";				
        }		
        else
        	echo "<p>Listed below are the files you've uploaded to your personal space.</p>";

        echo "<div id='currentUploads'>";
        while($row = $rs->fetch_array(MYSQLI_ASSOC))
        {
          $jpg = strpos($row['item_name'], ".jpg");
          $jpeg = strpos($row['item_name'], ".jpeg");
          $png = strpos($row['item_name'], ".png");
          $gif = strpos($row['item_name'], ".gif");
          $bmp = strpos($row['item_name'], ".bmp");
          $sid = $row['storage_ID'];
					$delClick = "deleteStorageDialogue('{$sid}','{$id}',".self::$isCourse.")";
					
          echo "<ul class='storageItem'>";
          // Construct the list item with dynamic <a> tag
          if ($jpg !== false || $jpeg !== false ||  $png !== false || $gif !== false || $bmp !== false )
					{
						$img = "<img height='50' width='50' src='". self::$dir . "/" . $row['item_name'] . "' />";
						$viewClick = "showUploadPic('".self::$dir."/".$row['item_name']."','".$row['item_name']."')";
            echo "<li>{$img}</li>";
						echo "<li><a class='cursorPter' onclick={$viewClick}>View</a></li>
									<li><a class='cursorPter' onclick={$delClick}>Delete</a></li>";
          }
          else
					{
            echo "<li><span class='bold'>". $row['item_name'] ."</span></li>";
						echo "<li><a class='cursorPter' href='". self::$dir . "/" . $row['item_name'] ."'>View</a>
									</li><li><a class='cursorPter' onclick={$delClick}>Delete</a></li>";
					}

          echo "</ul>";
        }
        echo "</div>";

       	$rs->close(); // Close the current result set 
       	$db->next_result(); // Make way for the next stored procedure

				if (self::$isCourse == 1)
				{
					$crs = new Course($id);	
      		if ($crs->get_instructorID() == $_SESSION['userID'])
      			echo self::getItemsNeedingApproval($id);
				}
      }
        echo "<iframe id='uploadFrame' src='#' name='uploadFrame'></iframe>"; // We want the iframe on the page in either case
    }

    public static function addItem($id, $item, $approved) {
     global $db;
     $rs = $db->query("CALL insertStorageItem('{$id}', '".self::$dir."', '{$item}', {$approved})"); 
    }

    public static function deleteItem($path) {
    	$path = $_SERVER['DOCUMENT_ROOT'] . "sf/" . $path;
    	if (file_exists($path))
			{
				unlink($path);	
			}
		}

		public static function getItemsNeedingApproval($id) {
			global $db;
			$rs = $db->query("CALL getStorageItems('$id', 0)");
			$count = $rs->num_rows;
			if ($count > 0)
			{
				echo "<br /><p>Pending File Submissions:</p>";
				echo "<div id='unApprUploads'>";
				while($row = $rs->fetch_array(MYSQLI_ASSOC))
				{
					$jpg = strpos($row['item_name'], ".jpg");
					$jpeg = strpos($row['item_name'], ".jpeg");
					$png = strpos($row['item_name'], ".png");
					$gif = strpos($row['item_name'], ".gif");
					$bmp = strpos($row['item_name'], ".bmp");
					$sid = $row['storage_ID'];
					$delClick = "deleteStorageDialogue('{$sid}','{$id}',".self::$isCourse.")";
					$appClick = "approveStorageDialogue('{$sid}')";

					echo "<ul class='storageItem'>";
					// Construct the list item with dynamic <a> tag
					if ($jpg !== false || $jpeg !== false ||  $png !== false || $gif !== false || $bmp !== false )
					{
						$img = "<img height='50' width='50' src='". self::$dir . "/" . $row['item_name'] . "' />";
						$viewClick = "showUploadPic('".self::$dir."/".$row['item_name']."','".$row['item_name']."')";
            echo "<li>{$img}</li>";
						echo "<li><a class='cursorPter' onclick={$viewClick}>View</a></li>
									<li><a class='cursorPter' onclick={$delClick}>Delete</a></li>";
					}
					else
					{
            echo "<li><span class='bold'>". $row['item_name'] ."</span></li>";
						echo "<li><a class='cursorPter' href='". self::$dir . "/" . $row['item_name'] ."'>View</a>
									</li><li><a class='cursorPter' onclick={$delClick}>Delete</a></li>";
					}
					echo "<li><a class='cursorPter' onclick={$appClick}>Approve</a></li>";
					echo "</ul>";
				}
				echo "</div>";
			}
			else
				echo "<div id='unApprUploads'><p>No Pending Items</p></div>";
		}
  }
?>
