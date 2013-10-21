<div style="color:red;margin:5px;">{$status}</div>
<script type="text/javascript">
//parent.$("#change_profile_picture").dialog('close');
parent.hide_loading();
</script>
<form method="post" enctype="multipart/form-data">
	<input type="file" name="picture"> <input type="submit" name="submit"
		value="Upload" onclick="parent.show_loading()">
</form>