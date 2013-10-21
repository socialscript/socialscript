<div>
	<ul class="submenu ">

		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('gossip')">{$languages->header_gossip}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('whatshot')">{$languages->header_whatshot}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('fashion')">{$languages->header_fashion}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('movies')">{$languages->header_movies}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('sports')">{$languages->header_sports}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('foods')">{$languages->header_foods}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('travel')">{$languages->header_travel}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('music')">{$languages->header_music}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('cars')">{$languages->header_cars}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('business')">{$languages->header_business}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('finance')">{$languages->header_finance}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('technology')">{$languages->header_technology}</a></li>
		<li class=" ui-widget-header ui-tabs-nav"><a
			onclick="show_extra_sections('video_games')">{$languages->header_video_games}</a></li>
		{if $settings->enable_multiple_languages == 'yes'} {include
		file="$tpl_dir/elements/languages.tpl"} {/if}
		<li class=" ui-widget-header ui-tabs-nav"
			style="margin: 0; padding: 0;">{if $settings->users_can_choose_theme
			== 'yes'} {include file="$tpl_dir/elements/theme_roller.tpl"} {/if}</li>
	</ul>

</div>
<div class="clear"></div>
<div id="tabs">
	<nav>
		<ul>
			<!-- <li><div class="wn" id="wn">&nbsp;</div></li>-->
			<li class=" ui-widget-header ui-tabs-nav"><a onclick="show_home()">{$languages->header_home}</a></li>
			<li class="topmenu"><a href="#tabs-1">{$languages->menu_welcome}</a></li>
			<li class="topmenu"><a href="#tabs-2" onclick="logout()">{$languages->menu_logout}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_extra_sections('news')">{$languages->header_news}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_interaction','show_groups')">{$languages->header_groups}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_all_users')">{$languages->header_all_users}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_search')">{$languages->header_search}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_people_by_country')">{$languages->header_by_country}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_online_people')">{$languages->header_online}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_top_rated_people')">{$languages->header_top_rated}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a onclick="show_groups()">{$languages->header_games}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_content','show_photos')">{$languages->header_photos}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_interaction','show_videos')">{$languages->header_videos}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_interaction','show_music_files')">{$languages->header_music}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_content','show_events')">{$languages->header_events}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users_content','show_blogs')">{$languages->header_blogs}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_trade')">{$languages->header_trade}</a></li>
			<li class=" ui-widget-header ui-tabs-nav"><a
				onclick="show_center('users','show_statuses')">{$languages->header_statuses}</a></li>


		</ul>
	</nav>
	<div id="tabs-1">
		<div>

			<ul class="submenu ">
				<li class=" ui-widget-header ui-tabs-nav"><a
					onclick="show_profile()">{$languages->header_profile}</a></li>
				<li class=" ui-widget-header ui-tabs-nav"><a
					onclick="show_center('users_interaction','messages')">{$languages->header_messages}({$unread_messages})</a></li>
				<li class=" ui-widget-header ui-tabs-nav"><a
					onclick="show_center('users_interaction','friends')">{$languages->header_friends}</a></li>
				<li class=" ui-widget-header ui-tabs-nav"
					onclick="show_center('users_interaction','best_friends')">{$languages->header_best_friends}</li>
				<li class=" ui-widget-header ui-tabs-nav"
					onclick="show_center('users_interaction','family_friends')">{$languages->header_family}</li>

				<li class=" ui-widget-header ui-tabs-nav"><a
					onclick="show_center('users_interaction','show_matches')">
						{$languages->header_matches}</a></li>

			</ul>
			<div class="clear"></div>

			<div id="tabs-2">{$languages->logout_message}</div>
			<div class="clear"></div>
		</div>
		<div id="tabs-2"></div>


	</div>

	<div id="view_profile"></div>