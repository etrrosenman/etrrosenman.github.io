<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<title>Selected Poems</title>
<head>
  <link rel="stylesheet" href="style.css" type="text/css">
  <script src="jquery.js"></script>
  <script src="arbor.js"></script>
  <script src="graphics.js"></script>
  <script src="poemrenderer.js"></script>
  <script src="functions.js"></script>
</head>
<body>
<?php include ("navigation.php"); ?>

</div> <div class = "center">
  <br/>
  <div id = "description">
    <b><font size="5">Selected Poems</font></b><br/><br/>
    A selection of my poetry is displayed below. Click on any poem to
  view its content in the right panel. <br/><br/>
    <div id = "poemlist">
      <?
      include ("connection.php");

      // select the correct db
      $db = "evanrose_poems"; 

      $db_selected = mysqli_select_db($con, $db);
      if (!$db_selected) {
        die ('Can\'t use poems : ' . mysqli_error($con));
      }
      $arg = "SELECT name FROM poemLocations ORDER BY name ASC"; 

      $result = mysqli_query($con, $arg);
      if (!$result) {
        die('UGH. Invalid query: ' . mysqli_error($con));
      }

      // print json-encoded poetry information
      $ctr = 0;
      while($r = mysqli_fetch_array($result)) {
        $ctr = ($ctr+1)%2; 
        print "<div class = \"poemlink" . $ctr . "bg\"><a href = \"#\">" . $r[0] . "</a></div>"; 
      }
     ?>
    </div>
    <div id = "poemdisplay"><div id = "poemtext"><b><font size =
      "4">Click the name of any poem to the
      left to view its content here.</b></div></div>
</div>
</div>
<br/><br/>

<div class = "center">
<?php include ("footer.php"); ?>
</div>

</body>
</html>
