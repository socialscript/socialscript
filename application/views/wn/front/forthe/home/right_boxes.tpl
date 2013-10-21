<div class="floatleft right_boxes">
	{if $settings->enable_chat == 'yes'}
	<div id="right_chat">{include file="$tpl_dir/chat/chat.tpl"}</div>
	{/if}

	<div class="separator_vertical">&nbsp;</div>
	{include file="$tpl_dir/home/boxes/right_bottom_box.tpl"}
</div>
<div class="banner_right" style="margin:10px;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0056216336604218";
/* family */
google_ad_slot = "5225576821";
google_ad_width = 336;
google_ad_height = 280;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
{if isset($banners[1])}
{if $banners[1]->code != ''}
<div class="banner_right">{$banners[1]->code}</div>
 {/if}
 {/if}
