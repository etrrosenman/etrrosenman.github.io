<!DOCTYPE html>
<meta http-equiv="X-UA-Compatible" content="IE=7" /> 
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<title>TestCanvas</title>
<head>
  <link rel="stylesheet" href="style.css" type="text/css">
  <script src="jquery.js"></script>
  <script src="arbor.js"></script>
  <script src="graphics.js"></script>
  <script src="canvastest.js"></script>
  <script src="functions.js"></script>
  <!--[if IE]><script src="excanvas.js"></script><![endif]--></head>
</head>
<body>
<?php include ("navigation.php"); ?>
 <div class = "center">
   <br/>
  <div id = "description">
    <b><font size="5">Poem Visualization</font></b><br/><br/>
    A selection of my poetry is visualized in the graph below. Each poem
    is represented as a node, and edges represent strong similarity
    among poems. Move your mouse around the canvas to display the
    words which are most shared among similar poems; this should
    provide a useful way to navigate poems by theme. Click on
    any node to display a poem's content. 
    <br/><br/>
    To see a more straightforward list view of my poems, head to the <a
    href = "poemlist.php">Selected
    Poems</a> page. To learn about how this
   visualization was generated, check out ProseMapper on the <a href =
  "projects.php">Projects Page</a>. <br/><br/>
</div>
</div>
<br/><br/><br/>
<canvas id="testviewport"></canvas>
<div id = "content"><a href = "#">Close Poem</a><div id = "poem"></div>
</div>

<div class = "center">
<?php include ("footer.php"); ?>
</div>

</body>
</html>
