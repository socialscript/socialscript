var videos_array=new Array();

function init_player()
{


				$("#playlist").append(' 
	<div id="playlist2"  class="accordion"  >
	<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#search_results_results" href="#collapseSearchResultsResults">In Gallery</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in">
      <div class="accordion-inner">');
				$(xml).find('same_gallery_item').each(function loopingItems(value)
				{
					var obj={title:$(this).find("title").text(), mp4:$(this).find("mp4").text(), ogg:$(this).find("ogg").text(),webm:$(this).find("webm").text(),  description_player:$(this).find("description_player").text()};
					videos_array.push(obj);
					$("#playlist").append('<a><li id="item">'+obj.title+'</li></a>');
				});
				$("#playlist").append('</div></div></div></div>');
				$("#playlist").append('<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#search_results_results" href="#collapseSearchResultsResults">Same User</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in">
      <div class="accordion-inner">');
				$(xml).find('same_user_item').each(function loopingItems(value)
				{
					var obj={title:$(this).find("title").text(), mp4:$(this).find("mp4").text(), ogg:$(this).find("ogg").text(), webm:$(this).find("webm").text(), description_player:$(this).find("description_player").text()};
					videos_array.push(obj);
					$("#playlist").append('<a><li id="item">'+obj.title+'</li></a>');
				});
				$("#playlist").append('</div></div></div></div>');
				$("#playlist").append('<div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn-success" data-toggle="collapse" data-parent="#search_results_results" href="#collapseSearchResultsResults">Related</div>
    <div id="collapseEventsDetails" class="accordion-body collapse in">
      <div class="accordion-inner">');
				$(xml).find('related_item').each(function loopingItems(value)
				{
					var obj={title:$(this).find("title").text(), mp4:$(this).find("mp4").text(), ogg:$(this).find("ogg").text(), webm:$(this).find("webm").text(), description_player:$(this).find("description_player").text()};
					videos_array.push(obj);
					$("#playlist").append('<a><li id="item">'+obj.title+'</li></a>');
				});
				$("#playlist").append('</div></div></div></div>');

				$("#playlist").append('</div>');

				$("#left_player").append('<video width="'+width+'" height="'+height+'" controls="controls"><source src="'+videos_array[0].mp4+'" type="video/mp4" /><source src="'+videos_array[0].ogg+'" type="video/ogg" /><source src="'+videos_array[0].webm+'" type="video/webm" />Your browser does not support the video tag.</video>');
				$("#description_player").append(videos_array[0].description_player);
				$("#playlist2").collapse();
				addListeners();

}

function addListeners()
{
	$('#playlist li').each(function looping(index)
	{
		$(this).click(function onItemClick()
		{
			$("#left_player").empty();
			$("#description_player").empty();
			$("#left_player").append('<video width="'+width+'" height="'+height+'" controls="controls"><source src="'+videos_array[index].mp4+'" type="video/mp4" /><source src="'+videos_array[index].ogg+'" type="video/ogg" /><source src="'+videos_array[index].webm+'" type="video/webm" />Your browser does not support the video tag.</video>');
			$("#description_player").append(videos_array[index].description_player);
		});
	});

}