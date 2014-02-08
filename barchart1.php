
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>D3 Time Scale with Axis Component - jsFiddle demo by robdodson</title>

  <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js'></script>
  <link rel="stylesheet" type="text/css" href="/css/normalize.css">


  <link rel="stylesheet" type="text/css" href="/css/result-light.css">



      <script type='text/javascript' src="http://d3js.org/d3.v2.js"></script>




      <script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.3.3/underscore-min.js"></script>


  <style type='text/css'>
      .chart {
    font-family: Arial, sans-serif;
    font-size: 10px;
  }

  .axis path, .axis line {
    fill: none;
    stroke: #000;
    shape-rendering: crispEdges;
  }

  .bar {
    fill: steelblue;
  }
  </style>



<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
var data = [
	{"date":"2012-03-20","total":3},
	{"date":"2012-02-21","total":8},
	{"date":"2012-03-22","total":2},
	{"date":"2012-04-23","total":10},
	{"date":"2012-03-24","total":3},
	{"date":"2012-03-25","total":20},
	{"date":"2012-04-03","total":12}
	];

var margin = {top: 40, right: 40, bottom: 40, left:40},
    width = 600,
    height = 500;

var x = d3.time.scale()
    .domain([new Date(data[0].date), d3.time.day.offset(new Date(data[data.length - 1].date), 1)])
    .rangeRound([0, width - margin.left - margin.right]);

var y = d3.scale.linear()
    .domain([0, d3.max(data, function(d) { return d.total; })])
    .range([height - margin.top - margin.bottom, 0]);

console.log("d3.time", d3.time);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient('bottom')
	//.ticks("1-week",1)
	.ticks(d3.time.weeks, 1)
    .tickFormat(d3.time.format('%a %d'))
    .tickSize(0)
    .tickPadding(8);

var yAxis = d3.svg.axis()
    .scale(y)
    .orient('left')
    .tickPadding(8);

var svg = d3.select('body').append('svg')
    .attr('class', 'chart')
    .attr('width', width)
    .attr('height', height)
  .append('g')
    .attr('transform', 'translate(' + margin.left + ', ' + margin.top + ')');

svg.selectAll('.chart')
    .data(data)
  .enter().append('rect')
    .attr('class', 'bar')
    .attr('x', function(d) { return x(new Date(d.date)); })
    .attr('y', function(d) { return height - margin.top - margin.bottom - (height - margin.top - margin.bottom - y(d.total)) })
    .attr('width', 10)
    .attr('height', function(d) { return height - margin.top - margin.bottom - y(d.total) });

svg.append('g')
    .attr('class', 'x axis')
    .attr('transform', 'translate(0, ' + (height - margin.top - margin.bottom) + ')')
    .call(xAxis);

svg.append('g')
  .attr('class', 'y axis')
  .call(yAxis);
});//]]>

</script>


</head>
<body>


</body>


</html>

