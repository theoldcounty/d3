/*
*	core.js
* 	author : Rob Lone - info@fusionrobotdesign.com
*/

$.Core ={
	init: function(){
		$.Core.doughnutReadonly.init();//iniate doughnut read only
		$.Core.doughnutPercentage.init();//iniate doughnut read only
		$.Core.doughnutCommon.init();//iniate doughnut read only

	}
};

$(document).ready(function(){
	$.Core.init();
});
