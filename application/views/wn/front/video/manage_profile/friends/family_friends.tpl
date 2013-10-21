<div id="family_friends">


				<h3>
					<a href="#">{$languages->family}</a>
				</h3>
				<div class="middle_min_height">
				{assign var="family_friends_page" value="1"}
				{foreach from=$family_friends item=profile}
				{include file="$tpl_dir/manage_profile/friends/profile_box.tpl"}
				{foreachelse}
				{$languages->no_results}
				{/foreach}

				</div>


</div>