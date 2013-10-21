<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
<body>
	<div class="box">
		<div
			style="height: 18px; background: #3297DE; font-size: 12px; font-weight: bold; color: #FFF; font-family: 'Arial';">Google
			Analytics statistics {$last_month}</div>
		<div class="box-content">
			<div id="chart"></div>
		</div>
	</div>


	{literal}
	<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
	   var data = new google.visualization.DataTable();
  data.addColumn('string', 'Day');
  data.addColumn('number', 'Pageviews');
  data.addRows([{/literal}{foreach from=$results item=result}["{$result->date}", {$result->getPageviews()}],{/foreach}{literal}]);
 var chart = new google.visualization.AreaChart(document.getElementById('chart'));
  chart.draw(data, {width: 914, height: 160, title: '',
    colors:['#058dc7','#e6f4fa'],
    areaOpacity: 0.1,
    hAxis: {textPosition: 'in', showTextEvery: 5, slantedText: false, textStyle: { color: '#058dc7', fontSize: 10 } },
    pointSize: 5,
    legend: 'none',
    chartArea:{left:0,top:30,width:"100%",height:"100%"}
  });
} // End of drawChart()
</script>
	{/literal}
</body>
</html>