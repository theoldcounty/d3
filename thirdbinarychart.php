
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> - jsFiddle demo</title>
  
  <script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>
  
  
  
  <link rel="stylesheet" type="text/css" href="/css/result-light.css">
  
    
      <script type='text/javascript' src="http://d3js.org/d3.v3.min.js"></script>
    
  
  <style type='text/css'>
    .chart{
    background:#d1cec9;    
}
.arcchart path{
    stroke: #2c2c2e;
    stroke-width: 1px;
}

  </style>
  


<script type='text/javascript'>
$(window).load(function(){
	var arcGenerator = {
		radius: 340,
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
			
            var oldEndAngle = Math.PI;			
			
			var segmentValueSum = 0;
			$.each(data[0].segments, function( ri, va) {
				segmentValueSum+= va.value;
			});
			
				
			$.each(data[0].segments, function(ri, value) {						
           	
				var startAngle = oldEndAngle;
                var endAngle = startAngle + (value.value/segmentValueSum)*(2/3)*Math.PI;                
	           		
				data[0].segments[ri]["startAngle"] = startAngle;
				data[0].segments[ri]["endAngle"] = endAngle;
				data[0].segments[ri]["index"] = ri;
				
                oldEndAngle = endAngle;
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
					.attr("height", 720)
						.append("svg:g")
						.attr("class", "arcchart")
						.attr("transform", "translate(400,220)");

			this.generateArcs(chart, data);		
		},
		getArc: function(){
			var that = this;
            
            var lowThreshold = 5;
            var highThreshold = 15
		
			var arc = d3.svg.arc()
					.innerRadius(function(d){
						if(d.index%2){
							return that.radius-highThreshold;
						}else{
							return that.radius-lowThreshold;
						}
					})
					.outerRadius(function(d){
						if(d.index%2){
							return that.radius+lowThreshold;
						}else{
							return that.radius+highThreshold;
						}
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
									color: "#2c2c2e"
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 23,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 40,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 33,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 45,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 40,
									color: "#2c2c2e"							
								},
								{
									value: 33,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 33,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 45,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 40,
									color: "#2c2c2e"							
								},
                                {
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 23,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 40,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 33,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 45,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 40,
									color: "#2c2c2e"							
								},
								{
									value: 33,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 33,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 50,
									color: "#2c2c2e"
								},
								{
									value: 45,
									color: "#2c2c2e"							
								},
								{
									value: 10,
									color: "#2c2c2e"							
								},
								{
									value: 40,
									color: "#2c2c2e"							
								}                                
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
									value: 100,
									color: "yellow"							
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

