/*
*	KPMG
*	doughnut.readonly.js
*	Space01 Ltd. 2013
* 	author : Rob Lone - info@fusionrobotdesign.com
*/

/*This invokes a doughnutReadonly. */

$.Core.doughnutReadonly ={
	init: function(){
		var that = this;
		
		var colourtheme = {
			"brown" :  ["#e87424", "#a8541a", "#683410"],
			"purple" :  ["#4e144e", "#8e258d", "#da39d9"]
		};
		
		$('[data-doughnut-pie-read="true"]').each(function(index) {
			var holder = $(this)[0];
			var data = that.generateData(holder);
			var theme = $(this).data("theme");
			var colours = colourtheme[theme];
			var radius = 64;
			$(this).addClass("read");
			that.buildchart(holder, data, colours, radius);
		});
	},
	generateData: function(holder){
		var json = new Array();
		
		var keysObj = {};
		var legendsarray = new Array();
		$(holder).find('.dataset li').each(function(index) {
			  
			  var key = $(this).find('.key').text();
			  var value = $(this).find('.value').text();
			  
				//__key obj
				var localKeyObj = {};
				localKeyObj[key] = "";				  

				//__legend array build
				var stream = {
					"name" : key,
					"population" : value
				}
			  
			  jQuery.extend(keysObj, localKeyObj);
			  
			  legendsarray.push(stream);	  
		});		
	
		var obj ={
			"legends": legendsarray
		};
		
		jQuery.extend(obj, keysObj);
		
		json.push(obj);		
		return json;
	},
	buildchart: function(holder, data, colours, radius){

		var padding = 10;

		var color = d3.scale.ordinal()
			.range(colours);

		var arc = d3.svg.arc()
			.outerRadius(radius)
			.innerRadius(radius - 20);

		var pie = d3.layout.pie()
			.sort(null)
			.value(function(d) { return d.population; });

		color.domain(
			d3.keys(data[0]).filter(function(key) {
				return key !== "legends"; 
			})
		);

		var legend = d3.select(holder).append("svg")
			.attr("class", "legend")
			.attr("width", radius * 1.7)
			.attr("height", radius * 2)
			.selectAll("g")
			.data(color.domain().slice().reverse())
			.enter().append("g")
			.attr("transform", function(d, i) { return "translate(0," + i * 25 + ")"; });

		legend.append("rect")
			.attr("width", 18)
			.attr("height", 18)
			.style("fill", color);

		legend.append("text")
			.attr("x", 24)
			.attr("y", 9)
			.attr("dy", ".35em")
			.text(function(d) { return d; });

		var svg = d3.select(holder).selectAll(".pie")
			.data(data)
			.enter().append("svg")
			.attr("class", "pie")
			.attr("width", radius * 2)
			.attr("height", radius * 2)
			.append("g")
			.attr("transform", "translate(" + radius + "," + radius + ")");

		svg.selectAll(".arc")
			.data(function(d) { return pie(d.legends); })
			.enter().append("path")
			.attr("class", "arc")
			.attr("d", arc)
			.style("fill", function(d) { return color(d.data.name); })
			.on("mouseover", mouseover)
			.on("mousemove", function(d) { return mousemove(d, color(d.data.name)); })
			.on("mouseout", mouseout);
				
		var totalUnits = svg.append("svg:text")
				.attr("class", "units")
				.attr("dy", 9)
				.attr("text-anchor", "middle") // text-align: right
				.text($(holder).data("chart-title"));			
			
			var div = d3.select("body").append("div")
				.attr("class", "tooltip")
				.style("opacity", 1e-6);

			function mouseover() {
			  div.transition()
				  .duration(500)
				  .style("opacity", 1);
			}

			function mousemove(d, color) {			  
			  div
				  .text(d.value+"%")
				  .style("border", "1px solid "+color)
				  .style("color", color)
				  .style("left", (d3.event.pageX - 64) + "px")
				  .style("top", (d3.event.pageY - 12) + "px");
			}

			function mouseout() {
			  div.transition()
				  .duration(500)
				  .style("opacity", 1e-6);
			}
	}
};