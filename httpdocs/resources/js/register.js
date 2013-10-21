function ajaxValidationCallbackRegister(status, form, json, options) {

	if (status === true) {

		// $("#accordion").fadeOut();
		// $("#accordion").html('');
		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users&action=register",
			data : $("#register_form").serialize(),
			dataType : 'json',
			success : function(response) {

							 show_user_notification("Succesfully registered.You can login now");


				hide_loading();
				if (no_ajax == 'yes') {
					$('#register_form')[0].reset();
				} else {
					$("#view_user_section").dialog('close');
				}
				return false;
				// }
			}
		});
	}
	return false;

}

$(document).ready(function() {

	jQuery("#register_form").validationEngine('attach', {
		ajaxFormValidation : true,

		onAjaxFormComplete : ajaxValidationCallbackRegister,
		promptPosition : 'topRight',
		scroll : false
	});

});