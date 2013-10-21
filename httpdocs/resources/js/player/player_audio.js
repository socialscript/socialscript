var audios_array=new Array();

function init_player_audio()
{
				$("#playlist").append('<div><h3><a href="#">In gallery</a></h3><div>');
				$(xml).find('same_gallery_item').each(function loopingItems(value)
				{

					var obj={title:$(this).find("title").text(), mp3:$(this).find("mp3").text(), ogv:$(this).find("ogv").text(),  description_player:$(this).find("description_player").text()};
					audios_array.push(obj);
					$("#playlist").append('<a><li id="item">'+obj.title+'</li></a>');
				});
				$("#playlist").append('</div></div>');
				$("#playlist").append('<div><h3><a href="#">Same user</a></h3><div>');
				$(xml).find('same_user_item').each(function loopingItems(value)
				{

					var obj={title:$(this).find("title").text(), mp3:$(this).find("mp3").text(), ogv:$(this).find("ogv").text(),  description_player:$(this).find("description_player").text()};
					audios_array.push(obj);
					$("#playlist").append('<a><li id="item">'+obj.title+'</li></a>');
				});
				$("#playlist").append('</div></div>');
				$("#playlist").append('<div><h3><a href="#">Related</a></h3><div>');
				$(xml).find('related_item').each(function loopingItems(value)
				{

					var obj={title:$(this).find("title").text(), mp3:$(this).find("mp3").text(), ogv:$(this).find("ogv").text(),  description_player:$(this).find("description_player").text()};
					audios_array.push(obj);
					$("#playlist").append('<a><li id="item">'+obj.title+'</li></a>');
				});
				$("#playlist").append('</div></div>');

				$("#playlist").append('</div>');

				$("#left_player").append('<audio width="'+width+'" height="'+height+'" controls="controls"><source src="'+audios_array[0].mp3+'" type="audio/mpeg" /><source src="'+audios_array[0].ogv+'" type="audio/ogg" />Your browser does not support the audio tag.</audio>');
				$("#description_player").append(audios_array[0].description_player);
				$("#playlist").accordion({
					header : "h3"
				});
				addListenersAudio();

}

function addListenersAudio()
{
	$('#playlist li').each(function looping(index)
	{
		$(this).click(function onItemClick()
		{
			$("#left_player").empty();
			$("#description_player").empty();
			$("#left_player").append('<audio width="'+width+'" height="'+height+'" controls="controls"><source src="'+audios_array[index].mp3+'" type="audio/mp3" /><source src="'+audios_array[index].ogv+'" type="audio/ogg" />Your browser does not support the audio tag.</audio>');
			$("#description_player").append(audios_array[index].description_player);
		});
	});

}