<?
  $con = mysql_connect("127.0.0.1","evan","poems");
  if (!$con)
    die('Could not connect: ' . mysql_error());

  // select the correct db
//  $db_selected = mysql_select_db("poems", $con);
//  if (!$db_selected) {
//   die ('Can\'t use poems : ' . mysql_error());
// }

  $nodes = file("nodePlacementsForSite.txt");

//  $sql = "DELETE FROM  WHERE 1";
//  $result = mysql_query($sql);

  foreach ($nodes as $line_num => $node) {
    $array = explode(",", $node);
    $nodename = $array[0];
    $nodeX = (floatval($array[1]))/10.0;
    $nodeY = (floatval($array[2]))/10.0;
    echo $nodename . " "  . $nodeX . " " . $nodeY . "\n"; 

    //    $sql = "INSERT INTO `" . $tablename . "` (node, x, y) VALUES($nodeId, $nodeX, $nodeY)";
    // mysql_query($sql);
  }
?>
