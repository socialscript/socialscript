<div id="best_friends">


				<h3>
					<a href="#">{$languages->best_friends}</a>
				</h3>
				<div class="middle_min_height">
				{assign var="best_friends_page" value="1"}
				{foreach from=$best_friends item=profile}
				{include file="$tpl_dir/manage_profile/friends/friends_user_box.tpl"}
				{foreachelse}
				{$languages->no_results}
				{/foreach}

				</div>

</div>