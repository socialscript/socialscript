

// Called once the server replies to the ajax form validation request

function ajaxValidationCallback(status, form, json, options) {

	if (json.status === true) {
		if(no_ajax == 'yes')
		{
				document.location.href=site_url + 'home';
		}
		else
		{
		$("#my_account").fadeOut();
		$("#my_account").html('');
		$("#my_account").remove('');
		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=get_my_account",
			success : function(response) {
				$("#left_my_account").html(response);
				$("#left_my_account").fadeIn();
				$("#my_account").accordion({
					header : "h3"
				});
				 hide_loading();

			}
		});
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=welcome",
			success : function(response) {
				$("#tabs").hide();
				$("#tabs").remove();
				$("#top").html(response);
				$("#tabs").fadeIn();
				/*$('#tabs').tabs({
					selected : 0
				});
				*/
				$('select#categories').selectmenu({menuWidth: 85,maxHeight:350});
				$('select#theme_selector').selectmenu({menuWidth: 85,maxHeight:350});
bind_mouseover();
			}
		});

		$.ajax({
			type : "GET",
			url : "index.php?route=chat&action=get_chat",
			success : function(response) {
				$("#chat").hide();
				$("#chat").remove();
				$("#right_chat").html(response);
				$('#chat').tabs({
					selected : 0
				});

			}
		});


	}
	}else {
		$("#login_response").html("Invalid username or password");
		hide_loading();
	}


}

function beforeCall(form, options) {

	show_loading();
	return true;

}

$(document).ready(function() {


	jQuery("#login_form").validationEngine({

		ajaxFormValidation : true,
		onBeforeAjaxFormValidation : beforeCall,
		onAjaxFormComplete : ajaxValidationCallback,

	});

});
