
<div class="box">
	<div class="box-header">Latest Visits(Provided By Google Analytics)</div>
	<div class="box-content">
		<table class="imagetable">

			<tr>
				<th>Visits</th>
				<th>Source</th>
				<th>Browser</th>
				<th>OS</th>
				<th>Country</th>
				<!-- <th>City</th><th>New Visits</th><th>Avg Time</th>-->
			</tr>
			{foreach from=$results item=result}
			<tr>
				<td>{$result->getvisitCount()}</td>
				<td>{$result->getsource()}</td>
				<td>{$result->getbrowser()}</td>
				<td>{$result->getoperatingSystem()}</td>
				<td>{$result->getcountry()}</td>
				<!--<td>{$result->getcity()}</td>
	  <td>{$result->getnewVisits()}</td><td>{$result->getavgTimeOnPage()|number_format:2}</td>-->
			</tr>
			{/foreach}
		</table>
	</div>
</div>