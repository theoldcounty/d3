<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="js/libs/d3.v3.min.js"></script>


		<script src="js/core.js"></script>
		<script src="js/doughnut.common.js"></script>
		<script src="js/doughnut.percentage.js"></script>
		<script src="js/doughnut.readonly.js"></script>


	</head>

	<body>


			<h5>Asset categorisation</h5>
			<div class="doughnut_pie common" data-doughnut-pie-common="true" data-theme="pecking" data-chart-title="">
				<ul class="dataset">
					<li>
						<span class="key">Growth</span>
						<span class="varbox"><input name="growth" type="text" value="50" data-initial-value="50"></span>
						<span class="percentage">%</span>
					</li>
					<li>
						<span class="key">Matching</span>
						<span class="varbox"><input name="matching" type="text" value="30" data-initial-value="30"></span>
						<span class="percentage">%</span>
					</li>
					<li>
						<span class="key">Other</span>
						<span class="varbox"><input name="other" type="text" value="20" data-initial-value="20"></span>
						<span class="percentage">%</span>
					</li>
				</ul>
				<div class="errorhandler rougeredcolor">
					<div class="errorbox"></div>
				</div>
			</div>




			<h4>Asset breakdown</h4>
			<div class="doughnut_pie" data-doughnut-pie-read="true" data-theme="brown" data-chart-title="2800m">
				<ul class="dataset">
					<li>
						<span class="key">Other</span>
						<span class="value">30</span>
					</li>
					<li>
						<span class="key">Matching</span>
						<span class="value">70</span>
					</li>
					<li>
						<span class="key">Growth</span>
						<span class="value">30</span>
					</li>
				</ul>
			</div>



			<div class="doughnut_pie" data-doughnut-pie-percentage="true" data-theme="orange">
				<ul class="dataset">
					<li>
						<span class="key">Others</span>
						<span class="value">40</span>
					</li>
				</ul>
			</div>

	</body>
</html>
