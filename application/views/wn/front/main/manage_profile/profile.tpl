<div id="profile"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#profile" href="#collapseBlogs">{$user->username}</a>
		</div>
    <div id="collapseBlogs" class="accordion-body collapse in">
      <div class="accordion-inner">
      
	<div class="middle_min_height">
		<div class="profile_pic floatleft ">
			{$user_pic} <br />

			<div id="button1" class="button">
				<a onclick="change_profile_picture()" class="label label-info">{$languages->change_profile_picture}</a>
			</div>
			<div id="change_profile_picture" class="hidden">
				<iframe
					src="index.php?route=users_content&action=upload_profile_picture"
					frameborder="0" width="250" height="150" scrolling="no"></iframe>
			</div>
		</div>
		<div class="floatleft">
			{$user->email} <br /> {$user->country} <br /> <!--{$user->rating} <br />-->
			{$user->gender} <br />
			{$age} {$languages->years}
		</div>

		<div class="clear"></div>
		<br /> <br /> <br /> <br />
		 

			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_pictures()" style="color:#FFFFFF">{$languages->manage_pictures}</a>
				
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_videos()" style="color:#FFFFFF">{$languages->manage_videos}</a>
				
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_music()" style="color:#FFFFFF">{$languages->manage_music}</a>
				
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_blogs()" style="color:#FFFFFF">{$languages->manage_blogs}</a>
				
			</div>

			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_events()" style="color:#FFFFFF">{$languages->manage_events}</a>
				
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_groups()" style="color:#FFFFFF">{$languages->manage_groups}</a> 
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('news')" style="color:#FFFFFF">{$languages->header_news}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('gossip')" style="color:#FFFFFF">{$languages->header_gossip}</a> 
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('whatshot')" style="color:#FFFFFF">{$languages->header_whatshot}</a>  
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('fashion')" style="color:#FFFFFF">{$languages->header_fashion}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('movies')" style="color:#FFFFFF">{$languages->header_movies}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('sports')" style="color:#FFFFFF">{$languages->header_sports}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('foods')" style="color:#FFFFFF">{$languages->header_foods}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('travel')" style="color:#FFFFFF">{$languages->header_travel}</a> 
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('music')" style="color:#FFFFFF">{$languages->header_music}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('cars')" style="color:#FFFFFF">{$languages->header_cars}</a>  
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('business')" style="color:#FFFFFF">{$languages->header_business}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('finance')" style="color:#FFFFFF">{$languages->header_finance}</a>
			</div>
			<div class="floatleft btn btn-info" style="width:135px;margin:2px;">
				<a onclick="manage_extra_sections('technology')" style="color:#FFFFFF">{$languages->header_technology}</a>
			</div>
			<div class="clear"></div>


	</div>
</div>
</div>
</div>


{literal}
<script type="text/javascript">



</script>
{/literal}

<div id="extra_fields"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#extra_fields" href="#collapseExtraFields">{$languages->profile}</a>
		</div>
    <div id="collapseExtraFields" class="accordion-body collapse in">
      <div class="accordion-inner">
       
	<div class="middle_min_height">
		<div id="add_new_extra_sections">
			<input type="button" class="btn btn-info"
				onclick="edit_profile()" value="Edit Profile">
		</div>
		<div class="clear"></div>
		<div id="edit_profile"></div>
		<div>
			{foreach from=$extra_fields item=extra_field}
			{if $extra_field->value != ''}
			<div class="profile_fields_left">{$extra_field->name}:</div>
			<div class="profile_fields_right">{$extra_field->value}</div>
			<div class="clear"></div>
			{/if}
			{foreachelse} You have no extra fields {/foreach}
		</div>
	</div>
</div>
</div>

