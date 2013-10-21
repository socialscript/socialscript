
	<script src="{$settings->resources_url}/resources/js/webcam.js" type="text/javascript"></script>
	{literal}
	<script type="text/javascript">
	{/literal}{if isset($moderator) }{literal} var moderator = true;
	{/literal}{else}{literal}var moderator = false;{/literal}{/if}{literal}
	</script>
	{/literal}
{literal}

	<script type="text/javascript">
		var api_key = "{/literal}{$settings->opentok_api_key}{literal}";
		var session_id = '{/literal}{$sessionId}{literal}';
				var token = '{/literal}{$token}{literal}';


				var connections = {};

				$(document).ready(function() {
					TB.setLogLevel(5);

					session = TB.initSession(session_id);
					session.addEventListener("sessionConnected", sessionConnectedHandler);
					session.addEventListener("streamCreated", streamCreatedHandler);
					session.addEventListener("sessionDisconnected", sessionDisconnectedHandler);
					session.connect(api_key, token);
				});

				function sessionConnectedHandler(event) {
					var PUBLISHER_WIDTH = {/literal}{$settings->webcam_width}{literal};
					var PUBLISHER_HEIGHT = {/literal}{$settings->webcam_height}{literal};
					var publisherProps = {width: PUBLISHER_WIDTH, height: PUBLISHER_HEIGHT, publishAudio: {/literal}{$settings->webcam_enable_audio}{literal}};
					if (moderator == true) {
						$("#moderators_container").append($("<div id='temp_publish_div'></div>"));
					} else {
						$("#publishers_container").append($("<div id='temp_publish_div'></div>"));
					}
					session.publish("temp_publish_div",publisherProps);

					streamCreatedHandler(event);
				}

				function streamCreatedHandler(event) {
					for (var i = 0; i < event.streams.length; i++) {
						if (event.streams[i].connection.connectionId != session.connection.connectionId) {
							if (event.streams[i].connection.data == "moderator") {
								$("#moderators_container").append($("<div id='temp_div'></div>"));
							} else {
								$("#publishers_container").append($("<div id='temp_div'></div>"));
							}
							session.subscribe(event.streams[i], "temp_div");
						}
					}
				}

				function sessionDisconnectedHandler(event) {
					$.ajax({
						type : "POST",
						url : "index.php?route=users&action=disconnect_webcam",
						data : {
							'rh' : r_h
						},
						success : function(response) {


						}
					});
				}

				function disconnect() {
					session.disconnect();
				}
				</script>
				{/literal}
<div class="webcam">

		<div id="moderators_container" class="floatleft"></div>
		<div id="publishers_container" class="floatleft"></div>

<a onclick="disconnect()">Disconnect</a>
</div>