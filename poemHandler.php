<?
  $con = mysqli_connect("localhost","evanrose_evan","Taylor@twpo1120!", "evanrose_poems");
  if (!$con)
    die('Could not connect: ' . mysql_error());

  // select the correct db
  $db = "evanrose_poems"; 

  $db_selected = mysqli_select_db($con, $db);
  if (!$db_selected) {
    die ('Can\'t use poems : ' . mysqli_error($con));
  }

  $arg = $_POST["argument"]; 

  $result = mysqli_query($arg);
  if (!$result) {
    die('Invalid query: ' . mysqli_error());
  }

  // print json-encoded poetry information
  $rows = array();
  while($r = mysqli_fetch_array($result)) {
	$rows[] = $r;
  }

  print json_encode($rows); 
?>