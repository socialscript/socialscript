{literal}
<script type="text/javascript">
 function loadSecureMediaPlayback()
 {
 	var pqs = new ParsedQueryString();
 	var parameterNames = pqs.params(false);
 	var parameters = {

 		//poster: "http://secure.fluidcast.net/admin/uploads/admin/dvr22/thumbnail.jpg",
 		src:"{/literal}{$video->file}{literal}",
 		skin:"{/literal}{$settings->resources_url}{literal}resources/player/skins/skin1.xml",
 		 		 		 		 		 		 	//	'streamType':  'dvr',
 		//, 	autoRewind: false
 		//  Google Analytics settings
 	//	plugin_ga: "{/literal}{$settings->resources_url}{literal}/player/GTrackPlugin.swf",
 		//"ga_fcmp" : escape (gTrackPluginConfig),
 		src_secureplayer_pageURL: "Player",
 		// Configure the Ad Plug-in
 		showVideoInfoOverlayOnStartUp: false,


 		showTextAd: false,
 		textAdDelayedSecond: '1',
 		textAdTitle: '',
 		textAdTitleColor: '',
 		textAdTitleFont:'',
 		textAdTitleFontSize: '',
 		textAdTitleBold: false,
 		textAdTitleItalic: false,
 		textAdDesc: '',
 		textAdDescColor: '',
 		textAdDescFont: '',
 		textAdDescFontSize: '',
 		textAdDescBold: false,
 		textAdDescItalic: false,
 		linkContent: "",
 		textAdLinkColor:  '',
 		textAdLinkFont:  '',
 		textAdLinkFontSize:  '',
 		textAdLinkBold: false,
 		textAdLinkItalic: false,
textTarget: '_blank',
 		showImageAd: false,
 		adImageUrl: "",
 		adImageLinkToUrl: "",
 		imageTarget: '',
 		showWaterMark: "false",
 		waterMarkStartingSecond : "1",
 		waterMarkImageUrl: "{/literal}{$settings->resources_url}{literal}resources/player/watermark.png",
 		waterMarkVerticalAlign: "",
 		waterMarkHorizontalAlign: "",
 		waterMarkAlpha: '0.5',
 		adWaterMarkUrl: "",

 		waterMarkVerticalMargin: '',
 		waterMarkHorizontalMargin: '',
watermarkTarget: '',
 		showVideoAd: false,
 		 		videoAdSourceUrl: "",
 		adVideoUrl: "",
 		videoTarget: '',
 		 		 		scaleMode: "stretch"


 	};

 	for (var i = 0; i < parameterNames.length; i++) {
 		var parameterName = parameterNames[i];
 		parameters[parameterName] = pqs.param(parameterName) ||
 		parameters[parameterName];
 	}

 	var wmodeValue = "direct";
 	var wmodeOptions = ["direct", "opaque", "transparent", "window"];
 	if (parameters.hasOwnProperty("wmode"))
 	{
 		if (wmodeOptions.indexOf(parameters.wmode) >= 0)
 		{
 			wmodeValue = parameters.wmode;
 		}
 		delete parameters.wmode;
 	}

 	// Embed the player SWF:
 	swfobject.embedSWF(
 	"{/literal}{$settings->resources_url}{literal}/resources/player/player.swf"
 	, "player"
 	, {/literal}{$user_video_settings->video_player_width}{literal}
 	,  {/literal}{$user_video_settings->video_player_height}{literal}
 	, "10.1.0"
 	, "{/literal}{$settings->resources_url}{literal}resources/player/expressInstall.swf"
 	, parameters
 	, {
 		allowFullScreen: "true"
 		//wmode: "transparent"
 	}
 	, {
 		name: "player"
 	}
 	);
 }
loadSecureMediaPlayback();
</script>
{/literal}