function send_general_message() {

	show_loading();
	if($.trim($("#new_general_message").val()) == '')
	{
	show_notification(empty_chat_message);
	hide_loading();
	return false;
	}
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=send_generalmessage',
		data : ({
			message : $("#new_general_message").val()
		}),
		dataType : 'json',
		success : function(response) {
			if (response.status != '') {
				show_notification(response.status);
			} else {
				get_messages_general();

			}
			hide_loading();
		}
	});
}
function get_messages_general() {
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=general_messages',
		data : ({

		}),

		success : function(response) {
			$("#load_general").html('');
			$("#load_general").html(response);
			//$('#chat_general').jScrollPane();
		}
	});
}
var auto_refresh = setInterval(function() {
	get_messages_general();
}, 10000);

function get_messages_friends_chat(id) {
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=friend_chat_messages',
		data : ({
			id : id
		}),

		success : function(response) {
			$('#conversation_chat_friend_' + id).html();
			$('#conversation_chat_friend_' + id).html(response);
			//$('#conversation_chat_friend_' + id).jScrollPane();

		}
	});
}
function get_messages_friends_chat_refresh() {
	if($("#active_chat_friend").html() != '')
		{
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=friend_chat_messages',
		data : ({
			id : $("#active_chat_friend").html()
		}),

		success : function(response) {
			$('#conversation_chat_friend_' + $("#active_chat_friend").html()).html();
			$('#conversation_chat_friend_' + $("#active_chat_friend").html()).html(response);
			//$('#conversation_chat_friend_' + $("#active_chat_friend").html()).jScrollPane();

		}
	});
		}
}

var asd = setInterval(function() {
	get_messages_friends_chat_refresh();
}, 10000);
function send_chat_friend_message(id) {

	show_loading();
	if($.trim("#conversation_chat_friend_message_" + id) == '')
	{
	show_notification(empty_chat_message);
	hide_loading();
	return false;
	}
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=send_friendmessage',

		data : ({
			message : $("#conversation_chat_friend_message_" + id).val(),
			id : id
		}),
		//dataType : 'json',
		success : function(response) {
			//if (response.status != '') {
				//show_notification(response.status);
			//} else {
				get_messages_friends_chat(id);

			//}
			hide_loading();
		}
	});
}

function friend_chat(id) {
	$("#active_chat_friend").html('');
	$("#active_chat_friend").html(id);
	$("#chat_friends_default").html('');
	$("#friend_chat_input").hide();
	$(".chat_friend").hide();
	if ($("#chat_friend_" + id).length > 0) {
		$("#chat_friend_" + id).show();
	} else {
		$("#chat_friends_messages")
				.append(
						'<div id="chat_friend_'
								+ id
								+ '" class="chat_friend"><div id="conversation_chat_friend_'
								+ id
								+ '" class="chat_friend_messages"></div></div><div id="friend_chat_input"><input type="text" id="conversation_chat_friend_message_'
								+ id
								+ '" class="ui-widget-header input "><input type="button"  onclick="send_chat_friend_message(\''
								+ id + '\')" value="Send" class="ui-widget-header input"></div>');
		get_messages_friends_chat(id);

	}
}

function chatroom_chat(id) {
	$("#active_chat_rooms").html(id);
	$(".chat_room").hide();
	//$("#chat_room_input").hide();
	$("#chat_rooms_default").html('');
	if ($("#chat_room_" + id).length > 0) {
		$("#chat_room_" + id).show();
	} else {
		$("#chat_rooms_messages")
				.append(
						'<div id="chat_room_'
								+ id
								+ '" class="chat_room"><div id="conversation_chat_room_'
								+ id
								+ '" class="conversation_chat_room"></div><div id="chat_room_input"><input type="text" id="conversation_chat_room_message_'
								+ id
								+ '" class="ui-widget-header input chat_input"><input type="button"  onclick="send_chat_room_message(\''
								+ id + '\')" value="Send" class="ui-widget-header input"></div></div>');
		get_messages_room_chat(id);

	}
}

function get_messages_room_chat(id) {
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=room_chat_messages',
		data : ({
			id : id
		}),

		success : function(response) {
			$('#conversation_chat_room_' + id).html('');
			$('#conversation_chat_room_' + id).html(response);
			//$('#conversation_chat_room_' + id).jScrollPane();

		}
	});
}
function get_messages_room_chat_refresh() {
	if($("#active_chat_rooms").html() != '')
		{
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=room_chat_messages',
		data : ({
			id : $("#active_chat_rooms").html()
		}),

		success : function(response) {
			$('#conversation_chat_room_' + $("#active_chat_rooms").html()).html('');
			$('#conversation_chat_room_' + $("#active_chat_rooms").html()).html(response);
			//$('#conversation_chat_room_' + $("#active_chat_rooms").html()).jScrollPane();
		}
	});
		}
}

function send_chat_room_message(id) {

	show_loading();
	if($.trim($("#conversation_chat_room_message_" + id).val()) == '')
	{
	show_notification(empty_chat_message);
	hide_loading();
	return false;
	}
	$.ajax({
		type : 'POST',
		url : 'index.php?route=chat&action=send_roommessage',

		data : ({
			message : $("#conversation_chat_room_message_" + id).val(),
			id : id
		}),
		dataType : 'json',
		success : function(response) {
			if (response.status != '') {
				show_notification(response.status);
			} else {
				get_messages_room_chat(id);

			}
			hide_loading();
		}
	});
}

var auto_refresh = setInterval(function() {
	get_messages_room_chat_refresh();
}, 10000);
