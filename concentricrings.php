
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> - jsFiddle demo</title>
  
  <script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>
  
  
  
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  
    
      <script type='text/javascript' src="http://d3js.org/d3.v3.min.js"></script>
    
  
  <style type='text/css'>
    .slice path {
    stroke: #fff;
    stroke-width: 1px;
}

.textTop {
    font-family: 'Segoe UI';
    font-size: 12pt;
    fill: #bbb;
}

.textBottom {
    fill: #444;
    font-family: 'Segoe UI';
    font-weight: bold;
    font-size: 18pt;
}

.top {
    border: 1px solid #bbb;
    color: #777;
    font-family: 'Segoe UI';
    padding: 5px;
    text-decoration: none;
}

.top:hover {
    border: 1px solid #555;
    color: #333;
}
  </style>
  


<script type='text/javascript'>
$(window).load(function(){
	var arcGenerator = {
		radius: 100,
		oldData: "",
		init: function(data){
			var clone = jQuery.extend(true, {}, data);
			
			var preparedData = this.setData(clone);			
			this.oldData = preparedData;
			this.setup(preparedData);			
		},
		update: function(data){
			var clone = jQuery.extend(true, {}, data);
			
			var preparedData = this.setData(clone);
		
			this.animate(preparedData);			
			this.oldData = preparedData;
		},
		animate: function(data){
			var that = this;
			
			var chart = d3.select(".arcchart");
			that.generateArcs(chart, data);
		},	
		setData: function(data){
			var diameter = 2 * Math.PI * this.radius;			
			var localData = new Array();
			
			var segmentValueSum = 0;
			$.each(data[0].segments, function( ri, va) {
				segmentValueSum+= va.value;
			});
				
			$.each(data[0].segments, function(ri, value) {
								
				var segmentValue = value.value;
				
				var fraction = segmentValue/segmentValueSum;
				
				var arcBatchLength = fraction*2*Math.PI;
				var arcPartition = arcBatchLength;		
				
				var startAngle = 0;
				//var endAngle = ((ri+1)*arcPartition);				
	            var endAngle = startAngle + arcPartition; 
                
				data[0].segments[ri]["startAngle"] = startAngle;
				data[0].segments[ri]["endAngle"] = endAngle;
				data[0].segments[ri]["index"] = ri;
			});
				
			localData.push(data[0].segments);
						
			return localData[0];		
		},
		generateArcs: function(chart, data){
			
			var that = this;
			
			//append previous value to it.			
			$.each(data, function(index, value) {
				if(that.oldData[index] != undefined){
					data[index]["previousEndAngle"] = that.oldData[index].endAngle;
				}
				else{
					data[index]["previousEndAngle"] = 0;
				}
			});		
	
			var arcpaths = chart.selectAll("path")
					.data(data);
	
				arcpaths.enter().append("svg:path")
					.attr("class", function(d, i){
						return d.machineType;
					})	
					.style("fill", function(d, i){
						return d.color;
					})
					.transition()
					.ease("elastic")
					.duration(750)
					.attrTween("d", arcTween);				 
				
				arcpaths.transition()
					.ease("elastic")
					.style("fill", function(d, i){
						return d.color;
					})
					.duration(750)
					.attrTween("d",arcTween);
				 
				arcpaths.exit().transition()
					.ease("bounce")
					.duration(750)
					.attrTween("d", arcTween)
					.remove();

			function arcTween(b) {
			
				var prev = JSON.parse(JSON.stringify(b));
				prev.endAngle = b.previousEndAngle;
				var i = d3.interpolate(prev, b);

				return function(t) {
					return that.getArc()(i(t));
				};
			}			
		},
		setup: function(data){		
			var chart = d3.select("#threshold").append("svg:svg")
					.attr("class", "chart")
					.attr("width", 420)
					.attr("height", 420)
						.append("svg:g")
						.attr("class", "arcchart")
						.attr("transform", "translate(200,200)");

			this.generateArcs(chart, data);		
		},
		getArc: function(){
			var that = this;
			
			var radiusArray = [100, 80];
			
			function getRadiusRing(i){
				return that.radius-(i*20);				
			}
			var thickness = 15;
			
			var arc = d3.svg.arc()
					.innerRadius(function(d){
						return getRadiusRing(d.index);						
					})
					.outerRadius(function(d){
						return getRadiusRing(d.index)+thickness;	
					})
					.startAngle(function(d, i){
						return d.startAngle;
					})
					.endAngle(function(d, i){
						return d.endAngle;
					});		
			return arc;
		}
	}
    
    
    
	$(document).ready(function() {

		var dataCharts = [
				{
					"data": [
						{
							"segments": [
								{
									value: 50,
									color: "grey"
								},
								{
									value: 10,
									color: "darkgrey"							
								}/*,
								{
									value: 10,
									color: "blue"							
								},
								{
									value: 30,
									color: "orange"
								},
								{
									value: 3,
									color: "grey"							
								},
								{
									value: 10,
									color: "darkgrey"							
								},
								{
									value: 40,
									color: "grey"							
								},
								{
									value: 50,
									color: "darkgrey"
								},
								{
									value: 33,
									color: "grey"							
								},
								{
									value: 10,
									color: "darkgrey"							
								},
								{
									value: 50,
									color: "grey"
								},
								{
									value: 45,
									color: "darkgrey"							
								},
								{
									value: 10,
									color: "grey"							
								},
								{
									value: 40,
									color: "darkgrey"							
								},
								{
									value: 33,
									color: "grey"							
								},
								{
									value: 50,
									color: "darkgrey"
								},
								{
									value: 33,
									color: "grey"							
								},
								{
									value: 10,
									color: "darkgrey"							
								},
								{
									value: 50,
									color: "grey"
								},
								{
									value: 45,
									color: "darkgrey"							
								},
								{
									value: 10,
									color: "grey"							
								},
								{
									value: 40,
									color: "darkgrey"							
								}*/							
							]
						}
					]
				},
				{
					"data": [
						{
							"segments": [
								{
									value: 50,
									color: "red"
								},
								{
									value: 67,
									color: "orange"							
								},
								{
									value: 10,
									color: "green"							
								}						
							]
						}
					]
				}				
			];
			
			var clone = jQuery.extend(true, {}, dataCharts);
			
			arcGenerator.init(clone[0].data);
			
			$(".testers a").on( "click", function(e) {
				e.preventDefault();

				var clone = jQuery.extend(true, {}, dataCharts);

				var pos = $(this).parent("li").index();
				arcGenerator.update(clone[pos].data);			
			});
			
	});


}); 

</script>


</head>
<body>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<div id="holder">

		<div id="threshold"></div>
	</div>
	
		<ul class="testers">
		<li><a href="#">1</a></li>
		<li><a href="#">2</a></li>
	</ul>
  
</body>


</html>

