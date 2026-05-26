<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<title>Poetry</title>
<head>
  <link rel="stylesheet" href="style.css" type="text/css">
  <script src="jquery.js"></script>
  <script src="arbor.js"></script>
  <script src="graphics.js"></script>
  <script src="poemrenderer.js"></script>
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
<canvas id="viewport"></canvas>
<script language="javascript" type="text/javascript">
var sys = arbor.ParticleSystem(10000,0,1.0);
 sys.renderer = Renderer("#viewport");

  $.ajax({
    url: "docHandler.php",
    type: "POST",
    async: false,
    data: {db: "evanrose_poems",
    argument: "SELECT MAX(ABS(y)),MAX(ABS(x)) FROM poemLocations"}
  }).done(function(msg) {
    maxes = ($.parseJSON(msg));
    $maxy = maxes[0]["MAX(ABS(y))"];
    $maxx = maxes[0]["MAX(ABS(x))"];
});

  $.ajax({
    url: "docHandler.php",
    type: "POST",
    async: false,
    data: {db: "evanrose_poems", argument: "SELECT * FROM poemLocations JOIN poemContent on poemContent.name = poemLocations.name JOIN poemNodeWidths on poemNodeWidths.name = poemContent.name"}
  }).done(function(msg) {
    poems = $.parseJSON(msg);

    // place nodes
    for(var i in poems){

    var node = sys.addNode(poems[i].name, {
        'label':poems[i].name,
         x: parseFloat(poems[i].x)/$maxx * 1.5,
         y: parseFloat(poems[i].y)/$maxy * 1.8,
         'color':'#11DDBB',
        'width':parseFloat(poems[i].width),
        'content':poems[i].content
    });
  } 

  }); 

  $.ajax({
    url: "docHandler.php",
    type: "POST",
    async: false,
    data: {db: "evanrose_poems", argument: "SELECT * FROM poemEdges"}
  }).done(function(msg) {
    edges = $.parseJSON(msg);

    // place edges
    for(var i in edges){
     if(edges[i].Distance > 0.80 && sys.getEdges(edges[i].B,edges[i].A).length == 0)
        sys.addEdge(edges[i].A, edges[i].B,{'color':'black','word1':edges[i].word1,
    'word2':edges[i].word2,'word3':edges[i].word3});
   }
  });
</script>
<div id = "content"><a href = "#">Close Poem</a><div id = "poem"></div>
</div>

<div class = "center">
<?php include ("footer.php"); ?>
</div>

</body>
</html>
