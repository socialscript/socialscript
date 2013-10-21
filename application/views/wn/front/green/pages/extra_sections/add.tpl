
<div id="add_extra_section" style="width: 450px">
	{$languages->title}: <input type="text"
		name="extra_sections_title_{$type}" id="extra_sections_title_{$type}"
		class="ui-widget-header  input input_text_big">
	<textarea id="extra_sections_text_{$type}"
		style="width: 400px; height: 200px" class="ui-widget-header  input"></textarea>
	<input type="button" value="Submit"
		onclick="add_extra_sections_text('{$type}')"
		class="ui-widget-header input">
</div>

{literal}
<script type="text/javascript">
$(function ()
		{
$('#extra_sections_text_{/literal}{$type}{literal}').wysiwyg({dialog:"jqueryui"});
});

function add_extra_sections_text(type)
{

	show_loading();
	if($.trim($("#extra_sections_title_{/literal}{$type}{literal}").val()) == '' || $.trim($("#extra_sections_text_{/literal}{$type}{literal}").val()) == '')
	{
	show_notification(all_fields_required);
	hide_loading();
	return false;
	}

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=add_extra_sections",
		data : {
'type':type,
			'rh' : r_h,
				'extra_sections_title':$("#extra_sections_title_{/literal}{$type}{literal}").val(),
				'extra_sections_text':$("#extra_sections_text_{/literal}{$type}{literal}").val()

		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			$("#extra_sections_title_{/literal}{$type}{literal}").val('');
			$("#extra_sections_text_{/literal}{$type}{literal}").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=get_latest_extra_sections",
				data : {
'type':type,
					'rh' : r_h,

				},
				success : function(response) {

					$("#latest_extra_sections").html(response);
		$("#add_extra_sections").dialog('close');

							hide_loading();

						}
					});


		}
	});

}
</script>
{/literal}
