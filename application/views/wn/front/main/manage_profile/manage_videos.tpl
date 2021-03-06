<link type="text/css"
	href="{$settings->resources_url}/resources/css/jquery.fileupload-ui.css"
	rel="stylesheet" />
{$languages->select_from_existing_galleries}:
<div id="galleries">
	<select name="galleries" id="select_galleries"
		class="ui-widget-header select " onchange="change_gallery(this)">
		{foreach from=$user_galleries item=user_gallery}
		<option value="{$user_gallery->id}">{$user_gallery->gallery_name}</option>
		{/foreach}
	</select>
</div>
<div id="create_new_gallery">
	{$languages->create_new_gallery}:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="text" name="gallery" id="new_gallery"> <input
		type="button" name="submit" value="Add" class='btn '
		onclick="add_gallery()">
</div>
<form id="fileupload"
	action="index.php?route=users_content&action=upload_videos&gallery={$default_videos_gallery_id}"
	method="POST" enctype="multipart/form-data">
	<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
	<div class="row fileupload-buttonbar">
		<div class="span7">
			<!-- The fileinput-button span is used to style the file input field as button -->
			<span class="btn btn-success fileinput-button"> <i
				class="icon-plus icon-white"></i> <span>Add files...</span> <input
				type="file" name="files[]" multiple>
			</span>
			<!--
			<button type="submit" class="btn btn-primary start">
				<i class="icon-upload icon-white"></i> <span>Start upload</span>
			</button>
			-->
			<button type="reset" class="btn btn-warning cancel">
				<i class="icon-ban-circle icon-white"></i> <span>Cancel upload</span>
			</button>
			<button type="button" class="btn btn-danger delete">
				<i class="icon-trash icon-white"></i> <span>Delete</span>
			</button>
			<input type="checkbox" class="toggle">
		</div>
		<div class="span5">
			<!-- The global progress bar -->
			<div class="progress progress-success progress-striped active">
				<div class="bar" style="width: 0%;"></div>
			</div>
		</div>
	</div>
	<!-- The loading indicator is shown during file processing -->
	<div class="fileupload-loading"></div>
	<br>
	<!-- The table listing the files available for upload/download -->
	<table class="table table-striped">
		<tbody class="files" data-toggle="modal-gallery"
			data-target="#modal-gallery" id="videos"></tbody>
	</table>
</form>
</div>
{literal}
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload">
        <td class="preview"><span class=""></span></td>
        <td class="name"><span>{%=file.name%}</span></td>
   <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
<td class="name"><span><input type="text" name="title_{%=file.name.replace(/ /g,'')%}" value="Title" class="input_upload"></span></td>
<td class="name"><span><textarea name="description_{%=file.name.replace(/ /g,'')%}" class="textarea_upload">Description</textarea></span></td>
<td class="name"><span><input type="text" name="tags_{%=file.name.replace(/ /g,'')%}" value="tags" class="input_upload"></span></td>

        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload icon-white"></i>
                    <span>{%=locale.fileupload.start%}</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="icon-ban-circle icon-white"></i>
                <span>{%=locale.fileupload.cancel%}</span>
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download">
        {% if (file.error) { %}
            <td></td>
            <td class="name"><span>{%=file.name%}</span></td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
<td class="name"><span><input type="text" name="title" value="{%=file.title%}" class="input_upload"></span></td>
<td class="name"><span><textarea name="description" class="textarea_upload">{%=file.description%}</textarea></span></td>
<td class="name"><span><input type="text" name="tags" value="{%=file.tags%}" class="input_upload"></span></td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.url) { %}
                <img src="{%=file.url%}" title="{%=file.name%}" rel="gallery">
            {% } %}</td>
            <td class="name">
               {%=file.name%}
            </td>
            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
<td class="name"><span><input type="text" name="title_{%=file.edit_id%}" id="title_{%=file.edit_id%}" value="{%=file.title%}" class="input_upload"></span></td>
<td class="name"><span><textarea name="description_{%=file.edit_id%}" id="description_{%=file.edit_id%}" class="textarea_upload">{%=file.description%}</textarea></span></td>
<td class="name"><span><input type="text" name="tags_{%=file.edit_id%}" id="tags_{%=file.edit_id%}" value="{%=file.tags%}" class="input_upload"></span></td>
            <td colspan="2"></td>
        {% } %}
  <td class="edit">
            <input type="button" value="Edit" onclick="edit_video({%=file.edit_id%},{%=file.gallery_id%})">
        </td>
        <td class="delete">
            <button class="btn btn-danger" data-url="{%=file.delete_url%}">
                <i class="icon-trash icon-white"></i>
                <span>{%=locale.fileupload.destroy%}</span>
            </button>
            <input type="checkbox" name="delete" value="1">
        </td>
    </tr>
{% } %}

</script>


{/literal}
<script
	src="{$settings->resources_url}/resources/js/jquery.upload/jquery.upload.min.js"></script>
{literal}
<script type="text/javascript">



function change_gallery(dropdown)
{
	show_loading();

$("#videos").html('');

$.ajax({
	type : "POST",
	url : "index.php?route=users_content&action=get_gallery_videos",
	data : {

		'rh' : '{/literal}{$request_hash}{literal}',
			'gallery':dropdown.value
	},
	success : function(response) {
$("#videos").html(response);

		hide_loading();

	}
});

	$("#fileupload").attr('action','index.php?route=users_content&action=upload_videos&gallery='+dropdown.value);
}
function add_gallery()
{
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=add_videos_gallery",
		data : {

			'rh' : '{/literal}{$request_hash}{literal}',
				'gallery': $("#new_gallery").val()
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);


			$.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=videos_galleries_dropdown",
				data : {

					'rh' : '{$request_hash}',
					'gallery': $("#new_gallery").val()
					},
				dataType : 'json',
				success : function(response) {
					$("#galleries").html();
$("#galleries").html(response.select);
$("#new_gallery").val();
$("#create_new_gallery").hide();
$("#fileupload").attr('action','index.php?route=users_content&action=upload_videos&gallery='+response.id);
					hide_loading();

				}
			});
			$("#videos").html('You have no videos in this gallery');
			hide_loading();
		}
	});
}

	</script>
{/literal}
