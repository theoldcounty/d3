/*
*	KPMG
*	doughnut.common.js
*	Space01 Ltd. 2013
* 	author : Rob Lone - info@fusionrobotdesign.com
*/

/*This invokes a doughnutCommon. */

$.Core.doughnutCommon ={    
	colourtheme: {
            "spectrum" :  ["#eddf97","#e87424", "#ebb700", "#007c92", "#333"],
			"pecking" :  ["#ebb700","#e87424", "#00505c", "#007c92", "#6a7f10", "#7ab800", "#8e258d", "#b390bb"],
			"purple" :  ["#da39d9","#8e258d", "#4e144e"]
    },
	init: function(){
        var that = this;

        $('[data-doughnut-pie-common="true"]').each(function(index) {
            that.bindInputEvents($(this));
            var holder = $(this)[0];
            var data = that.generateData(holder);
            var theme = $(this).data("theme");
            var colours = that.colourtheme[theme];
            var radius = 64;    
            that.buildchart(holder, index, data, colours, radius);

			var isReadOnly = $(this).data("read-only");
			if(isReadOnly){
				//console.log("read only");
				that.setReadOnly($(this));
			}
        });
    },
	setReadOnly: function(holder){
		holder.addClass("readonly");
		holder.find(".dataset input").each(function(index) {
			$(this).attr("disabled", "disabled");			
		});
	},
    bindInputEvents: function(holder){
        var that = this;
    
		holder.find('.dataset li input').keyup(function(event) {
			// Allow: backspace, delete, tab, escape, and enter
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else {
				// Ensure that it is a number and stop the keypress
				if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
					event.preventDefault(); 
				}
				else{
					that.validate(holder);
				} 
			}
		});
    },
    generateData: function(holder){
        var that = this;

        var json = new Array();
    
        var keysObj = {};
        var legendsarray = new Array();

                $(holder).find('.dataset li').each(function(index) {
                      var key = $(this).find('.key').text();
                      var value = $(this).find('.varbox input').val();

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
	errorHide: function(holder){
		holder.find(".errorbox").fadeOut(300, function(){
			holder.find(".errorbox").empty();
		})
	},
	errorShow: function(holder, msg){
		holder.find(".errorbox").text(msg);
		holder.find(".errorbox").fadeIn(300);
	},	
	validate: function(holder){
		var that = this;
		
		var total = 0;
		holder.find(".dataset input").each(function(index) {
			var val = $(this).val();
			total += parseInt($(this).val(),10);
		});		

		if(total > 0 && total <= 100){
			that.errorHide(holder);
			this.updatechart(holder);		
		}
		else{
			var error = "";
			if(total <= 0){
				error = "Total needs to be over 0";
			}

			if(total > 100){
				error = "Total can not be over 100%";
			}			
			
			that.errorShow(holder, error);
		}
	},
    updatechart: function(holder){
        var that = this;

        var data = that.generateData(holder);
        var pieId = holder.find(".pie").attr("id");

        var arc_group = d3.select('#'+pieId+' > .sliceholder');

        var color = d3.scale.ordinal();

        var arc = d3.svg.arc()
            .outerRadius(64)
            .innerRadius(64 - 20);      

        var pie = d3.layout.pie()
            .sort(null)
            .value(function(d) { return d.population; });
        paths = arc_group.selectAll("path").data(pie(data[0].legends));

        paths.enter().append("svg:path")
            .attr("class", "arc")
            .attr("d", arc)
            .style("fill", function(d) {
                return color(d.name);
            })
            .transition()
            .duration(500);

        paths
            .transition()
            .duration(500)
            .attrTween("d", arcTween);

        paths.exit()
            .transition()
            .duration(500)
            .remove();

        function arcTween(d) {
          var i = d3.interpolate(this._current, d);
          this._current = i(0);
          return function(t) { return arc(i(t)); };
        }

    },
    buildchart: function(holder, index, data, colours, radius){
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
            .attr("id", "pie"+index)
            .attr("width", radius * 2)
            .attr("height", radius * 2)
            .append("g")
            .attr("class", "sliceholder")
            .attr("transform", "translate(" + radius + "," + radius + ")");

        svg.selectAll(".arc")
            .data(function(d) { return pie(d.legends); })
            .enter().append("path")
            .attr("class", "arc")
            .attr("d", arc)
            .each(function(d) { this._current = d; })
            .style("fill", function(d) { return color(d.data.name); });

        var legend = d3.select(holder).append("svg")
            .attr("class", "legend")
            .attr("width", radius * 1.7)
            .attr("height", radius * 2)
            .selectAll("g")
            .data(color.domain().slice())
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

        var totalUnits = svg.append("svg:text")
            .attr("class", "units")
            .attr("dy", 5)
            .attr("text-anchor", "middle") // text-align: right
            .text($(holder).data("chart-title"));
    }
};