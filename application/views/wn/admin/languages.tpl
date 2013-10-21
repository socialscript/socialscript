<div class="ui-widget-header left_panel">
	{$languagesText} <br /> <br />
	<div id="add_language_response" class="notification hidden">
		<img src="{$settings->site_url}/resources/images/notification.png">
		{$add_new_language_text}
	</div>
</div>
<div class="center_panel">
	<div class="floatleft">
		<select name="languages" onchange="load_language(this)"
			class="ui-widget-header select ">
			<option value="">Select</option> {foreach from=$languages
			item=language}
			<option value="{$language->language}">{$language->language}</option>
			{/foreach}
		</select>
	</div>
	<div class="floatright" id="add_new">

		<form method="post" id="add_language"
			action="index_admin.php?route=languages&action=add">
			<div id="add_new_language">
				<div>
					<a onclick="add_new_language()">Add new Language</a>
				</div>
			</div>
		</form>
	</div>


	<div class="clear"></div>
	<table id="languages"></table>
	<div id="languagespager"></div>
	<div id="grid_languages"></div>


</div>
{$grid}
<link type="text/css"
	href="{$settings->resources_url}/resources/css/jquery.Validation.css"
	rel="stylesheet" />
<link type="text/css"
	href="{$settings->resources_url}/resources/css/radio.css"
	rel="stylesheet" />
<script type="text/javascript"
	src="{$settings->resources_url}/resources/js/validation/jquery.validationEngine.js"></script>
<script type="text/javascript"
	src="{$settings->resources_url}/resources/js/validation/languages/jquery.validationEngine-en.js"></script>

<script type="text/javascript">

function add_new_language()
{
	$("#add_new_language").html('<input type="text" name="new_language" id="new_language" class="validate[required]"><input type="submit" name="submit" value="Add language">');
}
function load_language(obj)
{
	if(obj.value != "")
	{

	$('#languages').jqGrid('GridUnload');

$("#grid_languages").load("index_admin.php?route=languages&action=load_language&lang="+obj.value);
	}
}
function ajaxValidationCallback(status, form, json, options) {
	$.ajax({
		type: "POST",
		url: "index_admin.php?route=languages&action=add",
		data: $("#add_language").serialize(),
		 dataType: 'json',
		success: function (response) {
if(response.status == "success")
{
	$("#add_new").hide();

$("#add_language_response").show();
}
		}
	});

}
jQuery("#add_language").validationEngine({

	ajaxFormValidation : true,

	onAjaxFormComplete : ajaxValidationCallback,

});
</script>

