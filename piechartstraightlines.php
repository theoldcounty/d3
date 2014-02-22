
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>D3.js donut chart - jsFiddle demo</title>
  
  <script type='text/javascript' src='http://code.jquery.com/jquery-1.6.4.js'></script>
  <link rel="stylesheet" type="text/css" href="/css/normalize.css">
  
  
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  
    
      <script type='text/javascript' src="http://d3js.org/d3.v3.min.js"></script>
    
  
  <style type='text/css'>
    body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  margin: auto;
  position: relative;
  width: 960px;
}

text {
  font: 10px sans-serif;
}

form {
  position: absolute;
  right: 10px;
  top: 10px;
}
  </style>
  


<script type='text/javascript'>
$(window).load(function(){
var dataset = [
    {
        data: [53245, 28479, 19697, 24037, 40245]
    },
    {
        data: [855, 79, 97, 237, 245]
    }
];


var theAmazingPie = {

    buildPieStructure: function(){
             
        this.width = 300;
        this.height = 300;
        this.radius = Math.min(this.width, this.height) / 2;
        
        this.color = d3.scale.category20();
        
        this.pie = d3.layout.pie()
            .sort(null);
        
        
        this.arc = d3.svg.arc()
            .innerRadius(this.radius - 100)
            .outerRadius(this.radius - 50);
        
       this.svg = d3.select("#theamazingpie").append("svg")
            .attr("width", this.width)
            .attr("height", this.height)
            .append("g")
            .attr("transform", "translate(" + this.width / 2 + "," + this.height / 2 + ")");
        
  
    },
    oldPieData: "",
    pieTween: function(d, i){
        var that = this;
        
						var theOldDataInPie = theAmazingPie.oldPieData;
						// Interpolate the arcs in data space

						var s0;
						var e0;

						if(theOldDataInPie[i]){
								s0 = theOldDataInPie[i].startAngle;
								e0 = theOldDataInPie[i].endAngle;
						} else if (!(theOldDataInPie[i]) && theOldDataInPie[i-1]) {
								s0 = theOldDataInPie[i-1].endAngle;
								e0 = theOldDataInPie[i-1].endAngle;
						} else if(!(theOldDataInPie[i-1]) && theOldDataInPie.length > 0){
								s0 = theOldDataInPie[theOldDataInPie.length-1].endAngle;
								e0 = theOldDataInPie[theOldDataInPie.length-1].endAngle;
						} else {
								s0 = 0;
								e0 = 0;
						}

						var i = d3.interpolate({startAngle: s0, endAngle: e0}, {startAngle: d.startAngle, endAngle: d.endAngle});

						return function(t) {
								var b = i(t);
								return theAmazingPie.arc(b);
						};
	},
    removePieTween: function(d, i) {				
						var that = this;
						s0 = 2 * Math.PI;
						e0 = 2 * Math.PI;
						var i = d3.interpolate({startAngle: d.startAngle, endAngle: d.endAngle}, {startAngle: s0, endAngle: e0});

						return function(t) {
								var b = i(t);
								return theAmazingPie.arc(b);
						};
    },
    update: function(dataSet){
        console.log("update pie", dataSet);
        
        var that = this;
        
        this.piedata = this.pie(dataSet);      
        
               
        
        
        this.path = this.svg.selectAll("path.pie")
            .data(this.piedata);
        
        this.path.enter().append("path")
            .attr("class", "pie")
            .attr("fill", function(d, i) {
                return that.color(i); 
            })
            //.attr("d", this.arc);
            .transition()
				.duration(300)
				.attrTween("d", that.pieTween);
		
        this.path
				.transition()
				.duration(300)
				.attrTween("d", that.pieTween);
		
        this.path.exit()
				.transition()
				.duration(300)
				.attrTween("d", that.removePieTween)
				.remove();    
        
        
        
        
        
        var labels = this.svg.selectAll("text")
            .data(this.piedata);
        labels.enter()
            .append("text")
            .attr("text-anchor", "middle");
        labels
            .attr("x", function(d) {
                var a = d.startAngle + (d.endAngle - d.startAngle)/2 - Math.PI/2;
                d.cx = Math.cos(a) * (that.radius - 75);
                return d.x = Math.cos(a) * (that.radius - 20);
            })
            .attr("y", function(d) {
                var a = d.startAngle + (d.endAngle - d.startAngle)/2 - Math.PI/2;
                d.cy = Math.sin(a) * (that.radius - 75);
                return d.y = Math.sin(a) * (that.radius - 20);
            })
            .text(function(d) { 
                return d.value; 
            })
            .each(function(d) {
                var bbox = this.getBBox();
                d.sx = d.x - bbox.width/2 - 2;
                d.ox = d.x + bbox.width/2 + 2;
                d.sy = d.oy = d.y + 5;
            });
        
        this.svg.append("defs").append("marker")
            .attr("id", "circ")
            .attr("markerWidth", 6)
            .attr("markerHeight", 6)
            .attr("refX", 3)
            .attr("refY", 3)
            .append("circle")
            .attr("cx", 3)
            .attr("cy", 3)
            .attr("r", 3);
        
        var pointers = this.svg.selectAll("path.pointer")
            .data(this.piedata);
        pointers.enter()
            .append("path")
            .attr("class", "pointer")
            .style("fill", "none")
            .style("stroke", "black")
            .attr("marker-end", "url(#circ)");
        pointers.transition().attr("d", function(d) {
                if(d.cx > d.ox) {
                    return "M" + d.sx + "," + d.sy + "L" + d.ox + "," + d.oy + " " + d.cx + "," + d.cy;
                } else {
                    return "M" + d.ox + "," + d.oy + "L" + d.sx + "," + d.sy + " " + d.cx + "," + d.cy;
                }
            });
        
        
        
        this.oldPieData = this.piedata;
    }
}


$(document).ready(function() {
    theAmazingPie.buildPieStructure();    
    theAmazingPie.update(dataset[0].data);
    
    $(".testers a").on( "click", function(e) {
        e.preventDefault();    
        
        var clone = jQuery.extend(true, {}, dataset);        
        var pos = $(this).parent("li").index();        
        theAmazingPie.update(clone[pos].data);			
    });    
});




});

</script>


</head>
<body>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<div id="holder">

		<div id="theamazingpie"></div>
	</div>
	
		<ul class="testers">
		<li><a href="#">1</a></li>
		<li><a href="#">2</a></li>
	</ul>
  
</body>


</html>

