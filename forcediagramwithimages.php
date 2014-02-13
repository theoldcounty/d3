
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>D3.js Force layout with colleps node (3)rd demo - jsFiddle demo by waamit14</title>
    
      <script type='text/javascript' src="http://d3js.org/d3.v3.min.js"></script>
    
  
    
      <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css">
    
  
    
      <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css">
    
  
  <style type='text/css'>
    circle.node {
    cursor: pointer;
    stroke: #3182bd;
    stroke-width: 1.5px;
}
path.link {
    fill: none;
    stroke: #666;
    stroke-width: 1.5px;
}
.simpleDiv {
    position: absolute;
    overflow: visible;
}
.simpleDiv .mainDiv {
    overflow: visible;
    width: 100%;
}
.simpleDiv .mainDiv .userImage {
    width: 36px;
    height: 36px;
    border: 2px solid;
    border-radius:30px;
    overflow: hidden;
}
.simpleDiv .mainDiv .docIcon {
    width: 36px;
}
.simpleDiv .mainDiv .content {
    margin-left: 45px;
    margin-top: -30px;
}
#hiddenText {
    visibility: hidden;
    padding: 0;
}
  </style>
  


<script type='text/javascript'>//<![CDATA[ 

var w = 960,
    h = 500,
    node,
    path,
    root, nodes, links;

var force, vis;
var LoadData = true;

function update() {
    if (force) force.stop();
    nodes = flatten(root);
    links = d3.layout.tree().links(nodes);

    force.nodes(nodes)
        .links(links)
        .linkDistance(120)
        .charge(-500)
        .start();

    path = vis.selectAll("path.link");
    path = path.data(force.links());
    path.exit().remove();
    path.enter().append("svg:path")
        .attr("class", "link")
        .attr("marker-end", "url(#end)");
    vis.selectAll(".node .simpleDiv").remove();

    node = vis.selectAll(".node");
    node = node.data(force.nodes());
    node.exit().remove();
    node.enter().append("g")
        .attr("class", "node")
        .on("click", click)
        .call(force.drag);

    node.append("foreignObject")
        .attr("class", "simpleDiv")
        .attr("width", function (d) {
        var f = document.createElement("span");
        f.id = "hiddenText";
        f.style.display = 'hidden';
        f.style.padding = '0px';
        f.innerHTML = d.name;
        document.body.appendChild(f);
        textWidth = f.offsetWidth;
        var f1 = document.getElementById('hiddenText');
        f1.parentNode.removeChild(f1);
        return textWidth + 50;
    })
        .attr("overflow", "visible")
        .attr("height", 50)
        .append("xhtml:div").attr("class", "mainDiv").style("cursor", hoverStyle)
        .html(function (d) {
        var htmlString = "";


        var userImage = "http://t2.gstatic.com/images?q=tbn:ANd9GcT6fN48PEP2-z-JbutdhqfypsYdciYTAZEziHpBJZLAfM6rxqYX";
        if (d.type == 'user') {
            htmlString += "<div class='userImage' style='border-color:" + color(d) + "'><image src='" + userImage + "' width='36' height='36'></image></div>";
            htmlString += "<div class='content' style='color:" + color(d) + ";'>" + d.name + "</div>";
            htmlString += "<div style='clear:both;'></div>";
        } else if (d.type == 'chat') {
            htmlString += "<div class='docIcon'><i class='icon-comment icon-3x'></i></div>";
            htmlString += "<div class='content' style='color:" + color(d) + ";'>" + d.name + "</div>";
            htmlString += "<div style='clear:both;'></div>";
        } else if (d.type == 'message') {
            htmlString += "<div class='docIcon'><i class='icon-file-alt icon-3x'></i></div>";
            htmlString += "<div class='content' style='color:" + color(d) + ";'>" + d.name + "</div>";
            htmlString += "<div style='clear:both;'></div>";
        } else {
            htmlString += "<div class='docIcon'><i class='icon-exclamation icon-3x'></i></div>";
            htmlString += "<div class='content' style='color:" + color(d) + ";'>" + d.name + "</div>";
            htmlString += "<div style='clear:both;'></div>";
        }
        return htmlString;
    });
}

function tick() {
    path.attr("d", function (d) {

        var dx = d.target.x - d.source.x,
            dy = d.target.y - d.source.y,
            dr = Math.sqrt(dx * dx + dy * dy);
        return "M" + d.source.x + "," + d.source.y + "A" + dr + "," + dr + " 0 0,1 " + d.target.x + "," + d.target.y;
    });

    node.attr("transform", function (d) {
        return "translate(" + (d.x - 15) + "," + (d.y - 15) + ")";
    });

}

function color(d) {
    return d._children ? "#3182bd" : d.children ? "#c6dbef" : "#fd8d3c";
}

function hoverStyle(d) {
    return d._children ? "pointer" : d.children ? "pointer" : "default";
}
// Toggle children on click.
function click(d) {
    if (d.children) {
        d._children = d.children;
        d.children = null;
    } else {
        d.children = d._children;
        d._children = null;
    }
    update();
}

var findNode = function (node) {
    for (var i in force.nodes()) {
        if (force.nodes()[i] === node) return true
    };
    return false;
}

    function flatten(root) {
        var nodes = [],
            i = 0;

        function recurse(node) {
            if (node.children) node.children.forEach(recurse);
            if (!node.id) node.id = ++i;
            nodes.push(node);
        }

        recurse(root);
        return nodes;
    }

    function loadImage() {
        if (LoadData) {
            root = {
                "name": "physics",
                    "imageURL": "",
                    "type": "user",
                    "children": [{
                    "name": "DragForce",
                        "imageURL": "",
                        "size": 1082,
                        "type": "user"
                }, {
                    "name": "GravityForce",
                        "imageURL": "",
                        "size": 1336,
                        "type": "user"
                }, {
                    "name": "IForce",
                        "imageURL": "",
                        "size": 319,
                        "type": "user"
                }, {
                    "name": "NBodyForce",
                        "imageURL": "",
                        "size": 10498,
                        "type": "user"
                }, {
                    "name": "Node 1",
                        "imageURL": "",
                        "type": "user",
                        "children": [{
                        "name": "DragForce 1.1",
                            "imageURL": "",
                            "size": 1082,
                            "type": "chat"
                    }, {
                        "name": "DragForce 1.2",
                            "imageURL": "",
                            "size": 1082,
                            "type": "message"
                    }]
                },

                {
                    "name": "Particle",
                        "imageURL": "",
                        "size": 2822,
                        "type": "user"
                }, {
                    "name": "Simulation",
                        "imageURL": "",
                        "size": 9983,
                        "type": "user"
                }, {
                    "name": "Node 2",
                        "imageURL": "",
                        "type": "user",
                        "children": [{
                        "name": "DragForce 2.1",
                            "imageURL": "",
                            "size": 1082,
                            "type": "message"
                    }, {
                        "name": "DragForce 2.2",
                            "imageURL": "",
                            "size": 1082,
                            "type": "message"
                    }]
                },

                {
                    "name": "Spring",
                        "imageURL": "",
                        "size": 2213,
                        "type": "user"
                }, {
                    "name": "SpringForce",
                        "imageURL": "",
                        "size": 1681,
                        "type": "user"
                }, {
                    "name": "Node 3",
                        "imageURL": "",
                        "type": "user",
                        "children": [{
                        "name": "DragForce 2.1",
                            "imageURL": "",
                            "size": 1082,
                            "type": "chat"
                    }, {
                        "name": "DragForce 3.2",
                            "imageURL": "",
                            "size": 1082,
                            "type": "chat"
                    }]
                }]
            };

            force = d3.layout.force()
                .on("tick", tick)
                .size([w, h]);

            vis = d3.select("#chart").append("svg:svg")
                .attr("width", w)
                .attr("height", h);
            update();
            LoadData = false;
        }

    }
//]]>  

</script>


</head>
<body>
  <div id="chart"></div>
<input type="button" name="loadImage" value="Load" onClick="loadImage();" />
  
</body>


</html>

