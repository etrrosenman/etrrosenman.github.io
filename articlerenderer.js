(function(){
  
  Renderer = function(canvas){
    var canvas = $(canvas).get(0)
    var ctx = canvas.getContext("2d");
    var gfx = arbor.Graphics(canvas)
    var particleSystem = null;


    var that = {
      init:function(system){
        particleSystem = system

        ctx.canvas.width  = window.innerWidth*0.85
        ctx.canvas.height = window.innerHeight
        particleSystem.screenSize(canvas.width, canvas.height) 
        particleSystem.screenPadding(-100)
        $("#viewport").css("background-color","#DDDDFF");

        that.initMouseHandling()
      },

      redraw:function(){
        if (!particleSystem) return

        gfx.clear() // convenience ƒ: clears the whole canvas rect

        // draw the nodes & save their bounds for edge drawing
        var nodeBoxes = {}
        particleSystem.eachNode(function(node, pt){
          // node: {mass:#, p:{x,y}, name:"", data:{}}
          // pt:   {x:#, y:#}  node position in screen coords

          // determine the box size and round off the coords if we'll be 
          // drawing a text label (awful alignment jitter otherwise...)
            var label = node.data.label||"";
            var w = 20;

          // draw a rectangle centered at pt
          if (node.data.cluster == 0) 
	      ctx.fillStyle = '#11DDBB';
	  else if(node.data.cluster == 1)
	      ctx.fillStyle = '#BB0011';
	  else if(node.data.cluster == 2)
	      ctx.fillStyle = '#99FF77';
	  else if (node.data.cluster == 3)
	      ctx.fillStyle = '#AA0088';
	  else
	      ctx.fillStyle = '#7799FF';

          if (node.data.color=='none') ctx.fillStyle = "white"

          gfx.rect(pt.x-w/2, pt.y-10, w,20, 4, {fill:ctx.fillStyle})
          nodeBoxes[node.name] = [pt.x-w/2, pt.y-11, w, 22]
        })    			

        // draw the edges
        particleSystem.eachEdge(function(edge, pt1, pt2){
          // edge: {source:Node, target:Node, length:#, data:{}}
          // pt1:  {x:#, y:#}  source position in screen coords
          // pt2:  {x:#, y:#}  target position in screen coords
          var weight = edge.data.weight
          var color = edge.data.color

          if (!color || (""+color).match(/^[ \t]*$/)) color = null

          // find the start point
          var tail = intersect_line_box(pt1, pt2, nodeBoxes[edge.source.name])
          var head = intersect_line_box(tail, pt2, nodeBoxes[edge.target.name])

          ctx.save() 
            ctx.beginPath()
            ctx.lineWidth = (!isNaN(weight)) ? parseFloat(weight) : 1
            ctx.strokeStyle = (color) ? color : "#cccccc"
            ctx.fillStyle = null

            ctx.moveTo(tail.x, tail.y)
            ctx.lineTo(head.x, head.y)
            ctx.stroke()
          ctx.restore()

          // draw an arrowhead if this is a -> style edge
          if (edge.data.directed){
            ctx.save()
              // move to the head position of the edge we just drew
              var wt = !isNaN(weight) ? parseFloat(weight) : 1
              var arrowLength = 6 + wt
              var arrowWidth = 2 + wt
              ctx.fillStyle = (color) ? color : "#cccccc"
              ctx.translate(head.x, head.y);
              ctx.rotate(Math.atan2(head.y - tail.y, head.x - tail.x));

              // delete some of the edge that's already there (so the point isn't hidden)
              ctx.clearRect(-arrowLength/2,-wt/2, arrowLength/2,wt)

              // draw the chevron
              ctx.beginPath();
              ctx.moveTo(-arrowLength, arrowWidth);
              ctx.lineTo(0, 0);
              ctx.lineTo(-arrowLength, -arrowWidth);
              ctx.lineTo(-arrowLength * 0.8, -0);
              ctx.closePath();
              ctx.fill();
            ctx.restore()
          }
        })



      },
      initMouseHandling:function(){
        // no-nonsense drag and drop (thanks springy.js)
        selected = null;
        nearest = null;
        var dragged = null;
        var oldmass = 1
	var mousedown = 0

        // set up a handler object that will initially listen for mousedowns then
        // for moves and mouseups while dragging
        var handler = {
          clicked:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            selected = nearest = dragged = particleSystem.nearest(_mouseP);

            // when user clicks on article, take them to the content
	    window.location.href = selected.node.data.content.replace("?print=1","");
          },
          dragged:function(e){
            return false
          },

          dropped:function(e){
            return false  
          }
        }
        $(canvas).mousedown(handler.clicked); 

        $(canvas).mousemove(function(e){
            var pos = $(this).offset();
            var p = {x:e.pageX-pos.left, y:e.pageY-pos.top};
            selected = nearest = dragged = particleSystem.nearest(p);

	    // clear old colors and color in nearest node and its edges
            particleSystem.eachNode(function(node, pt){
		node.data.color = "#11DDBB";
	    });
	    selected.node.data.color = "yellow";
	    temparray = sys.getEdgesFrom(selected.node).concat(sys.getEdgesTo(selected.node));
            for(var i in temparray)
	    {
		if(temparray[i].target != selected.node)
		    temparray[i].target.data.color = "orange";
		else if(temparray[i].source != selected.node)
		    temparray[i].source.data.color = "orange";
	    }
	    that.redraw();

            if (selected.node !== null){
                myarray = sys.getEdgesFrom(selected.node).concat(sys.getEdgesTo(selected.node));

		// show article name in upper right
		var text = selected.node.name; 
		ctx.font = "bold 25px Helvetica";
		ctx.textAlign = "left";
		var b = ctx.measureText(""+text).width + 30;
		ctx.fillStyle = "black";
		ctx.fillText(text,20,30);
		ctx.font = "bold 15px Helvetica";
		ctx.textAlign = "center";
		ctx.fillText(text,(sys.toScreen(selected.node.p)).x,(sys.toScreen(selected.node.p)).y);

    	        // show titles of similar articles articles when higlighted
                edgesOut = sys.getEdgesFrom(selected.node);
                edgesIn = sys.getEdgesTo(selected.node);

                for(var i in edgesOut)
		{
		    var text = edgesOut[i].target.name; 
		    ctx.font = "bold 12px Helvetica";
		    ctx.textAlign = "center";
		    var b = ctx.measureText(""+text).width + 30;
		    ctx.fillStyle = "black";
		    ctx.fillText(text,sys.toScreen(edgesOut[i].target.p).x,
				 sys.toScreen(edgesOut[i].target.p).y);
		} 
                for(var i in edgesIn)
		{
		    var text = edgesIn[i].source.name; 
		    ctx.font = "bold 12px Helvetica";
		    ctx.textAlign = "center";
		    var b = ctx.measureText(""+text).width + 30;
		    ctx.fillStyle = "black";
		    ctx.fillText(text,sys.toScreen(edgesIn[i].source.p).x,
				 sys.toScreen(edgesIn[i].source.p).y);
		} 


         	// show common words between articles when higlighted
          /*      for(var i in myarray)
		{
		    // needs to be fixed to wrap text
		    xcoord = (sys.toScreen(myarray[i].target.p).x - sys.toScreen(myarray[i].source.p).x)/2 + sys.toScreen(myarray[i].source.p).x; 
		    ycoord = (sys.toScreen(myarray[i].target.p).y - sys.toScreen(myarray[i].source.p).y)/2 + sys.toScreen(myarray[i].source.p).y; 
                    var text = (myarray[i].data.word3 == "") ? (myarray[i].data.word1 + ", " + myarray[i].data.word2) : 
			(myarray[i].data.word1 + ", " + myarray[i].data.word2 + ", " + myarray[i].data.word3);

		    ctx.font = "bold italic 13px Helvetica"
		    ctx.textAlign = "center"
		    var b = ctx.measureText(""+text).width + 30

                    ctx.fillStyle = "rgba(256, 256, 256, 0.7)"
                    ctx.fillRect (xcoord-b/2, ycoord-15, b,20)
		    ctx.fillStyle = "blue"
                    ctx.fillText(text, xcoord, ycoord)
		} */
            } 
            return false;
        });
      }
    }

    // helpers for figuring out where to draw arrows (thanks springy.js)
    var intersect_line_line = function(p1, p2, p3, p4)
    {
      var denom = ((p4.y - p3.y)*(p2.x - p1.x) - (p4.x - p3.x)*(p2.y - p1.y));
      if (denom === 0) return false // lines are parallel
      var ua = ((p4.x - p3.x)*(p1.y - p3.y) - (p4.y - p3.y)*(p1.x - p3.x)) / denom;
      var ub = ((p2.x - p1.x)*(p1.y - p3.y) - (p2.y - p1.y)*(p1.x - p3.x)) / denom;

      if (ua < 0 || ua > 1 || ub < 0 || ub > 1)  return false
      return arbor.Point(p1.x + ua * (p2.x - p1.x), p1.y + ua * (p2.y - p1.y));
    }

    var intersect_line_box = function(p1, p2, boxTuple)
    {
      var p3 = {x:boxTuple[0], y:boxTuple[1]},
          w = boxTuple[2],
          h = boxTuple[3]

      var tl = {x: p3.x, y: p3.y};
      var tr = {x: p3.x + w, y: p3.y};
      var bl = {x: p3.x, y: p3.y + h};
      var br = {x: p3.x + w, y: p3.y + h};

      return intersect_line_line(p1, p2, tl, tr) ||
            intersect_line_line(p1, p2, tr, br) ||
            intersect_line_line(p1, p2, br, bl) ||
            intersect_line_line(p1, p2, bl, tl) ||
            false
    }

    return that
  }    
  
})()