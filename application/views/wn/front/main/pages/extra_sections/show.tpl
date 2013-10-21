<div id="extra_sections"  class="accordion"  >
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#extra_sections" href="#collapseExtraSections">{$type|ucfirst}</a>
		</div>
    <div id="collapseExtraSections" class="accordion-body collapse in">
      <div class="accordion-inner">
		<div class="extra_sections_content">


			<div>
				<div id="add_new_extra_sections">
					<input type="button" class="btn btn-warning"
						onclick="add_new_extra_sections('{$type}')" value="Add">
				</div>
				<div class="clear"></div>
				<div id="add_extra_sections"></div>
				<div id="latest_extra_sections">{include
					file="$tpl_dir/pages/extra_sections/list.tpl"}</div>
			</div>


			<div id="edit_extra_sections" class="floatleft"
				style="margin-left: 50px; width: 300px">
				<div id="extra_sections_id" class="hidden"></div>
				<div id="edit_extra_sections_title"></div>
				<div id="edit_extra_sections_text"></div>
			</div>
			<div class="clear"></div>
		</div>

	</div>
</div>
</div>
</div>
{literal}
<script type="text/javascript">
$("#extra_sections").collapse();

function add_new_extra_sections(type)
{

	show_loading();
	$("#add_extra_sections").html('');
    $("#add_extra_sections").dialog({
        modal: true,
        open: function ()
        {
            $(this).load('index.php?route=users_interaction&action=add_extra_sections_form&type='+type);
            hide_loading();
        },
        height: 400,
        width: 520,
        title: 'Add',
        resizable:false,show: { effect: 'fade'},zIndex:'3000',hide: { effect: 'fade'}
    });


}





function edit_extra_sections_text()
{

	show_loading();


	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=edit_extra_sections",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'extra_sections_title':$("#edit_extra_sections_title").val(),
				'extra_sections_text':$("#edit_extra_sections_text").val(),
				'extra_sections_id':$("#extra_sections_id").html()
		},
		success : function(response) {
			show_notification(response.status);

			$("#extra_sections_title").val('');
			$("#extra_sections_text").val('');

			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=user_extra_sectionss",
				data : {

					'rh' : '{/literal}{$request_hash}{literal}',
						'extra_sections_category': $("#select_extra_sections_categories").val()
				},
				success : function(response) {



							$("#extra_sectionss").html('');
							 $("#extra_sectionss").html(response);

		$("#add_extra_sections").hide();
		$("#edit_extra_sections").hide();
		$("#edit_extra_sections_title").val('');
		$("#edit_extra_sections_text").val('');
		$("#extra_sections_title").val();
		$("#extra_sections_text").val();
							hide_loading();

						}
					});


		}
	});

}

</script>
{/literal}
