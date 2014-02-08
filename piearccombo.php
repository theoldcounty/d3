
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Pie Arc Combo</title>
  

<script type='text/javascript'>//<![CDATA[ 
window.onload=function(){
(function($){var privateFunction=function(){};var methods={init:function(e){return this.each(function(){var t=$(this);var n=t.data("doughnutPie");if(typeof n=="undefined"){var r={propertyName:"value",onSomeEvent:function(){}};n=$.extend({},r,e);t.data("doughnutPie",n)}else{n=$.extend({},n,e)}methods.setup(this,e)})},destroy:function(e){return $(this).each(function(){var e=$(this);e.removeData("doughnutPie")})},transitions:function(e){return $(this).each(function(){var t=$(this);methods.update(this,e)})},setup:function(e,t){this.currentPieData=t.data;var n=t.specs.colors;this.isInit=true;this.homegrownparent=e.id;this.setMaxObj();var r=t.specs.w;var i=t.specs.h;this.r=t.specs.r;this.ir=t.specs.ir;this.irw=t.specs.irw;this.type=t.specs.type;var s=this;this.createPie(r,i,n,function(){s.bindEvent();s.transitions(t.data)})},isInit:false,maxObj:"",setMaxObj:function(){var e=this;var t=Math.max.apply(null,this.currentPieData.map(function(e){return e["octetTotalCount"]}));$.each(this.currentPieData,function(n,r){if(r.octetTotalCount==t){e.maxObj=r;return}})},currentPieData:null,newPieData:null,oldPieData:null,futurePieData:null,r:80,ir:45,textOffset:14,donut:null,invokeColor:function(setColors){switch(setColors[0].name){case"Spectrum":this.color=d3.scale.ordinal().range(["#538ed5","#953735","#e46d0a","#75923c","#b2a1c7","#dc143c","#87cefa","#90ee90","#add8e6","#d3d3d3","#cf1256","#12cf5e"]);break;case"AmberRed":this.color=d3.scale.ordinal().range(["#ffff00","#ff0000"]);break;default:var colorType="colorbrewer."+setColors[0].name+"["+setColors[0].col+"]";this.color=d3.scale.ordinal().domain(eval(setColors[0].domain)).range(eval(colorType))}},createPie:function(e,t,n,r){var i,s,o;this.donut=d3.layout.pie().value(function(e){return e.octetTotalCount});this.invokeColor(n);this.arc=d3.svg.arc().startAngle(function(e){return e.startAngle}).endAngle(function(e){return e.endAngle}).innerRadius(this.ir).outerRadius(this.r);var u=this.homegrownparent;var a=d3.select("#"+u).append("svg:svg").attr("width",e).attr("height",t).attr("viewBox","0 0 "+parseInt(e,10)+" "+parseInt(t,10)).attr("perserveAspectRatio","xMinYMid");this.arc_group=a.append("svg:g").attr("class","arc").attr("transform","translate("+e/2+","+t/2+")");var f=this.arc_group.append("svg:circle").attr("class","circle_path").attr("r",this.r);var l=a.append("svg:g").attr("class","center_group").attr("transform","translate("+e/2+","+t/2+")");var c=l.append("svg:circle").attr("class","white_circle").attr("fill","white").attr("r",this.irw);if(this.type!="mini"){this.label_group=a.append("svg:g").attr("class","label_group").attr("transform","translate("+e/2+","+t/2+")");var h=l.append("svg:text").attr("class","label").attr("dy",25).attr("text-anchor","middle");this.totalValue=l.append("svg:text").attr("class","total").attr("dy",7).attr("text-anchor","middle").text("Waiting...")}r()},bindEvent:function(){var e=this},totalOctets:0,tweenDuration:350,update:function(e,t){this.futurePieData=t;this.newPieData=this.getNewData();this.currentPieData=this.newPieData;this.setMaxObj();this.homegrownparent=e.id;this.totalOctets=0;this.updatePie()},filteredPieData:[],streakerDataAdded:"",getNewData:function(){return this.futurePieData},removePieTween:function(e,t){var n=this;s0=2*Math.PI;e0=2*Math.PI;var t=d3.interpolate({startAngle:e.startAngle,endAngle:e.endAngle},{startAngle:s0,endAngle:e0});return function(e){var n=t(e);return methods.arc(n)}},pieTween:function(e){var t=methods.oldPieData;var n;var r;if(t[i]){n=t[i].startAngle;r=t[i].endAngle}else if(!t[i]&&t[i-1]){n=t[i-1].endAngle;r=t[i-1].endAngle}else if(!t[i-1]&&t.length>0){n=t[t.length-1].endAngle;r=t[t.length-1].endAngle}else{n=0;r=0}var i=d3.interpolate({startAngle:n,endAngle:r},{startAngle:e.startAngle,endAngle:e.endAngle});return function(e){var t=i(e);return methods.arc(t)}},textTween:function(e,t){var n=methods.oldPieData;var r;if(n[t]){r=(n[t].startAngle+n[t].endAngle-Math.PI)/2}else if(!n[t]&&n[t-1]){r=(n[t-1].startAngle+n[t-1].endAngle-Math.PI)/2}else if(!n[t-1]&&n.length>0){r=(n[n.length-1].startAngle+n[n.length-1].endAngle-Math.PI)/2}else{r=0}var i=(e.startAngle+e.endAngle-Math.PI)/2;var s=d3.interpolateNumber(r,i);return function(e){var t=s(e);return"translate("+Math.cos(t)*(methods.r+methods.textOffset)+","+Math.sin(t)*(methods.r+methods.textOffset)+")"}},filterData:function(e,t,n){e.name=methods.streakerDataAdded[t].title;e.value=methods.streakerDataAdded[t].octetTotalCount;methods.totalOctets+=e.value;return e.value>0},updatePie:function(){this.streakerDataAdded=this.newPieData;this.oldPieData=this.filteredPieData;this.newPieData=this.donut(this.streakerDataAdded);this.filteredPieData=this.newPieData.filter(this.filterData);var e=this.filteredPieData;if(e.length>0&&this.oldPieData.length>0){this.animatePie(e)}},animatePie:function(e){var t=this;var n=this.homegrownparent;var r=d3.select("#"+n);r.selectAll("circle").remove();var i=d3.select("#"+n+" .total");i.text(function(){var e=t.maxObj.octetTotalCount/t.totalOctets*100;$("#"+n+" .label").text(t.maxObj.title);return e.toFixed(1)+"%"});var s=d3.select("#"+n+" .arc");paths=s.selectAll("path").data(e);paths.enter().append("svg:path").attr("class",function(e,t){return e.name+" stroke_path"}).attr("stroke-width",.5).attr("fill",function(e,n){return t.color(n)}).transition().duration(this.tweenDuration).attrTween("d",this.pieTween);paths.transition().duration(this.tweenDuration).attrTween("d",this.pieTween);paths.exit().transition().duration(this.tweenDuration).attrTween("d",this.removePieTween).remove();if(this.type!="mini"){var o=.1;var u=d3.select("#"+n+" .label_group");lines=u.selectAll("line").data(e);lines.enter().append("svg:line").attr("x1",0).attr("x2",0).attr("y1",function(e){if(e.value>o){return-t.r-3}else{return-t.r}}).attr("y2",function(e){if(e.value>o){return-t.r-8}else{return-t.r}}).attr("stroke","gray").attr("transform",function(e){return"rotate("+(e.startAngle+e.endAngle)/2*(180/Math.PI)+")"});lines.transition().duration(this.tweenDuration).attr("transform",function(e){return"rotate("+(e.startAngle+e.endAngle)/2*(180/Math.PI)+")"});lines.exit().remove();valueLabels=u.selectAll("text.value").data(e);valueLabels.enter().append("svg:text").attr("class","value").attr("transform",function(e){return"translate("+Math.cos((e.startAngle+e.endAngle-Math.PI)/2)*(t.r+t.textOffset)+","+Math.sin((e.startAngle+e.endAngle-Math.PI)/2)*(t.r+t.textOffset)+")"}).attr("dy",function(e){if((e.startAngle+e.endAngle)/2>Math.PI/2&&(e.startAngle+e.endAngle)/2<Math.PI*1.5){return 5}else{return-7}}).attr("text-anchor",function(e){if((e.startAngle+e.endAngle)/2<Math.PI){return"beginning"}else{return"end"}}).text(function(e){if(e.value>o){var n=e.value/t.totalOctets*100;return n.toFixed(2)+"%"}});valueLabels.transition().duration(this.tweenDuration).attrTween("transform",this.textTween);valueLabels.exit().remove();nameLabels=u.selectAll("text.units").data(e);nameLabels.enter().append("svg:text").attr("class","units").attr("transform",function(e){return"translate("+Math.cos((e.startAngle+e.endAngle-Math.PI)/2)*(t.r+t.textOffset)+","+Math.sin((e.startAngle+e.endAngle-Math.PI)/2)*(t.r+t.textOffset)+")"}).attr("dy",function(e){if((e.startAngle+e.endAngle)/2>Math.PI/2&&(e.startAngle+e.endAngle)/2<Math.PI*1.5){return 17}else{return 5}}).attr("text-anchor",function(e){if((e.startAngle+e.endAngle)/2<Math.PI){return"beginning"}else{return"end"}}).text(function(e){if(e.value>o){return e.name}});nameLabels.transition().duration(this.tweenDuration).attrTween("transform",this.textTween);nameLabels.exit().remove()}this.currentPieData=this.newPieData}};$.fn.doughnutPie=function(){var e=arguments[0];if(methods[e]){e=methods[e];arguments=Array.prototype.slice.call(arguments,1)}else if(typeof e=="object"||!e){e=methods.init}else{$.error("Method "+e+" does not exist on jQuery.doughnutPie");return this}return e.apply(this,arguments)}})(jQuery);var goPie={destroyChart:function(e){$(e).doughnutPie("destroy")},initChart:function(e,t){var n=t.color;switch(n){case"YlGn":var r=[{name:"YlGn",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"YlGnBu":var r=[{name:"YlGnBu",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"GnBu":var r=[{name:"GnBu",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"BuGn":var r=[{name:"BuGn",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"PuBuGn":var r=[{name:"PuBuGn",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"PuBu":var r=[{name:"PuBu",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"BuPu":var r=[{name:"BuPu",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"RdPu":var r=[{name:"RdPu",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"PuRd":var r=[{name:"PuRd",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"OrRd":var r=[{name:"OrRd",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"YlOrRd":var r=[{name:"YlOrRd",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"YlOrBr":var r=[{name:"YlOrBr",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"Purples":var r=[{name:"Purples",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"Blues":var r=[{name:"Blues",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"Greens":var r=[{name:"Greens",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"brightOrange":var r=[{name:"Oranges",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"Reds":var r=[{name:"Reds",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"greys":var r=[{name:"Greys",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"PuOr":var r=[{name:"PuOr",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"BrBG":var r=[{name:"BrBG",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"PRGn":var r=[{name:"PRGn",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"PiYG":var r=[{name:"PiYG",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"RdBu":var r=[{name:"RdBu",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"RdGy":var r=[{name:"RdGy",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"RdYlBu":var r=[{name:"RdYlBu",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"Spectral":var r=[{name:"Spectral",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"RdYlGn":var r=[{name:"RdYlGn",col:8,domain:["foo","bar","baz","gaz","bar","baz","gaz"]}];break;case"AmberRed":var r=[{name:"AmberRed"}];break;default:var r=[{name:"Spectrum"}]}var i="full";if(t.ir<80){i="mini"}var s=[{title:"test",octetTotalCount:Math.ceil(Math.random()*1e5)}];var o={data:s,specs:{colors:r,w:t.w,h:t.h,r:t.r,ir:t.ir,irw:t.irw,type:i}};$(e).doughnutPie("init",o)},updateCharts:function(e,t){$(e).doughnutPie("transitions",t)},resizePie:function(e){var t=$(e).find("svg");var n=t.width()/t.height();var r=t.parent().width();t.attr("width",r);t.attr("height",Math.round(r/n))}};var multiLevelPie={initPie:function(e,t,n,r,i,s,o){var u={color:t,w:n,h:r,r:i,irw:s,ir:o};goPie.initChart(e,u)},updatePie:function(e,t){console.log("DATA TO FEED ME PIE",t);var n=new Array;$.each(t,function(e,t){var r={title:t.label,octetTotalCount:t.value};n.push(r)});goPie.updateCharts(e,n)},initMachinePie:function(e){this.initPie("#machinepie","Spectrum",400,400,90,70,70);console.log("prob data",e);this.updatePie("#machinepie",e)}}

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

			/*
			function arcTween(b) {
				var i = d3.interpolate({value: b.endAngle-0.1}, b);
				
				return function(t) {
					return that.getArc()(i(t));
				};
			}*/

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
			
			multiLevelPie.initMachinePie(clone[0].pieData);
			arcGenerator.init(clone[0].pieData);
			
			$(".testers a").on( "click", function(e) {
				e.preventDefault();
				
				var clone = jQuery.extend(true, {}, dataCharts);
				
				var pos = $(this).parent("li").index();				
				
					$("#machinepie").empty();
					multiLevelPie.initPie("#machinepie", "Spectrum", 400, 400, 90, 70, 70);
					

					multiLevelPie.updatePie("#machinepie", clone[pos].pieData);				
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

