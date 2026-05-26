
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<title>Articles</title>
<head>
  <link rel="stylesheet" href="style.css" type="text/css">
  <script src="jquery.js"></script>
  <script src="arbor.js"></script>
  <script src="graphics.js"></script>
  <script src="articlerenderer.js"></script>
  <script src="functions.js"></script>
  <!--[if IE]><script type="text/javascript" src="excanvas.js"></script><![endif]-->
</head>
<body>
<?php include ("navigation.php"); ?>
 <div class = "center">
   <br/>
  <div id = "description">
    <b><font size="5">Article Visualization</font></b><br/><br/>
  The articles I wrote during my four years on the staff of <a href =
    "http://www.thecrimson.com">The Harvard Crimson</a> are displayed
    below. Each article
    is represented as a node, and edges represent strong similarity
    among articles. Place your mouse over any article to get its name
    as well as the names of the articles to which it is most similar. Article
    names will also display in the upper left corner of the graph.
    <br/><br/>
    Article designations (as represented by node color) were made using
    a clustering program, but correspond well to article
    topicality. Red nodes represent stories written while covering the <a
    href = "http://seas.harvard.edu/">Harvard School of Engineering
    and Applied Sciences</a>, light green nodes represent stories written
    while covering <a href =
    "http://huhs.harvard.edu/Home.aspx">University Health
    Services</a>, teal nodes represent stories written while covering
    Politics and Advocacy, and purple nodes (mostly) represent my smattering of
    arts and opinion articles.
    <br/><br/>
    Click on any node to go to the article on The Crimson website. To
    see excerpts from a few of my lengthier Crimson pieces, head to the 
   <a href = "articlelist.php">Selected Clips</a> page. <!-- To learn about how this
   visualization was generated, check out ProseMapper on the <a href =
  "projects.php">Projects Page</a>.--> <br/><br/>
</div>
</div>

<br/><br/><br/>

<canvas id="viewport" width = "800" height = "800"></canvas>
<script language="javascript" type="text/javascript">
 var sys = arbor.ParticleSystem(10000,0,1.0);
 sys.renderer = Renderer("#viewport");

  $.ajax({
    url: "docHandler.php",
    type: "POST",
    async: false,
    data: {db: "evanrose_articles",
    argument: "SELECT MAX(ABS(y)),MAX(ABS(x)) FROM articleLocations"}
  }).done(function(msg) {
    maxes = ($.parseJSON(msg));
    $maxy = maxes[0]["MAX(ABS(y))"];
    $maxx = maxes[0]["MAX(ABS(x))"];
 });



 $.ajax({
    url: "docHandler.php",
    type: "POST",
    async: false,
    data: {db: "evanrose_articles", argument: "SELECT * FROM articleLocations JOIN articleContent on articleContent.name = articleLocations.name"}
  }).done(function(msg) {
    articles = $.parseJSON(msg);

    // place nodes
    for(var i in articles){
    var node = sys.addNode(articles[i].name, {
        x: parseFloat(articles[i].x)/$maxx * 1.45,
        y: parseFloat(articles[i].y)/$maxy * 1.45,
       'cluster':parseInt(articles[i].cluster),
       'content':articles[i].content 
    });

 } 

  }); 


  $.ajax({
    url: "docHandler.php",
    type: "POST",
    async: false,
    data: {db: "evanrose_articles", argument: "SELECT * FROM articleEdges"}
  }).done(function(msg) {
    edges = $.parseJSON(msg);

    // place edges
    for(var i in edges){
    if(parseFloat(edges[i].Distance) > 0.98 && sys.getEdges(edges[i].B,edges[i].A).length == 0)
        sys.addEdge(edges[i].A, edges[i].B,{'color':'black','word1':edges[i].word1,
           'word2':edges[i].word2,'word3':edges[i].word3}); 
  } 
  }); 
</script>
<div id = "spanner">
 <div id = "content"><a href = "#">Close Poem</a><div id = "poem"></div>
</div> 
</div>
<div id = "test"></div>

<div class = "center">
<?php include ("footer.php"); ?>
</div>

</body>
</html>
