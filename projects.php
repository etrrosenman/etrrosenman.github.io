<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<title>Evan T.R. Rosenman</title>
<head>
  <link rel="stylesheet" href="style.css" type="text/css">
 <script src="jquery.js"></script> 
  <script src="functions.js"></script>
</head>
<body>
  <?php include ("navigation.php"); ?>
  <div class = "center">
    <br/>
  <div id = "description">
    <b><font size="5">Projects</font></b><br/>
   <ul id = "projects">
      <li class = "projectTitle">ProseMapper (<a href = "poems.php">poems</a> and <a
     href="articles.php">articles</a>)</li>
       <ul>
	 <li class = "description">
	 ProseMapper is a project designed to visualize a corpus of
	 documents in a user-friendly way. It used on this website to
	 display both my poetry and my Crimson articles such that a
	 viewer can explore my writing by getting a sense of a
	 poem or article's topic prior to reading it. ProseMapper
	 encompasses a series of programs which take in a set of text
	 documents, calculate their pairwise similarities, calculate
	 an optimal spatial layout for nodes representing each
	 document, and visualize these nodes. <a href =
	 "http://code.google.com/p/linloglayout/">LinLogLayout</a> is used for
	 node clustering and <a href =
	 "http://arborjs.org/">Arbor.js</a>
	 is used for node display.
	 Information about how this project was designed and
	 coded can be found <a href = "Visualization.pdf">here</a>.
	 </li>
       </ul>	 
      <li class = "projectTitle"><a href =
     "http://team3.cs179.org/demo">JobLink</a></li>
        <ul>
	 <li class = "description">
	  JobLink--completed in a team with <a href =
	  "http://www.linkedin.com/pub/olga-zinoveva/29/a85/289">Olga
	  Zinoveva</a> and <a href = "http://www.matthewchartier.com/">Matthew
	  Chartier</a> as a final project for Computer Science 179--is
	  an mobile app designed to aid students in the recruiting
	  process. The idea for the project emerged from our
	  collective observation that students often seek information
	  informally in order to discover potential employers and to
	  learn about interviewing. We designed an algorithm to determine companies' similarity
	  and visualize these connections in a user-friendly
	  interface, and also used machine learning to generate
	  company recomendations for students seeking employment. The
	  site layout was generated using jQuery and jQuery mobile,
	  while the graph was generated using arbor.js. Noes were laid
	  out using an algorithm from LinLogLayout. 
	 </li>
       </ul>	 
   </ul>
  </div>
  <?php include ("footer.php"); ?>

</div>
</body>
</html>