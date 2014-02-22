
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> - jsFiddle demo</title>
  
  <script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>
  
  
  
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  
    
      <script type='text/javascript' src="http://d3js.org/d3.v3.min.js"></script>
    
  
  <style type='text/css'>
    
  </style>
  


<script type='text/javascript'>
$(window).load(function(){
function getRandomInt (min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min;
		}
		
 
			var buildCircle = {
					init: function(){
					var dataset = [],
					i = 0;

					for(i=0; i<5; i++){
						
						var locale = {
							"value": getRandomInt (20, 40),
							"xcoord": getRandomInt (50, 300),
							"ycoord": getRandomInt (50, 300),
							"alarmLevel": getRandomInt (0, 100)
						}
					
					
						dataset.push(locale);
					}        

					var sampleSVG = d3.select("#viz")
						.append("svg")
						.attr("width", 400)
						.attr("height", 400)
						.append("g")
						.attr("transform", "translate(140, 160)")
						
						
					

						var circleGroup = sampleSVG.append("g")
											.attr("class", "circles");

							circleGroup.selectAll("circle")
								.data(dataset)
								.enter().append("circle")
								.style("stroke", "gray")
								.style("fill", "red")
								.attr("r", function(d){
									return d.value;
								})
								.attr("cx", function(d){
									return d.xcoord;
								})
								.attr("cy", function(d){
									return d.ycoord;
								});
								
                        var speedLineGroup = sampleSVG.append("g")
										.attr("class", "speedlines");



makeRings()


                        
 //window.setInterval(makeRings, 1000);

					function makeRings() {
						var datapoints = circleGroup.selectAll("circle");
						var radius = 1;
					  
							function myTransition(circleData){
								
								var transition = d3.select(this).transition();

									speedLineGroup.append("circle")
									  .attr({"class": "ring",
											 "fill":"red",
											 "stroke":"red",
											 "cx": circleData.xcoord,
											 "cy": circleData.ycoord,
											 "r":radius,
											 "opacity": 0.4,
											 "fill-opacity":0.1
											})
									  .transition()
									  .duration(function(){					
										return (100/circleData.alarmLevel)*3000;
									  })
									  .attr("r", radius + 100 )
									  .attr("opacity", 0)
									  .remove();
								

								//transition.each('end', myTransition);
							}
					  
					  datapoints.each(myTransition);
					}                       
     

	
				}
			}


		$(document).ready(function() {
			buildCircle.init();
		});		

});

</script>


</head>
<body>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<div id="holder">
		<div id="viz"></div>
	</div>
  
</body>


</html>

