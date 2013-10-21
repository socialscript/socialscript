
<div class="accordion register " id="register" style="margin-top:20px;">
	<div class="accordion-group"> 
    <div class="accordion-heading">
      <a class="accordion-toggle btn-success" data-toggle="collapse" data-parent="#register" href="#collapseRegister">{$languages->register_title}</a>
		</div>
		
		 <div id="collapseRegister" class="accordion-body collapse in" >
      <div class="accordion-inner">
	<div class="middle_min_height">
		<form id="register_form"
			action="index.php?route=users&action=register">
			<!-- 	<fieldset>-->
			<label for="username">{$languages->register_username}</label> <input
				type="text" id="username"
				class="validate[required, custom[LetterNumberUnderscore]    ,ajax[ajaxUserCallPhp],minSize[2] ,maxSize[15]  ]
 ui-widget-header input"
				name="username"> <br> <label for="password">{$languages->register_password}</label>
			<input type="password"
				class="validate[required, custom[AtLeastOneNumberOneLowercaseOneUppercase]  ,minSize[6] ,maxSize[10]  ]
"
				id="password" name="password"> <br> <label for="password">{$languages->register_repeat_password}</label>
			<input type="password" id="password2" name="password2"
				class="validate[required,equals[password]] ">
			<br> 
			<label for="email" style="margin-left:-100px;">{$languages->register_email}</label> <input
				type="text" id="email"
				class="validate[required, custom[email]    ,ajax[ajaxEmailCallPhp] ]
"
				name="email"> <br> <label for="dateofbirth">{$languages->register_date_of_birth}</label>
			<select class="select_dob_year " name="year"> {foreach
				from=$years_dropdown item=validator}
				<option value="{$validator}">{$validator}</option>{/foreach}
			</select> <select class="select_dob" name="month">
				{foreach from=$months_dropdown item=validator}
				<option value="{$validator}">{$validator}</option>{/foreach}
			</select> <select class="select_dob" name="day">
				{foreach from=$days_dropdown item=validator} 
				<option value="{$validator}">{$validator}</option>{/foreach}
			</select> <br />{$languages->register_gender}:
			<ul class="imageless-css-3-form-elements">
				<label><input type="radio" name="gender" id="male" value="male"
					checked="checked"><span>{$languages->register_gender_male}</span></label>
			</ul>
			<ul class="imageless-css-3-form-elements">
				<label><input type="radio" name="gender" id="female" value="female"><span>{$languages->register_gender_female}</span></label>
			</ul>
			<div class="clear"></div>
			<br> {if $settings->show_countries_dropdown_on_register == 'yes'} <label
				for="countries">{$languages->register_country}</label> <select
				name="country" class=" "> {foreach
				from=$countries item=country}
				<option {if $country->iso_code_2 ==
					$user_country}selected="selected"{/if}
					value="{$country->iso_code_2}">{$country->iso_country}</option>
				{/foreach}
			</select> <br /> {/if} {foreach from=$form_fields item=form_field}
			{include file="$tpl_dir/form_fields/form.tpl"} {/foreach} <input
				type="submit" name="register" id="register"
				value="{$languages->register_submit_button}"
				class="btn">

			<!-- </fieldset>-->
		</form>
	</div>
</div>
</div>
<script type="text/javascript"
	src="{$settings->resources_url}/resources/js/register.js"></script>
{literal}
<script type="text/javascript">
$("select").css("background",
		$(".ui-widget-header").css("background-color"));
$(function() {
$("#register").collapse();
//$("#register").fadeIn();
});
	</script>
{/literal}
