
<div id="profile">


	<h3>
		<a href="#">{$user->username}</a>
	</h3>
	<div class="middle_min_height">
		<div class="profile_pic floatleft ">
			{$user_pic} <br />

			<div id="button1" class="button">
				<a onclick="change_profile_picture()">{$languages->change_profile_picture}</a>
			</div>
			<div id="change_profile_picture" class="hidden">
				<iframe
					src="index.php?route=users_content&action=upload_profile_picture"
					frameborder="0" width="250" height="150" scrolling="no"></iframe>
			</div>
		</div>
		<div class="floatleft">
			{$user->email} <br /> {$user->country} <br /> {$user->rating} <br />
			{$user->registered_date}
		</div>

		<div class="clear"></div>
		<br /> <br /> <br /> <br />
		<h2 class="box_header  ui-widget-header">

			<div class="floatleft">
				<a onclick="manage_pictures()" class="profile_manage_links">{$languages->manage_pictures}</a>
				|
			</div>
			<div class="floatleft">
				<a onclick="manage_videos()" class="profile_manage_links">{$languages->manage_videos}</a>
				|
			</div>
			<div class="floatleft">
				<a onclick="manage_music()" class="profile_manage_links">{$languages->manage_music}</a>
				|
			</div>
			<div class="floatleft">
				<a onclick="manage_blogs()" class="profile_manage_links">{$languages->manage_blogs}</a>
				|
			</div>

			<div class="floatleft">
				<a onclick="manage_events()" class="profile_manage_links">{$languages->manage_events}</a>
				|
			</div>
			<div class="floatleft">
				<a onclick="manage_groups()" class="profile_manage_links">{$languages->manage_groups}</a>
			</div>
			<div class="clear"></div>


		</h2>
	</div>
</div>


{literal}
<script type="text/javascript">



</script>
{/literal}

<div id="extra_fields">
	<h3>
		<a href="#">About you</a>
	</h3>
	<div class="middle_min_height">
		<div id="add_new_extra_sections">
			<input type="button" class="ui-widget-header  input"
				onclick="edit_profile()" value="Edit Profile">
		</div>
		<div class="clear"></div>
		<div id="edit_profile"></div>
		<div>
			{foreach from=$extra_fields item=extra_field}
			<div class="profile_fields_left">{$extra_field->name}:</div>
			<div class="profile_fields_right">{$extra_field->value}</div>
			<div class="clear"></div>
			{foreachelse} You have no extra fields {/foreach}
		</div>
	</div>
</div>

