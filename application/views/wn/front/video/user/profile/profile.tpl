
<div class="left_profile_page">
	<h3>
		<a href="#">{$user_profile->username}</a>
	</h3>
	<div>
		<div id="profile_pic" class="floatleft">{$user_pic}</div>
		<div class="floatleft">
		<div class="profile_i">
			<a onclick="user_interaction('{$user_profile->user_key}','add_friend')">{$languages->add_friend}</a>
		</div>
		<div class="profile_i">
			<a onclick="user_interaction('{$user_profile->user_key}','say_hello')">{$languages->say_hello}</a>
		</div>
		<div class="profile_i">
			<a onclick="user_interaction('{$user_profile->user_key}','ask_question')">{$languages->ask_question}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="user_interaction('{$user_profile->user_key}','mark_interested_in')">{$languages->mark_interested_in}</a>
		</div>
		<div class="profile_i">
			<a onclick="invite_to_event('{$user_profile->user_key}')">{$languages->invite_to_event}</a>
		</div>
		<div class="clear"></div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_pictures','{$user_profile->user_key}','Pictures')">{$languages->view_pictures}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_videos','{$user_profile->user_key}','Videos')">{$languages->view_videos}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_blogs','{$user_profile->user_key}','Blogs')">{$languages->view_blogs}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_events','{$user_profile->user_key}','Events')">{$languages->view_events}</a>
		</div>
		<div class="profile_i">
			<a
				onclick="view_user_section('users_content','view_groups','{$user_profile->user_key}','Groups')">{$languages->view_groups}</a>
		</div>
		<div class="profile_i">
			<a onclick="send_message('{$user_profile->user_key}')">{$languages->send_message}</a>
		</div>
</div>
<div class="clear"></div>
		<div>
			{foreach from=$extra_fields item=extra_field}
			<div class="profile_fields_left">{$extra_field->name}:</div>
			<div class="profile_fields_right">{$extra_field->value}</div>
			<div class="clear"></div>
			{/foreach}
		</div>
	</div>
</div>
<div class="right_profile_page">

	<div style="width: 48%; float: left;">
		<div id="profile_pictures">
			<ul>
				<li><a href="#right-1">{$languages->latest_pictures_title}</a></li>
				<li><a href="#right-2">{$languages->pictures_subscribers}</a></li>
			</ul>
			<div id="right-1">
				{foreach from=$pictures item=picture} <a
					onclick="show_picture_profile_details('{$picture.id}','{$picture.gallery_id}','{$picture.gallery_name}','{$picture.user_key}','{$picture.pic_name}')">{$picture.image}</a>
				{foreachelse} {$languages->no_results} {/foreach}



			</div>
			<div id="right-2">
				<a onclick="subscribe_to_pictures('{$user_profile->user_key}')">{$languages->subscribe}</a><br />
				{foreach from=$pictures_subscribers item=subscriber}
				{$subscriber.user}, {foreachelse} {$languages->no_subscribers}
				{/foreach}
			</div>
		</div>
	</div>
	<div class="separator">&nbsp;</div>
	<div style="width: 48%; float: left;">
		<div id="profile_groups">
			<ul>
				<li><a href="#right-1">{$languages->latest_groups_created}</a></li>
				<li><a href="#right-2">{$languages->subscribers}</a></li>
			</ul>
			<div id="right-1">
				{foreach from=$groups item=group} <a
					{if $settings->only_logged_in_users_can_view_group_info == 'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
{else}{if $no_ajax=='yes'}href="{$settings->site_url}group/{$group->group_name}"
				{else}onclick="group_details('{$group->id}','{$group->user_key}')"{/if}{/if}>{$group->group_name}</a>,{$group->group_location}
				<a onclick="join_group('{$group->id}','{$group->user_key}')">Join</a><br />
				{foreachelse} {$languages->groups_no_results} {/foreach}
			</div>
			<div id="right-2">
				<a onclick="subscribe_to_groups('{$user_profile->user_key}')">{$languages->subscribe_to_groups}</a><br />

				{foreach from=$group_subscribers item=subscriber}
				{$subscriber.user}, {foreachelse} {$languages->no_subscribers}
				{/foreach}
			</div>
		</div>
	</div>
	<div class="right_profile_separator"></div>
	<div style="width: 48%; float: left;">
		<div id="profile_blogs">
			<ul>
				<li><a href="#right-1">{$languages->latest_blogs_title}</a></li>
				<li><a href="#right-2">{$languages->subscribers}</a></li>
			</ul>
			<div id="right-1">
				{foreach from=$blogs item=blog} <a
					onclick="show_blog_profile_details('{$blog->id}','{$blog->user_key}')"
				>{$blog->title}</a><br />
				{foreachelse} {$languages->blogs_no_results} {/foreach}
			</div>
			<div id="right-2">
				<a onclick="subscribe_to_blog('{$user_profile->user_key}')">{$languages->subscribe_to_blog}</a><br />
				{foreach from=$blog_subscribers item=subscriber} {$subscriber.user},
				{foreachelse} {$languages->no_subscribers} {/foreach}
			</div>
		</div>
	</div>
	<div class="separator">&nbsp;</div>
	<div style="width: 48%; float: left;">
		<div id="profile_events">
			<ul>
				<li><a href="#right-1">{$languages->latest_events_title}</a></li>
				<li><a href="#right-2">{$languages->subscribers}</a></li>
			</ul>
			<div id="right-1">
				{foreach from=$events item=event} <a
					onclick="show_event_profile_details('{$event->id}','{$event->user_key}')">{$event->title}</a><br />
				{foreachelse} {$languages->events_no_results} {/foreach}
			</div>
			<div id="right-2">
				<a onclick="subscribe_to_events('{$user_profile->user_key}')">{$languages->subscribe_to_events}</a><br />
				{$languages->subscribers}: {foreach from=$events_subscribers
				item=subscriber} {$subscriber.user}, {foreachelse}
				{$languages->no_subscribers} {/foreach}
			</div>
		</div>
	</div>




</div>
{literal}
<script type="text/javascript">
$(".left_profile_page").accordion({
	header : "h3",
	 animated: 'bounceslide',
	 fillSpace: true
});
$("#profile_pictures").tabs({
	selected : 0
});
$("#profile_blogs").tabs({
	selected : 0
});
$("#profile_events").tabs({
	selected : 0
});
$("#profile_groups").tabs({
	selected : 0
});
</script>
{/literal}