<?php

$ses = session_id();
if(empty($ses))
{
  session_start();
}
require_once($_SERVER['DOCUMENT_ROOT']."sf/classes/UserStorage.php");

if ((isset($_POST['action']) && !empty($_POST['action'])) || (isset($_GET['action']) && !empty($_GET['action'])))
{
	if (isset($_POST['action']))
	{
		$a = $_POST['action'];
	}
	else
	{
		$a = $_GET['action'];
	}

  switch($a)
  {
    case "logout" :
      doLogout();
      break;
    case "refreshUserUp" :
      if (isset($_GET['uid']))
      {
      	$uid = $_GET['uid'];
        refreshUserStorageDiv($uid);
      }
      break;
    case "deleteStorage" :
    	if (isset($_GET['storeID']) && isset($_GET['id']) && isset($_GET['isCrs']))
			{
				$sid = $_GET['storeID'];
				$id = $_GET['id'];
				$crs = $_GET['isCrs'];
    		deleteStorageItem($sid, $id, $crs);
    	}
    	break;
    case "approveStorage" :
    	if (isset($_GET['storeID']) && !empty($_GET['storeID']))
			{
				$sid = $_GET['storeID'];
				approveStorageItem($sid);
			}
			break;
    case "updateCrs" :
      if (isset($_GET['uid']))
      {
        $uid = $_GET['uid'];
        updateCourses($uid);
      }
      break;
    default :
    	break;
  }
}

function doLogout()
{
  $_SESSION = array();
  if (isset($_COOKIE[session_name()]))
  {
    setcookie(session_name(),null,time()-10000, '/');
  } 
  session_destroy();
  echo "logout success!";
}

function refreshUserStorageDiv($uid)
{
  UserStorage::setDir($uid, 0);
  UserStorage::makeStoreScript($uid);
  UserStorage::makePage($_SESSION['userID']);
}

function deleteStorageItem($sid, $id, $isCrs)
{
	global $db;
	$rs = $db->query("CALL getStorageItemPath('{$sid}', @sd, @itm)");
	$rs = $db->query("SELECT @sd as dir, @itm as name");
	$row = $rs->fetch_array(MYSQLI_ASSOC);
	// Piece together the path to the item, and delete it
	$path = $row['dir'] ."/". $row['name'];
	if (!$db->query("CALL deleteStorageItem({$sid})"))
	{
		echo $db->error();	
	}
	UserStorage::deleteItem($path);
	// if it's a user item, refresh the storage.php div
	if ($isCrs == 0)
	{
		refreshUserStorageDiv($id);
	}
}

function approveStorageItem($sid)
{
	global $db;
	$rs = $db->query("UPDATE sfstorage SET approved = 1 WHERE storage_ID = {$sid}");
}

function updateCourses($uid)
{
  global $db;
  $rs = $db->query("CALL getCoursesForUser('{$uid}')");
  if ($rs->num_rows == 0)
  {
    // For now, javascript handles the case where there are no rows
  }
  else
  {
    $i = 0;
    $courses = array();
    while($row = $rs->fetch_array(MYSQLI_ASSOC))
    {
      // While there is still a row to fetch, add an array to $courses based on key/value pairs 
      $id = $row['course_ID'];
      $name = $row['course_name'];
      $descrip = $row['course_description'];
      $time = $row['course_time'];
      $location = $row['course_location'];
      $instructFN = $row['ins_fname'];
      $instructLN = $row['ins_lname'];
      
      $c = array('id' => "{$id}", 
                 'name' => "{$name}",
                 'descrip' => "{$descrip}",
                 'time' => "{$time}",
                 'location' => "{$location}",
                 'insFirst' => "{$instructFN}",
                 'insLast' => "{$instructLN}"
      );
      
      $courses[] = $c;
    }
    
    // Finally, place the Manage course link in the json obj
    $c = array('name' => 'Manage Courses');
    $courses[] = $c;
    $_SESSION['courses'] = json_encode($courses);
    
    $db->next_result();
    $rs->close();
  }
}

?>
