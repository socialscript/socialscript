<section>
	<div class="floatleft" id="middle">
		<div id="middle_default">

		<div id="middle_videos" >
	<h3>
			<a href="#">{$languages->latest_videos_title}</a>
		</h3>
		<div class="middle_home_min_height">
					{include file="$tpl_dir/pages/video/video.tpl"}
		</div>

	</div>
		<div class="separator_vertical">&nbsp;</div>

		<div id="middle_music">
	<h3>
			<a href="#">{$languages->latest_music_title}</a>
		</h3>
		<div class="middle_home_min_height">
			{include file="$tpl_dir/pages/music/music.tpl"}

		</div>

	</div>
	
	<div class="separator_vertical">&nbsp;</div>
		<div id="middle_pictures" >
	<h3>
			<a href="#">{$languages->latest_pictures_title}</a>
		</h3>
		<div class="middle_home_min_height">
					{include file="$tpl_dir/pages/photos/pictures.tpl"}


		</div>

	</div>
	
	
		<div id="middle_boxes">
					<div>{include file="$tpl_dir/home/boxes/latest_people.tpl"}
</div>
			</div>
<div class="separator_vertical">&nbsp;</div>
		<div id="middle_blogs" >
		<h3>
			<a href="#">{$languages->latest_blogs_title}</a>
		</h3>
		<div class="middle_home_min_height">
			{include file="$tpl_dir/user/blogs/blogs.tpl"}

		</div>


	</div>
	
		
	<div class="separator_vertical">&nbsp;</div>
		<div id="middle_groups" >
	<h3>
			<a href="#">{$languages->latest_groups_title}</a>
		</h3>
		<div class="middle_home_min_height">
					{include file="$tpl_dir/pages/groups/groups.tpl"}


		</div>

	</div>
	
		
	
	
	<div class="separator_vertical">&nbsp;</div>
		<div id="middle_events" >
		<h3>
			<a href="#">{$languages->latest_events_title}</a>
		</h3>
		<div class="middle_home_min_height">
							{include file="$tpl_dir/user/events/events.tpl"}


		</div>


	</div>
	</div>
</div>	
asdasdasdasdasd
	
		
	

</section>

{literal}
<script type="text/javascript">
$("#middle_blogs").accordion({
	header : "h3",
	
	 fillSpace: true

});
$("#middle_events").accordion({
	header : "h3",
	
	 fillSpace: true

});
$("#middle_groups").accordion({
	header : "h3",
	
	 fillSpace: true

});
$("#middle_pictures").accordion({
	header : "h3",
	
	 fillSpace: true

});
$("#middle_videos").accordion({
	header : "h3",
	
	 fillSpace: true

});
$("#middle_music").accordion({
	header : "h3",
	
	 fillSpace: true

});
</script>
{/literal}