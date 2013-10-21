
				<div id="friends">
<div>
				<h3>
					<a href="#">{$languages->friends}</a>
				</h3>
				<div class="middle_min_height">
				{foreach from=$friends item=profile}
				{include file="$tpl_dir/manage_profile/friends/friends_user_box.tpl"}
				{foreachelse}
				{$languages->no_results}
				{/foreach}

				</div>

<div>
				<h3>
					<a href="#">{$languages->new_requests}</a>
				</h3>
				<div class="middle_min_height">
				{assign var="new_requests" value="1"}
				{foreach from=$friends_requests item=profile}
				{include file="$tpl_dir/manage_profile/friends/friends_user_box.tpl"}
				{foreachelse}
				{$languages->no_results}
				{/foreach}

				</div>
</div>

</div>

</div>