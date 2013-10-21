<div>
	<h2 class="box_header   label label-info">{$languages->left_box_whats_happening_lately}</h2>
	<div id="left_bottom_box">
		<div>
			<h3>
				<a href="#">{$languages->latest_blogs_title}</a>
			</h3>
			<div>
				{foreach from=$latest_blogs item=blog}
				<div class="blogs_left label label-info">
					<a onclick="show_blog_details('{$blog->id}','{$blog->user_key}')">{$blog->title}</a>
					{$blog->username} <br />
					<div class="blogs_info ">
						By: <a onclick="view_profile('{$blog->user_key}')">{$blog->username}</a>
						{$blog->timestamp|date_format:$settings->date_format}
					</div>
				</div>
				{foreachelse} {$languages->blogs_no_results} {/foreach}
			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->latest_events_title}</a>
			</h3>
			<div>
				{foreach from=$latest_events item=event}
				<div class="events_left label label-info">
					<a
						onclick="show_event_details('{$event->id}','{$event->user_key}')">{$event->title}<br />{$event->location},{$event->event_date}
					</a> <br />
					<div class="events_info ">
						By: <a onclick="view_profile('{$event->user_key}')">{$event->username}</a>
						{$event->timestamp|date_format:$settings->date_format}
					</div>
				</div>
				{foreachelse} {$languages->events_no_results} {/foreach}
			</div>
		</div>
		<div>
			<h3>
				<a href="#">{$languages->latest_groups_title}</a>
			</h3>
			<div>
				{foreach from=$latest_groups item=group}
				<div class="group   label label-info">
					<a onclick="group_details('{$group->id}','{$group->user_key}')">{$group->group_name}</a>,{$group->group_location}
					<br />
					<div class="comment_info ">
						{$languages->creator}: <a
							onclick="view_profile('{$group->user_key}')">{$group->username}</a>
						{$group->timestamp|date_format:$settings->date_format}
					</div>
				</div>
				{foreachelse} {$languages->groups_no_results} {/foreach}
			</div>
		</div>
		<!--
	<div>
		<h3>
			<a href="#">{$languages->latest_pictures_title}</a>
		</h3>
		<div></div>
	</div>
	-->
	</div>
</div>

