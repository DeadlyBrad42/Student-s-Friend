<?php
session_start();
require_once("../classes/UserStorage.php");

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
    case "logout":
      doLogout();
      break;
    case "refreshUserUp":
      if (isset($_GET['uid']))
      {
      	$uid = $_GET['uid'];
        refreshUserStorageDiv($uid);
      }
      break;
    case "deleteStorage":
    	if (isset($_GET['storeID']) && isset($_GET['id']) && isset($_GET['isCrs']))
			{
				$sid = $_GET['storeID'];
				$id = $_GET['id'];
				$crs = $_GET['isCrs'];
    		deleteStorageItem($sid, $id, $crs);
    	}
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
	$rs = $db->query("SELECT storage_directory, item_name FROM sfstorage WHERE storage_ID={$sid}");
	$row = $rs->fetch_array(MYSQLI_ASSOC);
	// Piece together the path to the item, and delete it
	$path = $row['storage_directory'] ."/". $row['item_name'];
	$db->query("DELETE FROM sfstorage WHERE storage_ID={$sid}");
	UserStorage::deleteItem($path);

	// if it's a user item, refresh the storage.php div
	if ($isCrs == 0)
	{
		refreshUserStorageDiv($id);
	}
}
?>
