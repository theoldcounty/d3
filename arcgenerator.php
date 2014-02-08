
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>arc generator demo</title>
  
  
  

<script type='text/javascript'>//<![CDATA[ 
window.onload=function(){

	var arcGenerator = {
		radius: 100,
		oldData: "",
		init: function(data){
			var clone = jQuery.extend(true, {}, data);
			this.oldData = this.setData(clone, false);
			this.setup(this.setData(data, true));			
		},
		update: function(data){
			var clone = jQuery.extend(true, {}, data);			
			this.animate(this.setData(data, true));			
			this.oldData = this.setData(clone, false);
		},
		animate: function(data){
			var that = this;
			
			var chart = d3.select(".arcchart");
			that.generateArcs(chart, data);
		},	
		setData: function(data, isSorted){

			var diameter = 2 * Math.PI * this.radius;
			
			var localData = new Array();
			
			var innerPieSliceTotal = 0;
			for (x in data) {
				innerPieSliceTotal += data[x].value;
			}
			
			var displacement = 0;
			var oldBatchLength = 0;
			
			if(isSorted){
				data.sort(function(a, b) {  
					return b.value - a.value;
				});
			}			
			
			$.each(data, function(index, value) {				
				var riseLevels = value.riselevels;
				var machineType = value.label;				
				var innerPieSliceValue = value.value;
				
				var ratioToWorkWith = innerPieSliceValue/innerPieSliceTotal;
				var riseLevelCount = riseLevels.length;
				
				if(oldBatchLength !=undefined){				
					displacement+=oldBatchLength;
				}
				
				var arcBatchLength = (2*ratioToWorkWith)*Math.PI;
				var arcPartition = arcBatchLength/riseLevelCount;
				
					$.each(riseLevels, function( ri, value ) {
						var startAngle = (ri*arcPartition);
						var endAngle = ((ri+1)*arcPartition);
						
						if(index!=0){
							startAngle+=displacement;
							endAngle+=displacement;
						}
				
						riseLevels[ri]["startAngle"] = startAngle;
						riseLevels[ri]["endAngle"] = endAngle;
						riseLevels[ri]["machineType"] = machineType;					
					});
								
				oldBatchLength = arcBatchLength;
				
				localData.push(riseLevels);
			});
			
			var finalArray = new Array();
			
			$.each(localData, function(index, value) {
				$.each(localData[index], function(i, v) {
					finalArray.push(v);
				});
			});
			
			return finalArray;
		
		},
		generateArcs: function(chart, data){
			
			var that = this;
			
			//append previous value to it.			
			$.each(data, function(index, value) {				
				data[index]["previousEndAngle"] = that.oldData[index].endAngle; 
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
		
			var arc = d3.svg.arc()
					.innerRadius(that.radius)
					.outerRadius(function(d){
						var maxHeight = 100;
						var ratio = (d.height/maxHeight * 100)+that.radius;
						return ratio;
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
					"coordinates": [
						-82.134153,
						49.509757
					],
					"pieData": [
						{
							"label":"Blade Workstation",
							"value":123,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"							
								},
								{
									height: 10,
									color: "green"							
								}						
							]
						}, 
						{
							"label":"GenX", 
							"value":34,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 23,
									color: "yellow"
								},
								{
									height: 20,
									color: "green"
								}						
							]						
						}, 
						{
							"label":"GenY",
							"value":70,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"
								},
								{
									height: 10,
									color: "green"
								}						
							]						
						},
						{
							"label":"Laptop",
							"value":10,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"
								},
								{
									height: 10,
									color: "green"
								}						
							]						
						},
						{
							"label":"Physical Desktop",
							"value":4,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"
								},
								{
									height: 70,
									color: "green"
								}						
							]						
						}
					]
				},
				{
					"coordinates": [
						-82.134153,
						49.509757
					],
					"pieData": [
						{
							"label":"Blade Workstation",
							"value":23,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"							
								},
								{
									height: 10,
									color: "green"							
								}						
							]
						}, 
						{
							"label":"GenX", 
							"value":1134,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 23,
									color: "yellow"
								},
								{
									height: 20,
									color: "green"
								}						
							]						
						}, 
						{
							"label":"GenY",
							"value":70,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"
								},
								{
									height: 10,
									color: "green"
								}						
							]						
						},
						{
							"label":"Laptop",
							"value":10,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"
								},
								{
									height: 10,
									color: "green"
								}						
							]						
						},
						{
							"label":"Physical Desktop",
							"value":334,
							"riselevels": [
								{
									height: 50,
									color: "red"
								},
								{
									height: 100,
									color: "yellow"
								},
								{
									height: 70,
									color: "green"
								}						
							]						
						}
					]
				}				
			];
			
			var clone = jQuery.extend(true, {}, dataCharts);
			
			arcGenerator.init(clone[0].pieData);
			
			$(".testers a").on( "click", function(e) {
				e.preventDefault();
				
				var clone = jQuery.extend(true, {}, dataCharts);
				
				var pos = $(this).parent("li").index();				
				
					$("#machinepie").empty();
					
					
					arcGenerator.update(clone[pos].pieData);			
			});
			
	});
}//]]>  

</script>


</head>
<body>
  <!DOCTYPE html>
<meta charset="utf-8">
<body>

	<!-- jquery libs -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	
    <!-- d3.js libs -->
	<script src="http://d3js.org/d3.v3.min.js"></script>
	
	
	<div id="holder">
		<div id="machinepie"></div>
		<div id="threshold"></div>
	</div>
	
	
	<ul class="testers">
		<li><a href="#">1</a></li>
		<li><a href="#">2</a></li>
	</ul>
	
<style>
	.chart{
		background: #eeeeee;
	}
	
	
	#holder{
		position:relative;
	}
	#machinepie{
		position: absolute;
	}
	
	#threshold{
	
	}
	
	
	.testers{
		list-style-type:none;
	}
</style>



</body>
</html>
  
</body>


</html>

