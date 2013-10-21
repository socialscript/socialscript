<div id="show_online_people">
				<h3>
					<a href="#">{$languages->online_users}</a>
				</h3>
				<div class="middle_min_height">

{foreach from=$users item=profile}
				{include file="$tpl_dir/home/boxes/profile_box.tpl"}
				{foreachelse}
				{$languages->no_results}
				{/foreach}

<br />

				</div>
</div>