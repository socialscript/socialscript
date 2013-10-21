<div class="group_details_left accordion" id="group_details_left" style="min-height:450px;height:450px;max-height:450px;">
<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#group_details_left" href="#collapseUser">{$group->group_name}</a>
	</div>
    <div id="collapseUser" class="accordion-body collapse in" style="min-height:545px;height:545px;max-height:545px;">
      <div class="accordion-inner">
	 
	<div style="min-height:450px;height:450px;max-height:450px;">
		 {$group->group_description} <br /> {$languages->location}: {$group->group_location} <br />
		 <br />
		   <a onclick="join_group('{$group->id}','{$group->user_key}')">{$languages->join}</a>
<br />
<br />
		{$languages->members}: {foreach from=$members item=user} <a
			{if $settings->only_logged_in_users_can_view_profile_info ==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$user->username}"
			{else}onclick="view_profile('{$user->user_key}')"{/if}{/if}>{$user->username}</a>
		{foreachelse} {$languages->no_members} {/foreach}
	</div>
</div>
</div>
</div>
</div>
<div class="group_details_right">

	<div id="tabs_group_details">
		<ul class="nav nav-tabs">

				<li class="active"><a href="#tabs_group_details-1" data-toggle="tab">{$languages->blogs}</a></li>
				<li><a href="#tabs_group_details-2" data-toggle="tab">{$languages->images}</a></li>
				<li ><a href="#tabs_group_details-3" data-toggle="tab">{$languages->videos}</a></li>
				<li ><a href="#tabs_group_details-4" data-toggle="tab">{$languages->music}</a></li>
				<li ><a href="#tabs_group_details-5" data-toggle="tab">{$languages->events}</a></li>
			</ul>
		<div class="tab-content">
		<div id="tabs_group_details-1" class="groups_min_height tab-pane active">{include
			file="$tpl_dir/pages/groups/group_blogs.tpl"}</div>
		<div id="tabs_group_details-2" class="groups_min_height tab-pane">{include
			file="$tpl_dir/pages/groups/group_images.tpl"}</div>
		<div id="tabs_group_details-3" class="groups_min_height tab-pane">{include
			file="$tpl_dir/pages/groups/group_videos.tpl"}</div>
		<div id="tabs_group_details-4" class="groups_min_height tab-pane">{include
			file="$tpl_dir/pages/groups/group_music.tpl"}</div>
		<div id="tabs_group_details-5" class="groups_min_height tab-pane">{include
			file="$tpl_dir/pages/groups/group_events.tpl"}</div>
	</div>
	</div>
</div>


{literal}
<script type="text/javascript">
$("#tabs_group_details").tab('show');
$("#group_details_left").collapse();
</script>
{/literal}
