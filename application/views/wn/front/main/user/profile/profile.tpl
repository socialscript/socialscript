
<div id="left_profile_page"  class="accordion left_profile_page"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#left_profile_page" href="#collapseUser">{$user_profile->username}</a>
	</div>
    <div id="collapseUser" class="accordion-body collapse in" style="min-height:545px;height:545px;max-height:545px;">
      <div class="accordion-inner">
		<div id="profile_pic" class="floatleft">{$user_pic}</div>
		<div class="floatleft">
			<div class="profile_i">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-info"
					onclick="user_interaction('{$user_profile->user_key}','add_friend')">{$languages->add_friend}</a> 
			</div>
			<div class="profile_i">
				<a   class="btn btn-info"
					onclick="user_interaction('{$user_profile->user_key}','say_hello')">{$languages->say_hello}</a> 
			</div>
			<!-- 					<div class="profile_i">
				<a
					onclick="ask_question('{$user_profile->user_key}')">{$languages->ask_question}</a>
			</div>
			-->
			<div class="profile_i">
				<a  class="btn btn-info"
					onclick="user_interaction('{$user_profile->user_key}','mark_interested_in')">{$languages->mark_interested_in}</a>
			</div>
			<div class="profile_i">
				<a  class="btn btn-info" onclick="invite_to_event('{$user_profile->user_key}')">{$languages->invite_to_event}</a>
			</div>
			<div class="clear"></div>
			<br />
			<div class="profile_i">
				<a  class="btn btn-info"
					onclick="view_user_section('users_content','view_pictures','{$user_profile->user_key}','Pictures')">{$languages->view_pictures}</a> 
			</div>
			<div class="profile_i">
				<a  class="btn btn-info"
					onclick="view_user_section('users_content','view_videos','{$user_profile->user_key}','Videos')">{$languages->view_videos}</a> 
			</div>
			<div class="profile_i">
				<a  class="btn btn-info"
					onclick="view_user_section('users_content','view_blogs','{$user_profile->user_key}','Blogs')">{$languages->view_blogs}</a> 
			</div>
			<div class="profile_i">
				<a  class="btn btn-info"
					onclick="view_user_section('users_content','view_events','{$user_profile->user_key}','Events')">{$languages->view_events}</a> 
			</div>
			<div class="profile_i">
				<a  class="btn btn-info"
					onclick="view_user_section('users_content','view_groups','{$user_profile->user_key}','Groups')">{$languages->view_groups}</a>
			</div>
			<div class="profile_i">
				<a  class="btn btn-info" onclick="send_message('{$user_profile->user_key}')">{$languages->send_message}</a>
			</div>
				<div class="clear"></div>
		</div>
<div class="clear"></div>
		<div>
		<div class="profile_fields_left">{$user_profile->gender}</div>
		<div class="clear"></div>
		<div class="profile_fields_left">{$age} {$languages->years}</div>
		<div class="clear"></div>
		<br />
			{foreach from=$extra_fields item=extra_field}
			{if $extra_field->value != ''}
			<div class="profile_fields_left">{$extra_field->name}:</div>
			<div class="profile_fields_right" align="absmiddle">{$extra_field->value}</div>
			<div class="clear"></div>
			{/if}
			{/foreach}
		</div>
	</div>
</div>
</div>
</div>
</div>
<div class="right_profile_page">

	<div style="width: 48%; float: left;">
		<div id="profile_pictures">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#right-1" data-toggle="tab">{$languages->latest_pictures_title}</a></li>
				<li><a href="#right-2" data-toggle="tab">{$languages->pictures_subscribers}</a></li>
			</ul>
			<div class="tab-content">
			<div id="right-1" class="tab-pane active">
				{foreach from=$pictures_profile item=picture} <a
					onclick="show_picture_profile_details('{$picture.id}','{$picture.gallery_id}','{$picture.gallery_name}','{$picture.user_key}','{$picture.pic_name}')">{$picture.image}</a>
				{foreachelse} {$languages->no_results} {/foreach}



			</div>
			<div id="right-2" class="tab-pane">
				<a onclick="subscribe_to_pictures('{$user_profile->user_key}')">{$languages->subscribe}</a><br />
				{foreach from=$pictures_subscribers item=subscriber}
				{$subscriber.user}, {foreachelse} {$languages->no_subscribers}
				{/foreach}
			</div>
			</div>
		</div>
	</div>
	<div class="separator">&nbsp;</div>
	<div style="width: 48%; float: left;">
		<div id="profile_groups">
			<ul class="nav nav-tabs">
				<li  class="active"><a href="#right-1-g"  data-toggle="tab">{$languages->latest_groups_created}</a></li>
				<li><a href="#right-2-g"  data-toggle="tab">{$languages->subscribers}</a></li>
			</ul>
			<div class="tab-content">
			<div id="right-1-g" class="tab-pane active">
				{foreach from=$groups_profile item=group}
				<div class="group   label label-info ">
				<a {if $settings->only_logged_in_users_can_view_group_info
					==
					'yes'}onclick="show_user_notification('{$languages->user_not_logged}')"
					{else}{if 
					$no_ajax=='yes'}href="{$settings->site_url}group/{$group->safe_seo_url}/{$group->id}"
					{else}onclick="group_details('{$group->id}','{$group->user_key}')"{/if}{/if}>{$group->group_name}</a>,{$group->group_location}
				<a onclick="join_group('{$group->id}','{$group->user_key}')">Join</a>
				</div>
				{foreachelse} {$languages->groups_no_results} {/foreach}
			</div>
			<div id="right-2-g" class="tab-pane">
				<a onclick="subscribe_to_groups('{$user_profile->user_key}')">{$languages->subscribe_to_groups}</a><br />

				{foreach from=$group_subscribers item=subscriber}
				{$subscriber.user}, {foreachelse} {$languages->no_subscribers}
				{/foreach}
			</div>
		</div>
		</div>
	</div>
	<div class="right_profile_separator"></div>
	<div style="width: 48%; float: left;">
		<div id="profile_blogs">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#right-1-b"  data-toggle="tab">{$languages->latest_blogs_title}</a></li>
				<li><a href="#right-2-b"  data-toggle="tab">{$languages->subscribers}</a></li>
			</ul>
			<div class="tab-content">
			<div id="right-1-b"  class="tab-pane active">
				{foreach from=$blogs_profile item=blog} <div class="group   label label-info "><a
					onclick="show_blog_profile_details('{$blog->id}','{$blog->user_key}')">{$blog->title}</a>
					</div>
				{foreachelse} {$languages->blogs_no_results} {/foreach}
			</div>
			<div id="right-2-b"  class="tab-pane">
				<a onclick="subscribe_to_blog('{$user_profile->user_key}')">{$languages->subscribe_to_blog}</a><br />
				{foreach from=$blog_subscribers item=subscriber} {$subscriber.user},
				{foreachelse} {$languages->no_subscribers} {/foreach}
			</div>
		</div>
	</div>
	</div>
	<div class="separator">&nbsp;</div>
	<div style="width: 48%; float: left;">
		<div id="profile_events">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#right-1-e"  data-toggle="tab">{$languages->latest_events_title}</a></li>
				<li><a href="#right-2-e"  data-toggle="tab">{$languages->subscribers}</a></li>
			</ul>
				<div class="tab-content">
			<div id="right-1-e" class="tab-pane active">
				{foreach from=$events_profile item=event} <div class="group   label label-info "><a
					onclick="show_event_profile_details('{$event->id}','{$event->user_key}')">{$event->title}</a></div>
				{foreachelse} {$languages->events_no_results} {/foreach}
			</div>
			<div id="right-2-e" class="tab-pane">
				<a onclick="subscribe_to_events('{$user_profile->user_key}')">{$languages->subscribe_to_events}</a><br />
				{$languages->subscribers}: {foreach from=$events_subscribers
				item=subscriber} {$subscriber.user}, {foreachelse}
				{$languages->no_subscribers} {/foreach}
			</div>
			</div>
		</div>
	</div>




</div>
{literal}
<script type="text/javascript">
$(".left_profile_page").collapse();
	$("#profile_pictures").tab('show');
					$("#profile_blogs").tab('show');
					$("#profile_events").tab('show');
					$("#profile_groups").tab('show');
</script>
{/literal}
