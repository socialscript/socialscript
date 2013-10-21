<div class="group_details_left ui-widget-header">
<h3>
		<a href="#">{$group->group_name}</a>
	</h3>
<div>
{$group->group_description}
<br />
{$group->group_location}
<br />
{$languages->members}:
{foreach from=$members item=user}
<a {if $settings->only_logged_in_users_can_view_profile_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}profile/{$user->username}"
				{else}onclick="view_profile('{$user->user_key}')"{/if}{/if}>{$user->username}</a>
{foreachelse}
{$languages->no_members}
{/foreach}

</div>
</div>
<div class="group_details_right">

<div id="tabs_group_details">
		<nav>
			<ul>

			 	<li class="topmenu"><a href="#tabs_group_details-1">{$languages->blogs}</a></li>
				<li class="topmenu"><a href="#tabs_group_details-2">{$languages->images}</a></li>
					<li class="topmenu"><a href="#tabs_group_details-3">{$languages->videos}</a></li>
								<li class="topmenu"><a href="#tabs_group_details-4">{$languages->music}</a></li>
				<li class="topmenu"><a href="#tabs_group_details-5">{$languages->events}</a></li>
			</ul>
		</nav>
		<div id="tabs_group_details-1">

{include file="$tpl_dir/pages/groups/group_blogs.tpl"}
		</div>
		<div id="tabs_group_details-2" class="register">
{include file="$tpl_dir/pages/groups/group_images.tpl"}

		</div>
			<div id="tabs_group_details-3" class="register">
{include file="$tpl_dir/pages/groups/group_videos.tpl"}

		</div>
			<div id="tabs_group_details-4" class="register">
{include file="$tpl_dir/pages/groups/group_music.tpl"}

		</div>
		<div id="tabs_group_details-5">
		{include file="$tpl_dir/pages/groups/group_events.tpl"}
			</div>
	</div>
</div>


 {literal}
<script type="text/javascript">
$("#tabs_group_details").tabs();
$(".group_details_left").accordion({
	header : "h3",
	 fillSpace: true
});
</script>
{/literal}