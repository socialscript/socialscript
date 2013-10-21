{literal}
<style type="text/css">
        .lavaLampWithImage {
            position: relative;
            height: 21px;
          	background: url("resources/images/first-bar.png") repeat-x;
            overflow: hidden;
                    text-align: center;
        }
                .lavaLampWithImage li {
                    float: left;
                    list-style: none;
                    text-align: center;
                }
                    .lavaLampWithImage li.back {
                        background: url("resources/images/lava.png") no-repeat right -30px;
                        width: 9px; height: 18px;
                        z-index: 8;
                    text-align: center;
                        position: absolute;
                    }
                        .lavaLampWithImage li.back .left {
                            background: url("resources/images/lava.png") no-repeat top left;
                            height: 18px;
                    text-align: center;
                            margin-right: 9px; /* 7px is the width of the rounded shape */
                        }
                    .lavaLampWithImage li a {
                        line-height:14px;
						 color:#eee;
						 text-align:center;
						 font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif; 
						 font-size: 10px;
                        text-decoration: none;
                        outline: none;
                        top: 3px;
                        text-transform: uppercase;
                        letter-spacing: 0;
                        z-index: 10;
                        display: block;
                        float: left;
                        height: 21px;
                        position: relative;
                        overflow: hidden;
                        margin: auto 20px;    
                    }
                        .lavaLampWithImage li a:hover, .lavaLampWithImage li a:active, .lavaLampWithImage li a:visited {
                            border: none;
                        }
                       
                        
 
.lavaLampWithImage2 {
            position: relative;
	 background: url(resources/images/second-bar.png) repeat-x; 
	 height: 58px; 
            overflow: hidden;
                    text-align: center;
        }
                .lavaLampWithImage2 li {
                    float: left;
                    list-style: none;
                    text-align: center;
                }
                    .lavaLampWithImage2 li.back {
                        background: url("resources/images/lavawide.png") no-repeat right -58px;
                        width: 9px; height: 58px;
                        z-index: 8;
                    	text-align: center;
                        position: absolute;
                    }
                        .lavaLampWithImage2 li.back .left {
                            background: url("resources/images/lavawide.png") no-repeat top left;
                            height: 58px;
                    		text-align: center;
                            margin-right: 9px; /* 7px is the width of the rounded shape */
                        }
                    .lavaLampWithImage2 li a {
                        line-height:14px;
						 color:#eee;
						 text-align:center;
						 font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif; 
						 font-size: 10px;
                        text-decoration: none;
                        outline: none;
                        top: 3px;
                        text-transform: uppercase;
                        letter-spacing: 0;
                        z-index: 10;
                        display: block;
                        float: left;
                        height: 58px;
                        position: relative;
                        overflow: hidden;
                        margin: auto 20px;    
                    }
                        .lavaLampWithImage2 li a:hover, .lavaLampWithImage2 li a:active, .lavaLampWithImage2 li a:visited {
                            border: none;
                        }
                        
                        
                        
                        
.lavaLampWithImage3 {
            position: relative;
            background: url(resources/images/first-bar.png) repeat-x; 
	 height: 21px; 
            overflow: hidden;
                    text-align: center;
        }
                .lavaLampWithImage3 li {
                    float: left;
                    list-style: none;
                    text-align: center;
                }
                    .lavaLampWithImage3 li.back {
                        background: url("resources/images/lava.png") no-repeat right -30px;
                        width: 9px; height: 18px;
                        z-index: 8;
                    	text-align: center;
                        position: absolute;
                    }
                        .lavaLampWithImage3 li.back .left {
                            background: url("resources/images/lava.png") no-repeat top left;
                            height: 18px;
                    		text-align: center;
                            margin-right: 9px; /* 7px is the width of the rounded shape */
                        }
                    .lavaLampWithImage3 li a {
                        line-height:14px;
						 color:#eee;
						 text-align:center;
						 font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif; 
						 font-size: 10px;
                        text-decoration: none;
                        outline: none;
                        top: 3px;
                        text-transform: uppercase;
                        letter-spacing: 0;
                        z-index: 10;
                        display: block;
                        float: left;
                        height: 21px;
                        position: relative;
                        overflow: hidden;
                        margin: auto 20px;    
                    }
                        .lavaLampWithImage3 li a:hover, .lavaLampWithImage3 li a:active, .lavaLampWithImage3 li a:visited {
                            border: none;
                        }
</style>
 <script type="text/javascript" src="resources/js/jquery.easing.min.js"></script>
    <script type="text/javascript" src="resources/js/jquery.lavalamp.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#1, #2, #3").lavaLamp({
                fx: "backout",
                speed: 700,
                click: function(event, menuItem) {
                    return false;
                }
            });
        });
    </script>
{/literal}
<div id='new-header'>
	<div>
	<ul class="lavaLampWithImage" id="1"><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/gossip"
		{else}onclick="show_extra_sections('gossip')"{/if}>{$languages->header_gossip}</a></li><li>
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/whatshot"
		{else}
			onclick="show_extra_sections('whatshot')"{/if}>{$languages->header_whatshot}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/fashion"
		{else}
			onclick="show_extra_sections('fashion')"{/if}>{$languages->header_fashion}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/movies"
		{else}
			onclick="show_extra_sections('movies')"{/if}>{$languages->header_movies}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/sports"
		{else}
			onclick="show_extra_sections('sports')"{/if}>{$languages->header_sports}</a></li><li>
	<a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/sports"
		{else}
			onclick="show_extra_sections('foods')"{/if}>{$languages->header_foods}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/travel"
		{else}
			onclick="show_extra_sections('travel')"{/if}>{$languages->header_travel}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/music"
		{else}
			onclick="show_extra_sections('music')"{/if}>{$languages->header_music}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/cars"
		{else}
			onclick="show_extra_sections('cars')"{/if}>{$languages->header_cars}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/business"
		{else}
			onclick="show_extra_sections('business')"{/if}>{$languages->header_business}</a></li><li><a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/finance"
		{else}
			onclick="show_extra_sections('finance')"{/if}>{$languages->header_finance}</a></li><li><a {if $no_ajax==
		'yes'}href="peopletalk/technology"
		{else}
			onclick="show_extra_sections('technology')"{/if}>{$languages->header_technology}</a></li><li>
	<!--<a {if $no_ajax==
		'yes'}href="{$settings->site_url}peopletalk/video_games"
		{else}
			onclick="show_extra_sections('video_games')"{/if}>{$languages->header_video_games}</a></li>--><li>
	{if $settings->enable_multiple_languages == 'yes'} {include
	file="$tpl_dir/elements/languages.tpl"} {/if}</li>
	<!--
	{if $settings->users_can_choose_theme
		== 'yes'} {include file="$tpl_dir/elements/theme_roller.tpl"} {/if}--></ul>

	</div>
<div>		
		<ul class="lavaLampWithImage2" id='2'>
			<li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}home" rel="{$settings->site_url}home"
				{else}
				onclick="show_home()"{/if}><img src='resources/images/icon-home.png' /><br/>{$languages->header_home}</a>
			
			</li><li><a href="#tabs-1"><img src='resources/images/icon-welcome.png' /><br/>{$languages->menu_welcome}</a>
			</li><li><a href="#tabs-2" onclick="logout()"><img src='resources/images/icon-logout.png' /><br/>{$languages->menu_logout}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}peopletalk/news" rel="{$settings->site_url}peopletalk/news"
				{else}onclick="show_extra_sections('news')"{/if}><img src='resources/images/icon-news.png' /><br/>{$languages->header_news}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}groups" rel="{$settings->site_url}groups"
				{else}
				onclick="show_center('users_interaction','show_groups')"{/if}><img src='resources/images/icon-groups.png' /><br/>{$languages->header_groups}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}all_users" rel="{$settings->site_url}all_users"
				{else}
				onclick="show_center('users','show_all_users')"{/if}><img src='resources/images/icon-all-users.png' /><br/>{$languages->header_all_users}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}search" rel="{$settings->site_url}search"
				{else}
				onclick="show_center('users','show_search')"{/if}><span><img src='resources/images/icon-search.png' /><br/>{$languages->header_search}</span></a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}users_by_country" rel="{$settings->site_url}users_by_country"
				{else}
				onclick="show_center('users','show_people_by_country')"{/if}><img src='resources/images/icon-by-country.png' /><br/>{$languages->header_by_country}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}online_users" rel="{$settings->site_url}online_users"
				{else}
				onclick="show_center('users','show_online_people')"{/if}><img src='resources/images/icon-online.png' /><br/>{$languages->header_online}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}top_rated_users" rel="{$settings->site_url}top_rated_users"
				{else}
				onclick="show_center('users','show_top_rated_people')"{/if}><img src='resources/images/icon-top-rated.png' /><br/>{$languages->header_top_rated}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}photos" rel="{$settings->site_url}photos"
				{else}
				onclick="show_center('users_content','show_photos')"{/if}><img src='resources/images/icon-photos.png' /><br/>{$languages->header_photos}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}videos" rel="{$settings->site_url}videos"
				{else}
				onclick="show_center('users_interaction','show_videos')"{/if}><img src='resources/images/icon-videos.png' /><br/>{$languages->header_videos}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}music" rel="{$settings->site_url}music"
				{else}
				onclick="show_center('users_interaction','show_music_files')"{/if}><img src='resources/images/icon-music.png' /><br/>{$languages->header_music}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}events" rel="{$settings->site_url}events"
				{else}
				onclick="show_center('users_content','show_events')"{/if}><img src='resources/images/icon-events.png' /><br/>{$languages->header_events}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}blogs" rel="{$settings->site_url}blogs"
				{else}
				onclick="show_center('users_content','show_blogs')"{/if}><img src='resources/images/icon-blogs.png' /><br/>{$languages->header_blogs}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}trade" rel="{$settings->site_url}trade"
				{else}
				onclick="show_center('users','show_trade')"{/if}><img src='resources/images/icon-trade.png' /><br/>{$languages->header_trade}</a>
			</li><li><a {if $no_ajax==
				'yes'}href="{$settings->site_url}statuses" rel="{$settings->site_url}statuses"
				{else}
				onclick="show_center('users','show_statuses')"{/if}><img src='resources/images/icon-statuses.png' /><br/>{$languages->header_statuses}</a>
			</li><li><a onclick="start_webcam()"><img src='resources/images/icon-webcam.png' /><br/>{$languages->webcam}</a></li></ul>
	</div>


	<div id="tabs-1" class="new-login-bar-member">
	<ul class="lavaLampWithImage3" id='3'>
			<li><a 
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users&action=profile&rh={$request_hash}"{else}
					onclick="show_profile()"{/if}>{$languages->header_profile}</a>
			</li><li><a 
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=messages&rh={$request_hash}"{else}
					onclick="show_center('users_interaction','messages')"{/if}
					>{$languages->header_messages}({$unread_messages})</a>
			</li><li><a 
				{if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=friends&rh={$request_hash}"{else}
					onclick="show_center('users_interaction','friends')"{/if}
					>{$languages->header_friends}</a>
			</li><li>	<a {if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=best_friends&rh={$request_hash}"{else}
					onclick="show_center('users_interaction','best_friends')"{/if}
				>{$languages->header_best_friends}</a>
			</li><li>	<a {if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=family_friends&rh={$request_hash}"{else}
					onclick="show_center('users_interaction','family_friends')"{/if}>{$languages->header_family}</a>
			</li><li>	<a {if $no_ajax==
				'yes'}href="{$settings->site_url}index.php?route=users_interaction&action=show_matches&rh={$request_hash}"{else}
					onclick="show_center('users_interaction','show_matches')"{/if}> {$languages->header_matches}</a>
				</li><li>	<a onclick="manage_pictures()">{$languages->manage_pictures}</a>
				</li><li>	<a onclick="manage_videos()">{$languages->manage_videos}</a>
				</li><li>	<a onclick="manage_music()">{$languages->manage_music}</a>
				</li><li>	<a onclick="manage_blogs()">{$languages->manage_blogs}</a>
				</li><li>	<a onclick="manage_events()">{$languages->manage_events}</a>
				</li><li>	<a onclick="manage_groups()">{$languages->manage_groups}</a></li></ul>
	</div>
	
</div>
	<div id="view_profile"></div>