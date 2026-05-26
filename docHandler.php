<?
  include ("connection.php");

  // select the correct db
  $db = $_POST["db"]; 

  $db_selected = mysqli_select_db($con, $db);
  if (!$db_selected) {
    die ('Can\'t use poems : ' . mysql_error());
  }

  // extremely hackish way to deal with problem of apostrophe in title -- FIX!
  $arg = stripslashes($_POST["argument"]);
  $arg = str_replace("sunrise's","sunrise\'s",$arg); 

  $result = mysqli_query($con, $arg);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  // print json-encoded poetry information
  $rows = array();
  while($r = mysqli_fetch_array($result)) {
	$rows[] = $r;
	} 

  print json_encode($rows); 
?>