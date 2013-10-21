$(function() {

	// Accordion
	$("#my_account_box").accordion({
		header : "h3",
		fillSpace : true

	});
	if (not_load_middle_default == false) {
		$("#middle_boxes").accordion({
			header : "h3",

			fillSpace : true
		});
	}

	$("#left_bottom_box").accordion({
		header : "h3",
		fillSpace : true

	});
	$('#right_bottom_box').tabs({
		selected : 0,

		fillSpace : true

	});

	$("select").css("background",
			$(".ui-widget-header").css("background-color"));

	// Tabs

	if (user_logged == '1') {
		$('#tabs').tabs({
			selected : 0,
			select : function(event, ui) {
				if (no_ajax == 'yes') {
					if (ui.tab.rel) {
						location.href = ui.tab.rel;
					}
				}

			}
		});
	} else {
		$('#tabs').tabs({
			selected : 1,
			select : function(event, ui) {
				if (no_ajax == 'yes') {
					if (ui.tab.rel) {
						location.href = ui.tab.rel;
					}
				}

			}
		});
	}

	$('#chat').tabs({});
	$('#right_bottom_box').tabs({});
	$("#full-page-container").show();
	// Datepicker
	$('.datepicker').datepicker("options", "z-index", "100000000000");

});

function change_theme() {
	var theme = $("#theme_selector").val();
	var loader = $("#jquery_ui_theme_loader");
	loader.attr("href", "resources/themes/wn/ui-themes/" + theme
			+ "/jquery-ui-1.8.18.custom.css");
	$.cookie('jquery-ui-theme', theme, {
		expires : 7
	});

}
/*
 * function close_div(id) { $("#" + id).hide('slide', 1000); new_tab =
 * $(".topmenu").length; $("#tabs ul").append( '<li class="topmenu"
 * id="topmenu_' + id + '"><a onclick="show_div(\'' + id + '\')">my account</a></li>'); }
 */

function show_div(id) {
	$("#" + id).show('slide', 1000);

	$("#topmenu_" + id).remove();
}

function show_element(id) {

	$("#" + id).slideToggle();

}

function user_interaction(id, type) {
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=" + type,
		data : {
			'id' : id,
			'rh' : r_h
		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			hide_loading();
		}
	});

}

function clear_user_section() {
	$("#view_user_section").html('');
}

function show_notification(message) {
	$("#notifications").html(message);
	// $("#notifications").effect('pulsate', '', 'slow');
}

function show_user_notification(message) {
	show_loading();
	$("#notifications").html(message);
	hide_loading();
}
function show_loading() {
	$("#notifications").html('');
	$("#loading").show();
}

function hide_loading() {
	$("#loading").fadeOut(4000);
}

function go_to_top() {
	// $("#full-page-container")scrollTop();
	// return false;

}

function logout() {
	show_loading();
	/*
	 * if(no_ajax == 'yes') {
	 * document.location.href='index.php?route=users&action=logout'; } else {
	 */
	$.ajax({
		type : "GET",
		url : "index.php?route=users&action=logout",
		success : function(response) {
			hide_loading();
			$("#tabs").hide();
			$("#tabs").remove();
			$("#top").html(response);
			$("#tabs").fadeIn();
			$('#tabs').tabs({
				selected : 0
			});
			$("#my_account").hide(500, function() {
				$("#webcam").remove();
				$("#my_account").remove();
				$.ajax({
					type : "GET",
					url : "index.php?route=users&action=get_my_account",
					success : function(response) {
						$("#left_my_account").html(response);
						$("#my_account").fadeIn();
						$("#my_account").accordion({
							header : "h3",
							fillSpace : true
						});
						hide_loading();

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
			});

			$(document).ready(function() {

				jQuery("#login_form").validationEngine({

					ajaxFormValidation : true,
					onBeforeAjaxFormValidation : beforeCall,
					onAjaxFormComplete : ajaxValidationCallback,

				});

			});

		}
	});
	// }
}

function ask_question(id) {

	show_loading();
	clear_user_section();
	$("#view_user_section").dialog(
			{
				modal : true,
				open : function() {
					$(this).load(
							'index.php?route=users_interaction&action=ask_question_form&id='
									+ id);
					hide_loading();
				},
				height : 400,
				width : 520,
				title : 'Ask Question',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});

}

function ask_question_2(id) {
	show_loading();
	if ($.trim($("#ask_question_textarea").val()) == '') {
		show_notification(all_fields_required);
		hide_loading();
		return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=ask_question",
		data : {
			'id' : id,
			'rh' : r_h,
			'question' : $("#ask_question_textarea").val()
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			$("#view_user_section").dialog('close');
			clear_user_section();
			hide_loading();
		}
	});
}

function show_center(route, type) {
	hide_details();
	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=" + route + "&action=" + type,
		data : {
			'rh' : r_h
		},
		success : function(response) {

			if (!$("#middle_default").hasClass('middle_small')) {
				// $('#middle_default').animate({
				// width: ['toggle', 'swing'],
				// height: ['toggle', 'swing'],
				// },500, 'linear', function() {

				/*
				 * $("#middle_default").prependTo($("#left_default")).css({ top :
				 * 'auto', left : 'auto' }).addClass('middle_small');
				 * $("#middle_default").show();
				 */
				// });
			}

			$("#middle").hide();
			$("#middle").html('');
			$("#middle").html(response);
			$("#middle").fadeIn(500);
			$("#" + type).accordion({
				header : "h3",

				fillSpace : true
			});
			hide_loading();

		}
	});

}
function show_profile() {

	hide_details();
	$.ajax({
		type : "GET",
		url : "index.php?route=users&action=profile",
		data : {
			'rh' : r_h
		},
		success : function(response) {

			$("#middle").html(response);
			$("#profile").accordion({
				header : "h3",
				fillSpace : true
			});
			$("#extra_fields").accordion({
				header : "h3",
				fillSpace : true
			});
		}
	});

}

function invite_to_event(id) {
	show_loading();
	clear_user_section();
	$("#view_user_section").dialog(
			{
				modal : true,
				open : function() {
					$(this).load(
							"index.php?route=users_interaction&action=get_events_to_invite&id="
									+ id + "&rh=" + r_h);
					hide_loading();
				},
				height : 200,
				width : 520,
				title : 'Invite to event',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});

}

function invite_to_event_2(id) {
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=invite_to_event",
		data : {
			'id' : id,
			'rh' : r_h,
			'event' : $("#invite_to_event_id_" + id).val()
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			$("#view_user_section").dialog('close');
			hide_loading();
		}
	});
}

function show_message(id, status) {
	$("#message_text_" + id).toggle('clip', {}, 300);
	// show_loading();
	if (status == '0') {
		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=mark_message_read",
			data : {
				'id' : id,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {

				// show_notification(response.status);

				hide_loading();
			}
		});
	}

}
function delete_message(id) {

	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=delete_message",
		data : {
			'id' : id,
			'rh' : r_h
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			$("#message_" + id).fadeOut();
			hide_loading();
		}
	});

}

function view_user_section(route, action, id, dialog_title) {

	show_loading();
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=" + route + "&action=" + action,
		data : {
			'id' : id,
			'rh' : r_h
		},
		// dataType : 'json',
		success : function(response) {

			$("#view_user_section").html(response);
			$("#view_user_section").dialog({
				title : dialog_title,
				width : '1200',
				height : '700',
				resizable : false,
				modal : true,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});

			hide_loading();
		}
	});

}

function change_profile_picture() {
	$("#change_profile_picture").dialog({
		title : 'Upload Profile picture',
		modal : true,
		width : '300',
		height : '200',
		resizable : false,
		show : {
			effect : 'fade'
		},
		zIndex : '3000',
		hide : {
			effect : 'fade'
		}
	});

}

function send_message(id) {

	show_loading();
	clear_user_section();
	$("#view_user_section").dialog(
			{
				modal : true,
				open : function() {
					$(this).load(
							'index.php?route=users_interaction&action=send_message_form&id='
									+ id);

					hide_loading();
				},
				height : 400,
				width : 520,
				title : 'Send message',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});

}

function send_message_2(id) {
	show_loading();
	if ($.trim($("#message_title").val()) == ''
			|| $.trim($("#message_text").val()) == '') {
		show_notification(all_fields_required);
		hide_loading();
		return false;
	}
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=send_message",
		data : {
			'id' : id,
			'title' : $("#message_title").val(),
			'message' : $("#message_text").val(),
			'rh' : r_h
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			$("#view_user_section").dialog('close');
			hide_loading();
		}
	});

}

function show_user_groups() {

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=user_groups",
		data : {
			'rh' : r_h
		},
		success : function(response) {

			$("#middle").html(response);

		}
	});

}

function join_group(id, u_k) {
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=join_group",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : r_h

		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);

			hide_loading();
		}
	});
}

function group_details(id) {
	hide_details();
	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=group_details",
		data : {
			'id' : id,
			'rh' : r_h
		},
		// dataType : 'json',
		success : function(response) {

			if (response.indexOf('You are not logged in') != -1) {
				show_notification(response);
				hide_loading();
			} else {
				$("#view_groups").html('');
				$("#view_groups").html(response);

				$("#view_groups").show();
				$("#tabs_group_details").tabs();
				$(".group_details_left").accordion({
					header : "h3",
					fillSpace : true
				});
				hide_loading();
			}
		}

	});

}

function change_status() {
	// $(".speech_bubble").html('');
	$("#change_status").fadeIn();
}

function save_status() {

	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=save_user_status",
		data : {
			'rh' : r_h,
			'status' : $("#status").val()
		},
		success : function(response) {
			status_new = $("#status").val();
			$(".speech_bubble").html('');
			$(".speech_bubble").html(status_new);
			$("#change_status").fadeOut();
		}
	});

}

function view_profile(id) {
	hide_details();
	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users&action=view_profile",
		data : {
			'id' : id,
			'rh' : r_h
		},
		// dataType : 'json',
		success : function(response) {
			if (response.indexOf('You are not logged in') != -1) {
				show_notification(response);
				hide_loading();
			} else {

				$("#view_top").html('');
				$("#view_top").html(response);
				$("#view_top").show();
				$(".left_profile_page").accordion({
					header : "h3",

					fillSpace : true
				});
				$("#profile_pictures").tabs({
					selected : 0
				});
				$("#profile_blogs").tabs({
					selected : 0
				});
				$("#profile_events").tabs({
					selected : 0
				});
				$("#profile_groups").tabs({
					selected : 0
				});
				hide_loading();
			}
		}
	});

}

function subscribe_to_pictures(u_k) {
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=subscribe_to_pictures",
		data : {

			'u_k' : u_k,
			'rh' : r_h
		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			hide_loading();
		}
	});
}

function show_picture(p_id, g_id, g_n, u_k, p_n) {
	// $("#left_sections").html('');
	// $("#galleries_right").html('');
	$("#big_picture_gallery").html(
			'<img src="image.php?aoe=1&w=' + large_image_width + '&h='
					+ large_image_height + '&src=' + u_k + '/photos/' + g_n
					+ '/' + p_n + '" class="large_image">');
	// $("#big_picture_gallery").fadeIn();
	show_loading();
	$
			.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=view_pictures_comments",
				data : {
					'id' : p_id,
					'g_id' : g_id,
					'rh' : r_h
				},
				// dataType : 'json',
				success : function(response) {
					$("#pictures_comments").html(response);
					$("#pictures_comments").accordion({
						header : "h3",

						fillSpace : true
					});
					$('#group_picture_comment').wysiwyg({
						dialog : "jqueryui"
					});
					hide_loading();
				}
			});

	// $("#galleries_right").fadeOut('slow');

	// $("#big_picture").hide();
	//

}

function hide_details() {
	$("#view_top").html('');
	$("#view_top").hide();
	$("#left_sections_top").html('');
	$("#left_sections_top").hide();
	$("#view_groups").html('');
	$("#view_groups").hide();
	$("#middle_top").html('');
	$("#middle_top").hide();
	$("#right_top").html('');
	$("#right_top").hide();
	$("#details_right").html();
	$("#details_right").remove();
	$("#details_left").html();
	$("#details_left").remove();
	$("#left_sections").html('');
}
function show_picture_details(p_id, g_id, g_n, u_k, p_n) {

	show_loading();
	hide_details();
	$.ajax({
		type : "GET",
		url : 'index.php?route=users_interaction&action=picture_details&id='
				+ p_id,
		data : {
			'rh' : r_h
		},
		success : function(response) {
			$(response).prependTo($("#middle"));
			$("#details_right").accordion({
				header : "h3",

				fillSpace : true
			});
		}
	});

	$
			.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=view_pictures_all_comments",
				data : {
					'id' : p_id,
					'g_id' : g_id,
					'rh' : r_h
				},
				success : function(response) {
					$(response).prependTo($("#left_sections"));
					$("#details_left").accordion({
						header : "h3",

						fillSpace : true
					});
					$('#picture_comment').wysiwyg({
						dialog : "jqueryui"
					});

					hide_loading();

				}
			});

}

function subscribe_to_groups(u_k) {
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=subscribe_to_groups",
		data : {

			'u_k' : u_k,
			'rh' : r_h
		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			hide_loading();
		}
	});
}

function subscribe_to_events(u_k) {
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=subscribe_to_events",
		data : {

			'u_k' : u_k,
			'rh' : r_h
		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			hide_loading();
		}
	});
}

function subscribe_to_blog(u_k) {
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=subscribe_to_blog",
		data : {

			'u_k' : u_k,
			'rh' : r_h
		},
		dataType : 'json',
		success : function(response) {
			show_notification(response.status);
			hide_loading();
		}
	});
}

function show_group_profile_page(id, u_k) {

	show_loading();
	// $("#view_groups_profile_page").html('');
	$
			.ajax({
				type : "POST",
				url : "index.php?route=users_content&action=view_group",
				data : {
					'id' : id,
					'u_k' : u_k,
					'rh' : r_h
				},

				success : function(response) {

					$("#view_groups_profile_page")
							.dialog(
									{
										open : function(event, ui) {
											// $("#profile_page_groups_comments").html(response);
											$("#groups_profile_page").html(
													response);
											$
													.ajax({
														type : "POST",
														url : "index.php?route=users_interaction&action=view_group_comments",
														data : {
															'id' : id,
															'u_k' : u_k,
															'rh' : r_h
														},

														success : function(
																response) {
															$(
																	"#groups_comments")
																	.html(
																			response);
														}
													});

										}
									}, {
										title : 'Group',
										width : '1000',
										height : '600',
										resizable : false,
										show : {
											effect : 'fade'
										},
										zIndex : '3000',
										hide : {
											effect : 'fade'
										}
									});

					// $("#groups_right").html(response);
					hide_loading();
				}
			});

}

function show_blog_details(id, u_k) {

	show_loading();
	hide_details();
	$.ajax({
		type : "GET",
		url : 'index.php?route=users_content&action=view_blog',
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : r_h
		},
		success : function(response) {
			$(response).prependTo($("#middle"));
			$("#details_right").accordion({
				header : "h3",

				fillSpace : true
			});
		}
	});

	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=view_blog_comments",
		data : {

			'rh' : r_h,
			'id' : id
		},
		success : function(response) {
			$(response).prependTo($("#left_sections"));
			$("#details_left").accordion({
				header : "h3",

				fillSpace : true
			});
			$('#blog_comment').wysiwyg({
				dialog : "jqueryui"
			});
			hide_loading();

		}
	});

}

function show_event_details(id, u_k) {

	show_loading();
	hide_details();
	$.ajax({
		type : "GET",
		url : 'index.php?route=users_content&action=view_event',
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : r_h
		},
		success : function(response) {
			$(response).prependTo($("#middle"));
			$("#details_right").accordion({
				header : "h3",

				fillSpace : true
			});
		}
	});

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=view_event_comments",
		data : {

			'rh' : r_h,
			'id' : id
		},
		success : function(response) {
			$(response).prependTo($("#left_sections"));
			$("#details_left").accordion({
				header : "h3",

				fillSpace : true
			});
			$('#event_comment').wysiwyg({
				dialog : "jqueryui"
			});
			hide_loading();
		}
	});

}

function show_home() {
	show_loading();
	hide_details();

	$.ajax({
		type : "POST",
		url : "index.php?route=index&action=home",
		data : {
			'rh' : r_h
		},
		success : function(response) {

			$("#middle").hide();
			$("#middle").html('');
			$("#middle").html(response);
			$("#middle").fadeIn(500);
			$("#middle_boxes").accordion({
				header : "h3",

				fillSpace : true
			});
			$("#middle_matches").accordion({
				header : "h3",

				fillSpace : true
			});
			hide_loading();
		}
	});

}

function music_details(id, user) {

	show_loading();
	hide_details();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=music_details",
		data : {
			'id' : id,
			'user' : user,
			'rh' : r_h
		},
		success : function(response) {
			$(response).prependTo($("#middle"));
		}
	});

	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=music_files_comments",
		data : {
			'id' : id,
			'user' : user,
			'rh' : r_h
		},
		success : function(response) {
			$(response).prependTo($("#left_sections"));
			$("#left_details").accordion({
				header : "h3",

				fillSpace : true
			});
			$('#music_comment').wysiwyg({
				dialog : "jqueryui"
			});
			hide_loading();
		}
	});

}

function video_details(id, user) {

	show_loading();
	hide_details();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=video_details",
		data : {
			'id' : id,
			'user' : user,
			'rh' : r_h
		},
		success : function(response) {
			$(response).prependTo($("#middle"));
		}
	});

	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=video_comments",
		data : {
			'id' : id,
			'user' : user,
			'rh' : r_h
		},
		success : function(response) {
			$(response).prependTo($("#left_sections"));
			$("#left_details").accordion({
				header : "h3",

				fillSpace : true
			});
			$('#video_comment').wysiwyg({
				dialog : "jqueryui"
			});

			hide_loading();
		}
	});

}

function view_video_comments(id) {

	show_loading();

	$
			.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=view_video_files_comments",
				data : {
					'id' : id,
					'u_k' : u_k,
					'rh' : r_h
				},

				success : function(response) {
					$("#video_comments").html(response);
				}
			});
}

function add_video_comment(video_id) {
	show_loading();
	if ($.trim($("#video_comment").val()) == '') {
		show_notification(comment_empty);
		hide_loading();
		return false;
	}

	$
			.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=add_video_comment",
				data : {

					'rh' : r_h,
					'id' : video_id,
					'comment' : $("#video_comment").val(),
				},
				dataType : 'json',
				success : function(response) {

					show_notification(response.status);
					$('#video_comment').wysiwyg('clear');
					$
							.ajax({
								type : "POST",
								url : "index.php?route=users_interaction&action=get_video_comments",
								data : {

									'rh' : r_h,
									'id' : video_id
								},
								success : function(response) {
									$("#comments_list_details").html('');
									$("#comments_list_details").html(response);

									hide_loading();

								}
							});

					hide_loading();
				}
			});
}

function add_music_comment(music_id) {
	show_loading();
	if ($.trim($("#music_comment").val()) == '') {
		show_notification(comment_empty);
		hide_loading();
		return false;
	}
	$
			.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=add_music_files_comment",
				data : {

					'rh' : r_h,
					'id' : music_id,
					'comment' : $("#music_comment").val(),
				},
				dataType : 'json',
				success : function(response) {

					show_notification(response.status);
					$('#music_comment').wysiwyg('clear');
					$
							.ajax({
								type : "POST",
								url : "index.php?route=users_interaction&action=get_music_files_comments",
								data : {

									'rh' : r_h,
									'id' : music_id
								},
								success : function(response) {

									$("#comments_list_details").html('');
									$("#comments_list_details").html(response);

									hide_loading();

								}
							});

					hide_loading();
				}
			});
}

function edit_video(id, g_id) {
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=edit_video",
		data : {

			'rh' : r_h,
			'id' : id,
			'title' : $("#title_" + id).val(),
			'description' : $("#description_" + id).val(),
			'tags' : $("#tags_" + id).val(),
			'g_id' : g_id
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			hide_loading();
		}
	});
}
function edit_music(id, g_id) {
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=edit_music",
		data : {

			'rh' : r_h,
			'id' : id,
			'title' : $("#title_" + id).val(),
			'description' : $("#description_" + id).val(),
			'tags' : $("#tags_" + id).val(),
			'g_id' : g_id
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			hide_loading();
		}
	});
}
function edit_picture(id, g_id) {
	show_loading();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=edit_picture",
		data : {

			'rh' : r_h,
			'id' : id,
			'title' : $("#title_" + id).val(),
			'description' : $("#description_" + id).val(),
			'tags' : $("#tags_" + id).val(),
			'g_id' : g_id
		},
		dataType : 'json',
		success : function(response) {

			show_notification(response.status);
			hide_loading();
		}
	});
}

function trade_details(trade_id, u_k) {

	show_loading();

	hide_details();
	$.ajax({
		type : "POST",
		url : 'index.php?route=users&action=get_trade&trade_id=' + trade_id,
		data : {

		},
		success : function(response) {
			$(response).prependTo($("#middle"));
			$("#details_right").accordion({
				header : "h3",

				fillSpace : true
			});
			hide_loading();
		}
	});

	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=get_all_trade_questions",
		data : {

			'rh' : r_h,
			'id' : trade_id
		},
		success : function(response) {
			$(response).prependTo($("#left_sections"));
			$("#details_left").accordion({
				header : "h3",

				fillSpace : true
			});
			$('#trade_question').wysiwyg({
				dialog : "jqueryui"
			});

		}
	});

}

function view_trade_questions(id) {

	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=view_trade_questions",
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : r_h
		},

		success : function(response) {
			$("#trade_questions").html(response);
		}
	});
}

function view_comments_list_details(type, id) {

	show_loading();

	$
			.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=view_comments_list_details&type="
						+ type,
				data : {
					'id' : id,
					'u_k' : u_k,
					'rh' : r_h
				},

				success : function(response) {
					$("#comments_list_details").html(response);
					hide_loading();
				}
			});
}

function show_register() {
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=register_form",
		data : {

		},

		success : function(response) {
			$("#view_user_section").html(response);

			$("#view_user_section").dialog({
				modal : true,

				height : 500,
				width : 800,
				title : 'Register',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				},
				closeOnEscape : true,
				close : function(event, ui) {
					$('#register_form').validationEngine('hideAll');
					$("#view_user_section").html('');
				}
			});

			hide_loading();
		}
	});

}
function extra_sections_details(type, id, u_k) {

	show_loading();
	hide_details();
	$
			.ajax({
				type : "GET",
				url : 'index.php?route=users_interaction&action=extra_section_details&type='
						+ type + '&id=' + id,
				data : {
					'rh' : r_h
				},
				success : function(response) {
					$(response).prependTo($("#middle"));
					$("#details_right").accordion({
						header : "h3",

						fillSpace : true
					});
				}
			});

	$
			.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=get_extra_sections_all_comments&type="
						+ type,
				data : {

					'rh' : r_h,
					'id' : id
				},
				success : function(response) {
					$(response).prependTo($("#left_sections"));
					$("#details_left").accordion({
						header : "h3",

						fillSpace : true
					});
					$('#extra_sections_comment').wysiwyg({
						dialog : "jqueryui"
					});
					hide_loading();

				}
			});

}

function show_extra_sections(type) {

	hide_details();
	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=show_extra_sections",
		data : {
			'type' : type,
			'rh' : r_h
		},
		success : function(response) {

			$("#middle").hide();
			$("#middle").html('');
			$("#middle").html(response);
			$("#middle").fadeIn(500);
			$("#extra_sections").accordion({
				header : "h3",

				fillSpace : true
			});

		}
	});
}

function add_extra_sections_comment(type, extra_sections_id) {
	show_loading();
	if ($.trim($("#extra_sections_comment").val()) == '') {
		show_notification(comment_empty);
		hide_loading();
		return false;
	}
	$
			.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=add_extra_section_comment",
				data : {

					'rh' : r_h,
					'type' : type,
					'id' : extra_sections_id,
					'comment' : $("#extra_sections_comment").val(),
				},
				dataType : 'json',
				success : function(response) {

					show_notification(response.status);

					$('#extra_sections_comment').wysiwyg('clear');
					$
							.ajax({
								type : "GET",
								url : "index.php?route=users_interaction&action=get_extra_sections_comments",
								data : {
									'type' : type,
									'rh' : r_h,
									'id' : extra_sections_id
								},
								success : function(response) {
									$("#comments_list_details").html('');
									$("#comments_list_details").html(response);

									hide_loading();

								}
							});

				}
			});
}

function people_by_country(country) {
	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users&action=people_by_country",
		data : {
			'country' : country,
			'rh' : r_h
		},
		success : function(response) {

			if (!$("#middle_default").hasClass('middle_small')) {
				$('#middle_default').animate({
					width : [ 'toggle', 'swing' ],
					height : [ 'toggle', 'swing' ],
				}, 500, 'linear', function() {

					$("#middle_default").prependTo($("#left_default")).css({
						top : 'auto',
						left : 'auto'
					}).addClass('middle_small');
					$("#middle_default").show('bounce');

				});
			}
			$("#middle").html(response);
			$("#show_people_by_country").accordion({
				header : "h3"
			});
			hide_loading();

		}
	});
}

function add_picture_comment(picture_id) {
	show_loading();
	if ($.trim($("#picture_comment").val()) == '') {
		show_notification(all_fields_required);
		hide_loading();
		return false;
	}
	$
			.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=add_picture_comment",
				data : {

					'rh' : r_h,
					'id' : picture_id,
					'comment' : $("#picture_comment").val(),
				},
				dataType : 'json',
				success : function(response) {

					show_notification(response.status);
					$('#picture_comment').wysiwyg('clear');
					$
							.ajax({
								type : "GET",
								url : "index.php?route=users_interaction&action=view_pictures_comments",
								data : {

									'rh' : r_h,
									'id' : picture_id
								},
								success : function(response) {
									$("#comments_list_details").html('');
									$("#comments_list_details").html(response);

									hide_loading();

								}
							});

					hide_loading();
				}
			});
}

function search() {

	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=users&action=search",
		data : {

			'rh' : r_h,
			'username' : $("#username").val(),
			'featured' : $("#featured").attr('checked'),
			'online' : $("#online").attr('checked'),
			'only_with_picture' : $("#only_with_picture").attr('checked'),
			'male' : $("#male").attr('checked'),
			'female' : $("#female").attr('checked'),
			'age_min' : $("#age_min").val(),
			'age_max' : $("#age_max").val(),
			'country' : $("#search_country").val(),
			'order_by' : $("#order_by").val()
		},
		success : function(response) {

			$("#search_results").html(response);
			$("#search_results_results").accordion({
				header : "h3",

				fillSpace : true
			});
			$("select").css("background",
					$(".ui-widget-header").css("background-color"));
			hide_loading();
		}
	});

}

function show_picture_profile_details(p_id, g_id, g_n, u_k, p_n) {

	// $("#left_sections").html('');
	show_loading();

	$.ajax({
		type : "GET",
		url : 'index.php?route=users_interaction&action=picture_details&id='
				+ p_id,
		data : {
			'rh' : r_h,
			'n_a' : 1
		},
		success : function(response) {
			// $(response).prependTo($("#middle"));
			$("#middle_top").html(response);
			$("#middle_top").fadeIn();
			$("#details_right").accordion({
				header : "h3",

				fillSpace : true
			});
			big_picture = $("#profile_pic").html();

			big_picture = big_picture.replace('w=' + thumbnail_width, 'w='
					+ width_big_profile_picture);
			big_picture = big_picture.replace('h=' + thumbnail_height, 'h='
					+ height_big_profile_picture);
			$("#right_top").html(big_picture);
			$("#right_top").fadeIn();
		}
	});

	$
			.ajax({
				type : "GET",
				url : "index.php?route=users_interaction&action=view_pictures_all_comments",
				data : {
					'id' : p_id,
					'g_id' : g_id,
					'rh' : r_h
				},
				success : function(response) {
					$("#left_sections_top").html(response);
					$("#left_sections_top").fadeIn();
					$("#details_left").accordion({
						header : "h3",

						fillSpace : true
					});
					$('#picture_comment').wysiwyg({
						dialog : "jqueryui"
					});
					hide_loading();

				}
			});

}

function show_blog_profile_details(id, u_k) {

	show_loading();
	$.ajax({
		type : "GET",
		url : 'index.php?route=users_content&action=view_blog',
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : r_h,
			'n_a' : 1
		},
		success : function(response) {
			$("#middle_top").html(response);
			$("#middle_top").fadeIn();
			$("#details_right").accordion({
				header : "h3",

				fillSpace : true
			});
			big_picture = $("#profile_pic").html();

			big_picture = big_picture.replace('w=' + thumbnail_width, 'w='
					+ width_big_profile_picture);
			big_picture = big_picture.replace('h=' + thumbnail_height, 'h='
					+ height_big_profile_picture);
			$("#right_top").html(big_picture);
			$("#right_top").fadeIn();
		}
	});

	$.ajax({
		type : "GET",
		url : "index.php?route=users_interaction&action=view_blog_comments",
		data : {

			'rh' : r_h,
			'id' : id
		},
		success : function(response) {
			$("#left_sections_top").html(response);
			$("#left_sections_top").fadeIn();
			$("#details_left").accordion({
				header : "h3",

				fillSpace : true
			});
			$('#blog_comment').wysiwyg({
				dialog : "jqueryui"
			});
			hide_loading();

		}
	});

}

function show_event_profile_details(id, u_k) {

	show_loading();
	$.ajax({
		type : "GET",
		url : 'index.php?route=users_content&action=view_event',
		data : {
			'id' : id,
			'u_k' : u_k,
			'rh' : r_h,
			'n_a' : 1
		},
		success : function(response) {
			$("#middle_top").html(response);
			$("#middle_top").fadeIn();
			$("#details_right").accordion({
				header : "h3",

				fillSpace : true
			});
			big_picture = $("#profile_pic").html();

			big_picture = big_picture.replace('w=' + thumbnail_width, 'w='
					+ width_big_profile_picture);
			big_picture = big_picture.replace('h=' + thumbnail_height, 'h='
					+ height_big_profile_picture);
			$("#right_top").html(big_picture);
			$("#right_top").fadeIn();

		}
	});

	$.ajax({
		type : "POST",
		url : "index.php?route=users_interaction&action=view_event_comments",
		data : {

			'rh' : r_h,
			'id' : id
		},
		success : function(response) {
			$("#left_sections_top").html(response);
			$("#left_sections_top").fadeIn();
			$("#details_left").accordion({
				header : "h3",

				fillSpace : true
			});
			$('#event_comment').wysiwyg({
				dialog : "jqueryui"
			});
			hide_loading();
		}
	});

}

function manage_pictures() {

	show_loading();
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=manage_pictures",
		data : {

			'rh' : r_h,
			'gallery' : ''
		},
		success : function(response) {
			$("#view_user_section").hide();
			$("#view_user_section").html(response);
			$("#view_user_section").dialog({
				title : 'Manage your pictures',
				modal : true,
				width : '1200',
				height : '800',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});
			$("select").css("background",
					$(".ui-widget-header").css("background-color"));
			hide_loading();

		}
	});
}

function manage_music() {

	show_loading();
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=manage_music",
		data : {

			'rh' : r_h,
			'gallery' : ''
		},
		success : function(response) {
			$("#view_user_section").html(response);
			$("#view_user_section").dialog({
				title : 'Manage your music',
				modal : true,
				width : '1200',
				height : '800',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});

			hide_loading();

		}
	});
}

function manage_videos() {

	show_loading();
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=manage_videos",
		data : {

			'rh' : r_h,
			'gallery' : ''
		},
		success : function(response) {
			$("#view_user_section").html(response);
			$("#view_user_section").dialog({
				title : 'Manage your videos',
				modal : true,
				width : '1200',
				height : '800',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});
			$("select").css("background",
					$(".ui-widget-header").css("background-color"));
			hide_loading();

		}
	});
}

function manage_blogs() {
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=manage_blogs",
		data : {

			'rh' : r_h,
			'gallery' : ''
		},
		success : function(response) {
			$("#view_user_section").html(response);
			$("#view_user_section").dialog({
				title : 'Add new post',
				modal : true,
				width : '1200',
				height : '800',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});
			$("select").css("background",
					$(".ui-widget-header").css("background-color"));
			hide_loading();

		}
	});

}

function manage_events() {
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=manage_events",
		data : {

			'rh' : r_h,
		},
		success : function(response) {
			$("#view_user_section").html(response);
			$("#view_user_section").dialog({
				title : 'Manage events',
				modal : true,
				width : '1200',
				height : '800',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});
			hide_loading();

		}
	});

}

function manage_groups() {
	clear_user_section();
	$.ajax({
		type : "POST",
		url : "index.php?route=users_content&action=manage_groups",
		data : {

			'rh' : r_h,
		},
		success : function(response) {
			$("#view_user_section").html(response);
			$("#view_user_section").dialog({
				title : 'Manage groups',
				modal : true,
				width : '1200',
				height : '800',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				}
			});
			$("select").css("background",
					$(".ui-widget-header").css("background-color"));
			hide_loading();

		}
	});

}

function edit_profile() {
	show_loading();

	$.ajax({
		type : "POST",
		url : "index.php?route=users&action=edit_profile",
		data : {

			'rh' : r_h,
		},
		success : function(response) {
			$("#edit_profile").html('');
			$("#edit_profile").html(response);
			$("#edit_profile").dialog({
				title : 'Edit Profile',
				modal : true,
				width : '1000',
				height : '800',
				resizable : false,
				show : {
					effect : 'fade'
				},
				zIndex : '3000',
				hide : {
					effect : 'fade'
				},
				close : function(event, ui) {
					$('#edit_profile_form').validationEngine('hideAll');
				}
			});

			hide_loading();

		}
	});

}
function show_text_page(id) {
	hide_details();
	show_loading();
	$.ajax({
		type : "GET",
		url : "index.php?route=index&action=text_page&id=" + id,
		data : {
			'rh' : r_h
		},
		success : function(response) {

			$("#middle").hide();
			$("#middle").html('');
			$("#middle").html(response);
			$("#middle").fadeIn(500);
			$("#text_page").accordion({
				header : "h3",
				fillSpace : true

			});
			hide_loading();

		}
	});

}

function start_webcam() {
	if ($("#webcam").length == 0) {
		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=start_webcam",
			data : {
				'rh' : r_h
			},
			success : function(response) {

				$("#full-page-container").prepend(response);
				hide_loading();
			}

		});
	}
}
function view_webcam(id, webcam_id) {
	if ($("#webcam").length == 0) {
		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=connect_to_webcam&id="
					+ webcam_id,
			data : {
				'rh' : r_h
			},
			success : function(response) {

				$("#full-page-container").prepend(response);
				hide_loading();
			}

		});

	}

}

function show_game_details(id) {

	show_loading();
	hide_details();
	$.ajax({
		type : "GET",
		url : 'index.php?route=users_content&action=view_game',
		data : {
			'id' : id,
			'rh' : r_h,
			'n_a' : 1
		},
		success : function(response) {
			$(response).prependTo($("#middle"));
			$("#details_right").accordion({
				header : "h3",
				fillSpace : true
			});
			hide_loading();
		}
	});

}

function show_pagination(url, div_element) {
	show_loading();
	$.ajax({
		type : "GET",
		url : 'index.php?' + url,
		data : {
			'rh' : r_h,
			'n_a' : 1
		},
		success : function(response) {
			$("#" + div_element).html('');
			// $("#"+div).hide();
			$("#" + div_element).html(response);
			hide_loading();
		}
	});
}