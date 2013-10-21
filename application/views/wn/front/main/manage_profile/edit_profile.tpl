

<div id="register" class="register">
	<form id="edit_profile_form"
		action="index.php?route=users&action=save_edit_profile">


		<div>
			<label for="username">{$languages->profile_username}</label>
			{$user->username}
		</div>
		<div class="register_form_separator"></div>
		<div>
			<label for="email">{$languages->profile_email}</label> {$user->email}
		</div>
		<div class="register_form_separator"></div>
		<div>
			<label for="password">{$languages->profile_password}</label> <input
				type="password"
				class="validate[required, custom[AtLeastOneNumberOneLowercaseOneUppercase]  ,minSize[6] ,maxSize[10]  ]"
				id="password" name="password" value="as23xjshA">
		</div>
		<div class="register_form_separator"></div>
		<div>
			<label for="password">{$languages->profile_repeat_password}</label> <input
				type="password" id="password2" name="register_password2"
				class="validate[required,equals[password]]"
				value="as23xjshA">
		</div>
		<div class="register_form_separator"></div>
		<div>
			<label for="dateofbirth">{$languages->profile_date_of_birth}</label>
			<select class=" select_dob_year " name="year"> {foreach
				from=$years_dropdown item=validator}
				<option {if $birthday.0 == $validator}selected="selected"{/if} value="{$validator}">{$validator}</option>{/foreach}
			</select> <select class="  select_dob" name="month">
				{foreach from=$months_dropdown item=validator}
				<option {if $birthday.1 == $validator}selected="selected"{/if} value="{$validator}">{$validator}</option>{/foreach}
			</select> <select class="  select_dob" name="day">
				{foreach from=$days_dropdown item=validator}
				<option {if $birthday.2 == $validator}selected="selected"{/if} value="{$validator}">{$validator}</option>{/foreach}
			</select>
		</div>
		<div class="register_form_separator"></div>



		{foreach from=$extra_fields item=form_field} {include
		file="$tpl_dir/form_fields/form.tpl"} {/foreach} <input type="submit"
			name="submit" id="edit_profile_button" value="Edit"
			class="btn">

	</form>
</div>

<script type="text/javascript">
function ajaxValidationCallbackEditProfile(status, form, json, options) {

	if (status === true) {

		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users&action=save_edit_profile",
			data : $("#edit_profile_form").serialize(),
			dataType : 'json',
			success : function(response) {

				if (response.response == true) {
					//$("#tabs-2").html('');
					//$("#tabs-2").html('Succesfully registered');
					show_notification(response.status);
					$("#edit_profile").dialog('close');
					show_profile();
					hide_loading();
				}
			}
		});
	}
	return false;

}

$(document).ready(function() {

	jQuery("#edit_profile_form").validationEngine('attach', {
		ajaxFormValidation : true,

		onAjaxFormComplete : ajaxValidationCallbackEditProfile,
		promptPosition : 'topRight',
		scroll : false
	});


});


</script>