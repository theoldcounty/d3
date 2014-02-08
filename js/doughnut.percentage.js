/*
*	KPMG
*	doughnut.percentage.js
*	Space01 Ltd. 2013
* 	author : Rob Lone - info@fusionrobotdesign.com
*/

/*This invokes a doughnutPercentage. */

$.Core.doughnutPercentage ={
	init: function(){
		var that = this;
		
		var colourtheme = {
			"orange" :  ["#e87423", "#ebb700"],
			"charcoal" :  ["#e87423", "#5f615f"]
		};
		
		$('[data-doughnut-pie-percentage="true"]').each(function(index) {
			var holder = $(this)[0];
			var data = that.generateData(holder);
			var theme = $(this).data("theme");			
			$(this).addClass(theme+"theme");
			
			var textposition = $(this).data("text-position");
			$(this).addClass("text"+textposition);
			var colours = colourtheme[theme];
			var radius = 64;	
			that.buildchart(holder, data, colours, radius);
		});
	},
	addSpaceData: function(holder){
		var remaining = 100;
		$(holder).find('.dataset li').each(function(index) {
			var newAmount = remaining - $(this).find('.value').text();
			var listEl = '<li><span class="key">Remaining</span><span class="value">'+newAmount+'</span></li>';
			$(holder).find('.dataset').append(listEl);				  
		});
	},
	generateData: function(holder){
		var that = this;
		
		var json = new Array();
		
		var keysObj = {};
		var legendsarray = new Array();				
				this.addSpaceData(holder);

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
			.style("fill", function(d) { return color(d.data.name); });
					
		var totalUnits = svg.append("svg:text")
			.attr("class", "units")
			.attr("dy", 10)
			.attr("text-anchor", "middle") // text-align: right
			.text(function(d) {
				return (d3.max(d.legends).population)+"%"; 
			});	
	}
};