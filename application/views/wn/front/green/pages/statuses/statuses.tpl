<div id="show_statuses">
	<div>
		<h3>
			<a href="#">{$languages->latest_statuses}</a>
		</h3>
		<div class="middle_min_height">



			<div id="latest_statuses">
				{foreach from=$statuses item=status}
				<blockquote class="example-obtuse speech_bubble">{$status->status}</blockquote>
				<p>{$languages->by}: {$status->username}</p>
				{foreachelse} {$languages->no_statuses} {/foreach}
			</div>

			<div class="clear"></div>
		</div>
	</div>
</div>
