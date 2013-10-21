
<div class="middle">
	<div id="menu_top">
		<ul class="group" id="menu_group_main">
			<li class="item first"><a
				onclick="create_window_maximized('settings&action=index','Settings');"
				class="main"><span class="outer"><span class="inner settings">Settings</span></span></a></li>
			<li class="item"><a
				onclick="create_window_maximized('users&action=index','Users');"
				class="main"><span class="outer"><span class="inner users">Users</span></span></a></li>
			<li class="item"><a
				onclick="create_window_maximized('users_content&action=videos','Videos');"><span
					class="outer"><span class="inner videos">Videos</span></span></a></li>
			<li class="item"><a
				onclick="create_window_maximized('users_content&action=music','Music');"
				class="main"><span class="outer"><span class="inner music">Music</span></span></a></li>
			<li class="item"><a
				onclick="create_window_maximized('users_content&action=pictures','Pictures');"
				class="main"><span class="outer"><span class="inner photos">Photos</span></span></a></li>
			<li class="item"><a
				onclick="create_window_maximized('users_interaction&action=get_blogs','Blogs');"
				class="main"><span class="outer"><span class="inner blogs">Blogs</span></span></a></li>
			<li class="item"><a
				onclick="logout()"
				class="main"><span class="outer"><span class="inner logout">Logout</span></span></a></li>
			<li class="item last"><a href="#"><span class="outer"><div
							class="ui-widget">{include
							file="$tpl_dir/elements/theme_roller.tpl"}</div>
						<span class="inner_last ">Admin Theme</span></span></a></li>

		</ul>
	</div>
</div>

<div class="clear"></div>
<div class="vertical_separator">&nbsp;</div>
<br />
<div class="middle">
	<div id="analytics_latest"></div>
	<div id="site_stats">
		<div class="box">
			<div class="box-header">Statistics</div>
			<div class="box-content">
				<table class="imagetable">

					<tr>
						<th>Total Users</th>
						<td>{$nr_users}</td>
					</tr>
					<tr>
						<th>Total Females</th>
						<td>{$nr_users_females}</td>
					</tr>
					<tr>
						<th>Total Males</th>
						<td>{$nr_users_males}</td>
					</tr>
					<tr>
						<th>Total Videos</th>
						<td>{$nr_videos}</td>
					</tr>
					<tr>
						<th>Total Music</th>
						<td>{$nr_music}</td>
					</tr>
					<tr>
						<th>Total Pictures</th>
						<td>{$nr_pictures}</td>
					</tr>
					<tr>
						<th>Total Blogs</th>
						<td>{$nr_blogs}</td>
					</tr>
					<tr>
						<th>Total Events</th>
						<td>{$nr_events}</td>
					</tr>
					<tr>
						<th>Total Groups</th>
						<td>{$nr_groups}</td>
					</tr>
				</table>
			</div>
		</div>


	</div>
	<div class="contact_us">
		<div class="box">
			<div class="box-header">Contact Us</div>
			<div class="box-content">

				<table class="imagetable">
					<tr>
						<th colspan="2"></th>
					</tr>
					<tr>
						<th>Your Email</th>
						<td><input type="text" name="email" id="email"></td>


					<tr>
						<th>Message</th>
						<td><input type="text" name="message" id="message" class="contact_textarea"></td>


					<tr>
						<th><input type="button" name="submit" value="Submit"
							id="submit_contact"></th>
						<td id="contact_status"></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="middle" id="analytics2">

		<iframe src="index_admin.php?route=index&action=analytics2"
			width="928" height="200" frameborder="0" scrolling="no"></iframe>
	</div>
	<!--
<div class="middle" id="server_info"></div>
-->
</div>

<div
	style="position: fixed; top: 96.7%; width: 100%; left: 0%; margin: 0; padding: 0">



	<div id="minimized_bottom" class="bottom-bar">
		<div style='width: 12%; float: left'>

			<div class="start" onclick="show_menu()" title="Show Menu"></div>
			<div class="minimize_all" onclick="hide_all_windows();">
				<img
					src="{$settings->resources_url}/resources/images/admin/show-desktop.png"
					style="width: 27px; height: 20px; padding-top: 2px;"
					alt="Show Desktop">
			</div>
			<div class="close_all" onclick="close_all_windows();">
				<img
					src="{$settings->resources_url}/resources/images/admin/close_all.png"
					style="width: 30px; height: 26px;" alt="Close all windows">
			</div>
		</div>
		<div id="minimized_windows">&nbsp;</div>
	</div>
</div>
</div>

<div id="menu" class="hidden">
	<div class="menu">
		<div class="menu-top">Admin</div>
		<div class="menu-main">
			<div class="menu-tab" id="menu_item_5"
				onmouseover="show_submenu('5')" onmouseout="hide_submenu('5')">
				<a>Chat</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_10"
				onmouseover="show_submenu('10')" onmouseout="hide_submenu('10')">
				<a>Trade</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_11"
				onmouseover="show_submenu('11')" onmouseout="hide_submenu('11')">
				<a>Pictures</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_13"
				onmouseover="show_submenu('13')" onmouseout="hide_submenu('13')">
				<a>Videos</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_12"
				onmouseover="show_submenu('12')" onmouseout="hide_submenu('12')">
				<a>Music</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_9"
				onmouseover="show_submenu('9')" onmouseout="hide_submenu('9')">
				<a>Groups</a>
			</div>

			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_8"
				onmouseover="show_submenu('8')" onmouseout="hide_submenu('8')">
				<a>Blogs</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_7"
				onmouseover="show_submenu('7')" onmouseout="hide_submenu('7')">
				<a>Events</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_17"
				onmouseover="show_submenu('17')" onmouseout="hide_submenu('17')">
				<a>Games</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_6"
				onmouseover="show_submenu('6')" onmouseout="hide_submenu('6')">
				<a>Extra Sections</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_4"
				onmouseover="show_submenu('4')" onmouseout="hide_submenu('4')">
				<a>Languages</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_3"
				onmouseover="show_submenu('3')" onmouseout="hide_submenu('3')">
				<a>Users</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_2"
				onmouseover="show_submenu('2')" onmouseout="hide_submenu('2')">
				<a>Forms</a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_1"
				onmouseover="show_submenu('1')" onmouseout="hide_submenu('1')">
				<a>Manage </a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_14"
				onmouseover="show_submenu('16')" onmouseout="hide_submenu('16')">
				<a>Text Pages </a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_14"
				onmouseover="show_submenu('14')" onmouseout="hide_submenu('14')">
				<a>Server </a>
			</div>
			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<div class="menu-tab" id="menu_item_15"
				onmouseover="show_submenu('15')" onmouseout="hide_submenu('15')">
				<a>Google Analytics </a>
			</div>


			<div class="menu-tab-right"></div>
			<div class="clear"></div>
			<div class="menu-separator">&nbsp;</div>
			<a
				onclick="create_window_maximized('settings&action=index','Settings');"><div
					class="menu-tab">Settings</div></a>
			<div class="clear"></div>
		</div>
	</div>
</div>
<div class="submenu hidden" id="submenu_1">
<a
		onclick="create_window_maximized('index&action=admins','Admins');"><div
			class="submenu-tab">Admins</div></a>
	<a
		onclick="create_window_maximized('nr_items_to_display&action=index','Nr. items to display');"><div
			class="submenu-tab">Number of items to display</div></a> <a
		onclick="create_window_maximized('user_content_settings&action=pictures_settings','User Pictures Settings');"><div
			class="submenu-tab">User Pictures Settings</div></a> <a
		onclick="create_window_maximized('user_content_settings&action=videos_settings','User Videos Settings');"><div
			class="submenu-tab">User Videos Settings</div></a> <a
		onclick="create_window_maximized('settings&action=available_countries','Country Availability');"><div
			class="submenu-tab">Country Availability</div></a> <a
		onclick="create_window_maximized('index&action=banners','Banners');"><div
			class="submenu-tab">Banners</div></a>
</div>
<div class="submenu hidden" id="submenu_2">
	<a
		onclick="create_window_maximized('forms&action=register','Register Form');"><div
			class="submenu-tab">Register form</div> <a
		onclick="create_window_maximized('forms&action=user_profile','User Profile Form');"><div
				class="submenu-tab">User Profile form</div></a>

</div>
<div class="submenu hidden" id="submenu_3">
	<a
		onclick="create_window_maximized('users&action=index','Manage Users');"><div
			class="submenu-tab">Manage Users</div></a> <a
		onclick="create_window_maximized('roles&action=index','Manage User Roles');"><div
			class="submenu-tab">Manage User Roles</div></a>
</div>
<a
	onclick="create_window_maximized('languages&action=index','Languages');"><div
		class="submenu hidden" id="submenu_4">
		<div class="submenu-tab">Manage Languages</div></a>
</div>
<a
	onclick="create_window_maximized('chat_rooms&action=index','Chatrooms');"><div
		class="submenu hidden" id="submenu_5">
		<div class="submenu-tab">Chatrooms</div></a>
</div>
<div class="submenu hidden" id="submenu_6">
	<a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=gossip','Gossip');"><div
			class="submenu-tab">Gossip</div></a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=whatshot','Whatshot');"><div
			class="submenu-tab">What's Hot</div></a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=fashion','Fashion');"><div
			class="submenu-tab">Fashion</div></a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=movies','Movies');"><div
			class="submenu-tab">Movies</div></a>

	<div class="submenu-tab">
		<a
			onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=sports','Sports');">Sports</a>
	</div>

	<a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=foods','Foods');"><div
			class="submenu-tab">Foods</div></a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=travel','Travel');"><div
			class="submenu-tab">Travel</div></a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=music','Music');"><div
			class="submenu-tab">Music</div> </a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=cars','Cars');"><div
			class="submenu-tab">Cars</div> </a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=business','Business');"><div
			class="submenu-tab">Business</div></a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=finance','Finance');"><div
			class="submenu-tab">Finance</div> </a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=technology','Technology');"><div
			class="submenu-tab">Technology</div> </a> <a
		onclick="create_window_maximized('users_interaction&action=manage_extra_sections&type=video_games','Video Games');"><div
			class="submenu-tab">Video Games</div></a>
</div>
<div class="submenu hidden" id="submenu_7">
	<a
		onclick="create_window_maximized('users_interaction&action=get_events','Events');"><div
			class="submenu-tab">Events</div></a>
</div>
<div class="submenu hidden" id="submenu_8">
	<a
		onclick="create_window_maximized('users_interaction&action=get_blogs','Blogs');"><div
			class="submenu-tab">Blogs</div></a>
</div>
<div class="submenu hidden" id="submenu_9">
	<a
		onclick="create_window_maximized('users_interaction&action=get_groups','Groups');"><div
			class="submenu-tab">Groups</div></a>
</div>
<div class="submenu hidden" id="submenu_10">
	<a
		onclick="create_window_maximized('users_interaction&action=get_trade','Trade');"><div
			class="submenu-tab">Trade</div></a>
</div>
<div class="submenu hidden" id="submenu_11">
	<a
		onclick="create_window_maximized('users_content&action=pictures','Pictures');"><div
			class="submenu-tab">Pictures</div></a>
</div>
<div class="submenu hidden" id="submenu_12">
	<a
		onclick="create_window_maximized('users_content&action=music','Music');"><div
			class="submenu-tab">Music</div></a>
</div>
<div class="submenu hidden" id="submenu_13">
	<a
		onclick="create_window_maximized('users_content&action=videos','Videos');">
		<div class="submenu-tab">Videos</div>
	</a>
</div>
<div class="submenu hidden" id="submenu_14">
	<a
		onclick="create_window_maximized('index&action=server_info','Server Info');"><div
			class="submenu-tab">Server Info</div> </a> <a
		onclick="create_window_maximized('index&action=phpinf','Php Info');"><div
			class="submenu-tab">Php Info</div> </a>
</div>
<div class="submenu hidden" id="submenu_16">
	<a
		onclick="create_window_maximized('index&action=text_pages','Text Pages');"><div
			class="submenu-tab">Text Pages</div> </a>

</div>
<div class="submenu hidden" id="submenu_15">
	<a
		onclick="create_window_maximized('settings&action=analytics','Google Analytics');"><div
			class="submenu-tab">Google Analytics</div> </a>

</div>
<div class="submenu hidden" id="submenu_17">
	<a
		onclick="create_window_maximized('users_content&action=games','Flash Games');"><div
			class="submenu-tab">Flash Games</div> </a>

</div>

</body>
</html>



{literal}
<script type="text/javascript">

function logout()
{
	 $.ajax({
         type: "POST",
         url: "index_admin.php?route=index&action=logout",
         dataType:"html",
         data:
         {
         },
         dataType:'json',
         success:function(response){
				$.ajax({
					type : "GET",
					url : "index_admin.php?route=index&action=index_inner",
					data : {
					},

					success : function(response) {
						$("#login").html(response);
						$("#content").hide();
						$("#login").fadeIn(2000);
					}
				});




         },
         error:function (xhr, ajaxOptions, thrownError){
             alert(xhr.status);
             alert(thrownError);
         }
     });
}
$('#submit_contact').bind('click', function() {

	$('#submit_contact').attr('disabled', 'disabled');

	 $.ajax({
         type: "POST",
         url: "index_admin.php?route=index&action=contact",
         dataType:"html",
         data:
         {
             'email':$("#email").val(),
             'message':$("#message").val(),
             'r_h':r_h
         },
         dataType:'json',
         success:function(response){
             if(response.status == true)
             {
				$("#contact_status").html('Message sent');
				 $('#submit_contact').removeAttr('disabled');


             }
             else
             {
            	 $("#contact_status").html('Error');
            	 $('#submit_contact').removeAttr('disabled');
             }

         },
         error:function (xhr, ajaxOptions, thrownError){
             alert(xhr.status);
             alert(thrownError);
         }
     });
});

writeCookie();
function writeCookie()
{
var today = new Date();
var the_date = new Date("December 31, 2023");
var the_cookie_date = the_date.toGMTString();
var the_cookie = "users_resolution="+ screen.width + 'x' + screen.height;
var the_cookie = the_cookie + ";expires=" + the_cookie_date;
document.cookie=the_cookie
}
function show_menu()
{
//alert($("#menu").css("z-index"));
	if($("#menu").css("z-index") == '10000')
	{
		$("#menu").hide();
		$("#menu").css('z-index','auto');
	for(i=1;i<20;i++)
	{
		$("#submenu_"+i).removeClass('submenuactive');
	}

}
	else
	{

		$("#menu").show();
		$("#menu").css('z-index','10000');

		if(screen.width > 1500)
		{

			$(".menu").css('top','37.5%');
			$(".submenu").css('left','17%');
		}
		else if(screen.width < 1500 && screen.width > 1300)
		{
			$(".menu").css('top','26.5%');
			$(".submenu").css('left','19%');
		}
		else if(screen.width < 1300 && screen.width > 1100 )
		{
			$(".menu").css('top','29.5%');
			$(".submenu").css('left','20%');
		}
		else if(screen.width < 1100 )
		{
			$(".menu").css('top','26.5%');
			$(".submenu").css('left','25%');
		}

	}
}

function show_submenu(id)
{
	for(i=1;i<20;i++)
	{
		if(id != i)
		{
		$("#submenu_"+i).removeClass('submenuactive');
			//$("#submenu_"+i).hide();
		}
	}

	$("#submenu_"+id).addClass('submenuactive');
	$("#submenu_"+id).css('z-index','10000');
	$("#submenu_"+id).css('top',$("#menu_item_"+id).offset().top+ 'px');

}
function hide_submenu(id)
{
	$("#"+id).removeClass('submenuactive');

}
function hide_all_submenu()
{
	for(i=1;i<20;i++)
	{

		$("#submenu_"+i).removeClass('submenuactive');

	}

}
$(document).mouseup(function (e)
		{
	//if($("#menu").hasClass('menuactive'))
	//{
		    var container = $("#menu");

		    if (!container.is(e.target) && container.has(e.target).length === 0)
		    {
		    	$("#menu").hide();
		       // container.hide();
		    }
	//}

	for(i=1;i<20;i++)
	{
		if($("#submenu_"+i).hasClass('submenuactive'))
		{
			var container = $("#submenu_"+i);

		    if (!container.is(e.target) && container.has(e.target).length === 0)
		    {
		    	$("#submenu_"+i).removeClass('submenuactive');
		       // container.hide();
		    }
		}
	}

		});
		$(function(){

//$("#server_info").load("info.php");

$("#analytics_latest").load("index_admin.php?route=index&action=analytics_latest");


	  $( ".datep" ).datepicker();
			$("#theme_selector").change(function() {
				var theme = $(this).val();
				var loader = $("#jquery_ui_theme_loader");
				loader.attr("href", "resources/themes/wn/ui-themes/"+theme+"/jquery-ui-1.8.18.custom.css");
				  $.cookie('jquery-ui-theme-admin',theme,{ expires: 7 });

			});
		});
		function create_window_maximized_small(id,title)
		{
			if($("#menu").hasClass('menuactive'))
			{
			$("#menu").removeClass('menuactive');
			for(i=1;i<10;i++)
			{
				$("#submenu_"+i).removeClass('submenuactive');
			}

		}
			$.window.prepare({
				   dock: 'bottom',       // change the dock direction: 'left', 'right', 'top', 'bottom'
				   dockArea: $('#minimized_windows'), // set the dock area
				 //  animationSpeed: 200,  // set animation speed
				   minWinLong: 50       // set minimized window long dimension width in pixel
				});
		$.window({

			   title: title,

			  // content: $("#"+id).html(), // load window_block5 html content
			 			// scrollable: 'true',
			   x: -1,               // the x-axis value on screen, if -1 means put on screen center
			   y: -1,               // the y-axis value on screen, if -1 means put on screen center
			   width: 1000,           // window width
			   height: 600,          // window height
			   minWidth: 500,        // the minimum width, if -1 means no checking
			   minHeight: 600,       // the minimum height, if -1 means no checking
			   maxWidth: 700,        // the minimum width, if -1 means no checking
			   maxHeight: 400,       // the minimum height, if -1 means no checking
			  // scrollable: false,
			   onShow: function(wnd) {  // a callback function while container is added into body

			   	$("#"+wnd.getWindowId()).children(".window_frame" ).load("index_admin.php?route="+id);
				   },
				   onOpen: function(wnd) {  // a callback function while container is added into body
     windowStorage = $.window.getAll();
     for( var i=0, len=windowStorage.length; i<len; i++ ) {
				var win = windowStorage[i];
				 if(win.getTitle() == wnd.getTitle())
				 {
				 win.restore();
				 wnd.close();
				 }

			}
   },
		})
		}

		function create_window_maximized(id,title)
		{



			if(title.length > 12)
			{
			title = title.substring(0,12) + '...';
			}


			hide_all_submenu();
var show_window = true;
			 windowStorage = $.window.getAll();
		     for( var i=0, len=windowStorage.length; i<len; i++ ) {
						var win = windowStorage[i];
						 if(win.getTitle() == title)
						 {
							 if(win.isMinimized())
							 {

						 win.restore();
						 show_window = false;
							 }
							 else if(win.isMaximized())
							 {
								 show_window = false;
							 }
						 }
		     }

			 if(show_window == true)
			 {
				 hide_all_windows();
			$.window.prepare({
				   dock: 'bottom',       // change the dock direction: 'left', 'right', 'top', 'bottom'
				   dockArea: $('#minimized_windows'), // set the dock area
				   //animationSpeed: 100,  // set animation speed
				   minWinLong: 100       // set minimized window long dimension width in pixel
				});
		$.window({

			   title: title,


			   x: -1,               // the x-axis value on screen, if -1 means put on screen center
			   y: -1,               // the y-axis value on screen, if -1 means put on screen center
			   width: 1000,           // window width
			   height: 600,          // window height
			   minWidth: 500,        // the minimum width, if -1 means no checking
			   minHeight: 600,       // the minimum height, if -1 means no checking
			   maxWidth: 700,        // the minimum width, if -1 means no checking
			   maxHeight: 400,       // the minimum height, if -1 means no checking
			   scrollable: false,
			   onShow: function(wnd) {  // a callback function while container is added into body

			   	$("#"+wnd.getWindowId()).children(".window_frame" ).load("index_admin.php?route="+id);
			   wnd.maximize();
				   },
				   onOpen: function(wnd) {  // a callback function while container is added into body
     windowStorage = $.window.getAll();
     for( var i=0, len=windowStorage.length; i<len; i++ ) {
				var win = windowStorage[i];
				 if(win.getTitle() == wnd.getTitle())
				 {
				 win.restore();
				 wnd.close();
				 }


			}
   },
		})
			 }
		}

		function create_iframe_window(id)
		{
			$.window.prepare({
				   dock: 'bottom',       // change the dock direction: 'left', 'right', 'top', 'bottom'
				   dockArea: $('#minimized_windows'), // set the dock area
				 //  animationSpeed: 200,  // set animation speed
				 //  minWinLong: 180       // set minimized window long dimension width in pixel
				});
		$.window({

			   title: id,

			  url: "index_admin.php?route=forms&action=register", // load window_block5 html content
			 			// scrollable: 'true',
			   x: -1,               // the x-axis value on screen, if -1 means put on screen center
			   y: -1,               // the y-axis value on screen, if -1 means put on screen center
			   width: 1200,           // window width
			   height: 600,          // window height
			   minWidth: 500,        // the minimum width, if -1 means no checking
			   minHeight: 600,       // the minimum height, if -1 means no checking
			   maxWidth: 700,        // the minimum width, if -1 means no checking
			   maxHeight: 400,       // the minimum height, if -1 means no checking
			   scrollable: true,
			   onShow: function(wnd) {  // a callback function while container is added into body

			   //	$("#"+wnd.getWindowId()).children(".window_frame" ).load("index_admin.php?route="+id);
				   },
				   onOpen: function(wnd) {
					   // a callback function while container is added into body
     windowStorage = $.window.getAll();
     for( var i=0, len=windowStorage.length; i<len; i++ ) {
				var win = windowStorage[i];
				 if(win.getTitle() == wnd.getTitle())
				 {
					 if(win.isMinimized())
					 {

				 win.maximize();
					 }
				// wnd.close();
				 }
				 //wnd.maximize();

			}
   },
		})
		}

		function hide_all_windows()
		{
			 		$.window.minimizeAll();

		}

		function  close_all_windows()
		{

				   $.window.closeAll(true); // close all windows

		}


		function show_div(id)
{
$("#"+id).slideToggle();
}

		</script>
{/literal}
