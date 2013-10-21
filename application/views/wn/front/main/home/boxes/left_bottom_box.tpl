
<div id="left_bottom_box"  class="accordion" style="min-height:400px;">
	<!-- <h2 class="box_header   label label-info">{$languages->left_box_whats_happening_lately}</h2>-->
		<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#left_bottom_box" href="#collapseTwoOne">{$languages->latest_videos_title}</a>
			</div>
    <div id="collapseTwoOne" class="accordion-body collapse in">
      <div class="accordion-inner">
		<div class="my_account_min_height">{include
			file="$tpl_dir/pages/video/video_vertical.tpl"}</div>
	</div>
	</div>
	</div>

	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#left_bottom_box" href="#collapseTwoTwo">{$languages->latest_music_title}</a>
		 </div>
    <div id="collapseTwoTwo" class="accordion-body collapse">
      <div class="accordion-inner">
		<div class="my_account_min_height">{include
			file="$tpl_dir/pages/music/music_vertical.tpl"}</div>
	</div>
	</div>
	</div>

	 <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#left_bottom_box" href="#collapseTwoThree">{$languages->latest_pictures_title}</a>
		  </div>
    <div id="collapseTwoThree" class="accordion-body collapse">
      <div class="accordion-inner">
		<div class="my_account_min_height">{include
			file="$tpl_dir/pages/photos/pictures_vertical.tpl"}</div>
	</div>
	</div>
	</div>


	 <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#left_bottom_box" href="#collapseTwoFour">{$languages->latest_blogs_title}</a>
		  </div>
    <div id="collapseTwoFour" class="accordion-body collapse">
      <div class="accordion-inner">
		<div class="my_account_min_height">{foreach from=$blogs item=blog}
<div class="blogs_left label label-info">
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}blog/{$blog->safe_seo_url}/{$blog->id}"
		{else}onclick="show_blog_details('{$blog->id}','{$blog->user_key}')"{/if}>{$blog->title}</a>
	<br />
	<div class="blogs_info ">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$blog->username}"
			{else}onclick="view_profile('{$blog->user_key}')"{/if}{/if}>{$blog->username}</a>
		{$blog->timestamp|date_format:$settings->date_format}
	</div>
</div>

{foreachelse} {$languages->blogs_no_results} {/foreach} {if
isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
</div>
	</div>
	</div>
	</div>
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#left_bottom_box" href="#collapseTwoFive">{$languages->latest_events_title}</a>
		 </div>
    <div id="collapseTwoFive" class="accordion-body collapse">
      <div class="accordion-inner">
		<div class="my_account_min_height">{foreach from=$latest_events item=event}
<div class="events_left  label label-info">
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}event/{$event->safe_seo_url}/{$event->id}"
		{else}onclick="show_event_details('{$event->id}','{$event->user_key}')"{/if}>{$event->title}<br />{$event->location},{$event->event_date}
	</a> <br />
	<div class="events_info ">
		{$languages->by}: <a {if $settings->only_logged_in_users_can_view_profile_info
			==
			'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
			{else}{if
			$no_ajax=='yes'}href="{$settings->site_url}profile/{$event->username}"
			{else}onclick="view_profile('{$event->user_key}')"{/if}{/if}>{$event->username}</a>
		{$event->timestamp|date_format:$settings->date_format}
	</div>
</div>

{foreachelse} {$languages->events_no_results} {/foreach}
<div class="clear"></div>
{if isset($pagination)}
<div class="pagination">{$pagination}</div>
{/if}
</div>
	</div>
	</div>
</div>
	 <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#left_bottom_box" href="#collapseTwoSix">{$languages->latest_groups_title}</a>
		</div>
    <div id="collapseTwoSix" class="accordion-body collapse">
      <div class="accordion-inner">
		<div class="my_account_min_height">{include
			file="$tpl_dir/pages/groups/groups.tpl"}</div>
	</div>
	</div>
	</div>
	</div>






</div>


