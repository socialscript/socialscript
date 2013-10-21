$(document).ready(function() {
	$("#version_number").html($.Window.getVersion());
	//initExampleChangelogBlock();
	initThemeRoller();
	//initShareRegion();
	//initAttributes();
	//initMethods();
	//initCodeStyleContactPanel();
	$.window.prepare({
		showLog: true
	});
});

function initExampleChangelogBlock() {
	var minHeight = 20;
	$("#change_log_panel > div.more").get(0).expand = false;
	$("#change_log_panel > div.more").get(0).minHeight = $("#change_log_panel").height();
	$("#change_log_panel > div.more").click(function() {
		var block = $(this).parent();
		var targetHeight = this.minHeight? this.minHeight:minHeight;
		if( this.expand || this.expand == null ) {
			block.animate({
				maxHeight: targetHeight
			});
			this.expand = false;
		} else {
			//block.get(0).orgMaxHeight = block.css("maxHeight");
			block.animate({
				maxHeight: 5000
			});
			this.expand = true;
		}
	});
	
	$('.old_version_link').toggle(function() {
		var pos = $(this).position();
		var panel = $('#old_link_panel');
		panel.css({
			left: pos.left,
			top: pos.top + 20
		});
		panel.show();
	}, function() {
		$('#old_link_panel').hide();
	});
	
	$("#example1 > .javascript_code").codeview();
	$("#example2 > .html_code").codeview();
	$("#example2 > .javascript_code").codeview();
	$("#example3 > .javascript_code").codeview();
	$("#example4 > .javascript_code").codeview();
	$("#example5 > .html_code").codeview();
	$("#example5 > .javascript_code").codeview();
	$("#example6 > .javascript_code").codeview();
	//$("#example6 > .javascript_code2").codeview(); // do on head
	$("#example7 > .javascript_code").codeview();
	$("#example7 > .html_code2").codeview({fontSize:"14px"});
	$("#example7 > .javascript_code2").codeview();
	$("#example8 > .html_code").codeview();
	$("#example8 > .css_code").codeview();
	$("#example8 > .javascript_code").codeview();
	$("#example9 > .javascript_code").codeview();
	$("#example10 > .javascript_code").codeview();
	$("#example11 > .javascript_code").codeview();
}

function initAttributes() {
	var descs = $(".attributes_list").find(".attr_desc");
	descs.each(function() {
		var text = $(this).text();
		var regexp = /\[*\]/;
		var index = text.search(regexp);
		var defineStr = text.slice(0, index+1);
		defineStr = "<span class='format_define'>"+defineStr+"</span>";
		text = defineStr + text.slice(index+1);
		$(this).html(text);
	});
}

function initMethods() {
	// do nothing now
}

function initThemeRoller() {	
	$("#theme_selector").change(function() {
		var theme = $(this).val();
		var loader = $("#jquery_ui_theme_loader");
		loader.attr("href", "js/jquery/themes/"+theme+"/jquery-ui.css");
	});
}

function initShareRegion() {
	var region = $(".share_region");
	var title = document.title;
	var link = window.location.href;
	region.share({
		title: title,
		link: link
	});
}

function initCodeStyleContactPanel() {
	$("#code_style_link").click(function() {
		var link = $(this).text();
		$.window({
			title: "About The Code Style",
			url: link,
			width: 1024,
			height: 768,
			maxWidth: -1,
			maxHeight: -1
		});
	});
}

/***************** example code call function *****************/
function createWindowWithRemotingUrl() {
	$.window({
		title: "Cyclops Studio",
		url: "http://apps.fstoke.me/"
	});
}

function createWindowWithHtml() {
	$.window({
		showModal: true,
		modalOpacity: 0.5,
		icon: "http://www.fstoke.me/favicon.ico",
		title: "Professional JavaScript for Web Developers",
		content: $("#window_block2").html(), // load window_block2 html content
		footerContent: "<img style='vertical-align:middle;' src='img/star.png'> This is a nice plugin :^)"
	});
}

function createWindowWithBoundary(parentElmId) {
	if( parentElmId != null ) {
		var iconUrl = 'http://mail.google.com/favicon.ico';
		if( parentElmId == 'my_boundary_panel2' ) {
			iconUrl = 'https://picasaweb.google.com/favicon.ico';
		}
		$("#"+parentElmId).window({
			icon: iconUrl,
			title: "This window only can be dragged within its parent element",
			content: "<div style='padding:10px; font-weight:bold;'>I only can be dragged within my boss...@@</div>",
			checkBoundary: true,
			width: 200,
			height: 160,
			maxWidth: 400,
			maxHeight: 300,
			x: 80,
			y: 80,
			onSelect: function(wnd) { //  a callback function while user select the window
				log('select');
			},
			onUnselect: function(wnd) { // a callback function while window unselected
				log('unelect');
			}
		});
	} else {
		$.window({
			icon: 'http://www.fstoke.me/favicon.ico',
			title: "This window only can be dragged within body boundary",
			content: "<div style='padding:10px; font-weight:bold;'>I only can be dragged within body element."+
				"<br><br>Really? You can try it... :)</div>",
			checkBoundary: true,
			x: 80,
			y: 80,
			z: 2100
		});
	}
}

function createWindowStatic() {
	$.window({
		title: "Un-draggable & Un-resizable Window",
		content: "<div style='padding:10px; font-weight:bold;'>I can't be dragged...<br>"+
			"I can't be resized too...<br><br>Of course, maximize and minimize are also disabled... <br><br>"+
			"So... What can I do? I only can be closed. @_@</div>",
		draggable: false,
		resizable: false,
		maximizable: false,
		minimizable: false,
		showModal: true
	});
}

function createWindowComplex() {
	$.window({
		title: "complext window",
		content: $("#window_block5").html(), // load window_block5 html content
		x: 150,               // the x-axis value on screen, if -1 means put on screen center
		y: 100,               // the y-axis value on screen, if -1 means put on screen center
		width: 600,           // window width
		height: 300,          // window height
		minWidth: 200,        // the minimum width, if -1 means no checking
		minHeight: 100,       // the minimum height, if -1 means no checking
		maxWidth: 700,        // the minimum width, if -1 means no checking
		maxHeight: 400,       // the minimum height, if -1 means no checking
		scrollable: false,    // a boolean flag to show scroll bar or not
		onOpen: function(wnd) {  // a callback function while container is added into body
			alert('open');
		},
		onShow: function(wnd) {  // a callback function while whole window display routine is finished
			alert('show');
		},
		onClose: function(wnd) { // a callback function while user click close button
			alert('close');
		},
		onSelect: function(wnd) { //  a callback function while user select the window
			log('select');
		},
		onUnselect: function(wnd) { // a callback function while window unselected
			log('unelect');
		},
		onDrag: function(wnd) { // a callback function while window is going to drag
			log('drag');
		},
		afterDrag: function(wnd) { // a callback function after window dragged
			log('after dragged');
		},
		onResize: function(wnd) { // a callback function while window is going to resize
			log('resize');
		},
		afterResize: function(wnd) { // a callback function after window resized
			log('after resized');
		},
		onMinimize: function(wnd) { // a callback function while window is going to minimize
			log('minimize');
		},
		afterMinimize: function(wnd) { // a callback function after window minimized
			log('after minimized');
		},
		onMaximize: function(wnd) { // a callback function while window is going to maximize
			log('maximize');
		},
		afterMaximize: function(wnd) { // a callback function after window maximized
			log('after maximized');
		},
		onCascade: function(wnd) { // a callback function while window is going to cascade
			log('cascade');
		},
		afterCascade: function(wnd) { // a callback function after window cascaded
			log('after cascaded');
		}
	});
}

function createWindowWithRedirectChecking() {
	// bind window onbeforeunload event with callback function
	var checkRedirectMsg = null;
	window.onbeforeunload = function() {
		if(checkRedirectMsg != null) {
			return checkRedirectMsg;
		}
	}

	// create window to listen iframe start, end & window close event
	$.window({
		title: "create window with redirect checking",
		url: "http://www.myspace.com",
		onIframeStart: function(wnd, url) {
			checkRedirectMsg = "the window is going to redirect to URL:\r\n"+url;
		},
		onIframeEnd: function(wnd, url) {
			checkRedirectMsg = null;
		},
		onClose: function() {
			checkRedirectMsg = null;
		}
	});
}

function createWindowWithRedirectChecking2() {
	/*
	Set iframeRedirectCheckMsg attribute as a string value, note that there is a {url} text inside.
	It will be replace with real iframe url(e.g. "http://www.myspace.com" in this sample) when
	callback function returns.

	The difference between method 1 and 2 is that you can do more things while got onbeforeunload event.
	But the trade-off is you need to write more code to implement this feature instead of just pass a string.
	*/
	$.window({
		title: "create window with redirect checking",
		url: "http://www.myspace.com",
		iframeRedirectCheckMsg: "the window is going to redirect to {url}!!\r\nPlease select 'cancel' to stay here."
	});
}

function createWindowWithCustBtnsByJson() {
	// create buttons definition JSON Array
	var myButtons = [
		// facebook button
		{
		id: "btn_facebook",           // required, it must be unique in this array data
		title: "share to facebook",   // optional, it will popup a tooltip by browser while mouse cursor over it
		clazz: "my_button",           // optional, don't set border, padding, margin or any style which will change element position or size
		style: "",                    // optional, don't set border, padding, margin or any style which will change element position or size
		image: "img/facebook.gif",    // required, the url of button icon(16x16 pixels)
		callback:                     // required, the callback function while click it
			function(btn, wnd) {
				wnd.getContainer().find("#demo_text").text("Share to facebook!");
				wnd.getContainer().find("#demo_logo").attr("src", "img/facebook_300x100.png");
			}
		},
		// twitter button
		{
		id: "btn_twitter",
		title: "share to twitter",
		clazz: "my_button",
		style: "background:#eee;",
		image: "img/twitter.png",
		callback:
			function(btn, wnd) {
				wnd.getContainer().find("#demo_text").text("Share to twitter!");
				wnd.getContainer().find("#demo_logo").attr("src", "img/twitter_300x100.jpg");
			}
		}
	];

	// pass the JSON Array to "custBtns" attribute
	$.window({
		title: "create window with customized icon buttons",
		content: "<div style='padding:10px;'>"+
			"<div id='demo_text' style='font-size:24px;'>You can share something here...</div>"+
			"<img id='demo_logo' src='' alt=''/>"+
			"</div>",
		custBtns: myButtons
	});
}

function createWindowWithCustBtnsByElm() {
	// bind button element event
	var facebookBtn = $("#my_facebook_btn");
	facebookBtn.unbind("click");
	facebookBtn.click(function() {
		alert('Share to facebook!');
	});
	facebookBtn.unbind("mouseover");
	facebookBtn.mouseover(function() {
		var container = $(this).parents(".window_panel"); // get window container
		container.find("#demo_text").text("Share to facebook!");
		container.find("#demo_logo").attr("src", "img/facebook_300x100.png");
	});

	var twitterBtn = $("#my_twitter_btn");
	twitterBtn.unbind("click");
	twitterBtn.click(function() {
		alert('Share to twitter!');
	});
	twitterBtn.unbind("mouseover");
	twitterBtn.mouseover(function() {
		var container = $(this).parents(".window_panel"); // get window container
		container.find("#demo_text").text("Share to twitter!");
		container.find("#demo_logo").attr("src", "img/twitter_300x100.jpg");
	});

	// create buttons element JSON Array
	// Note that passing a pure HTML element or a jQuery wrapped element object are both working
	var myButtons = [
		facebookBtn,
		document.getElementById("my_twitter_btn")
	];

	// pass the JSON Array to "custBtns" attribute
	$.window({
		title: "create window with customized icon buttons",
		content: "<div style='padding:10px;'>"+
			"<div id='demo_text' style='font-size:24px;'>You can share something here...</div>"+
			"<img id='demo_logo' src='' alt=''/>"+
			"</div>",
		custBtns: myButtons
	});
}

function createCustWindow() {
	$.window({
		title: "Pro JavaScript Design Patterns",
		content: $("#window_block8"), // load window_block8 html content
		containerClass: "my_container",
		headerClass: "my_header",
		frameClass: "my_frame",
		footerClass: "my_footer",
		selectedHeaderClass: "my_selected_header",
		showFooter: false,
		showRoundCorner: true,
		createRandomOffset: {x:200, y:150}
	});
}

function create3Window() {
	for( var i=0; i<3; i++ ) {
		$.window({
			title: "this is window "+i,
			content: "<font size='5' style='padding:10px;'>you can minimize some windows and try click function buttons...</font>",
			createRandomOffset: {x:200, y:150},
			onClose: function(wnd) {
				alert("close window: "+wnd.getWindowId());
			}
		});
	}
}
function hideAllWindow() {
	$.window.hideAll(); // hide all windows
}
function showAllWindow() {
	$.window.showAll(); // show all windows
}
function closeAllWindow() {
	$.window.closeAll(); // close all windows
}
function closeAllWindowQuiet() {
	$.window.closeAll(true); // close all windows without callback
}

var sampleWnd = null; // to remember last created window instance
function createSampleWindow() { // create a inner html window
	sampleWnd = $.window({
		title: "Professional JavaScript for Web Developers",
		content: $("#window_block2").html(), // load window_block2 html content
		footerContent: "<img style='vertical-align:middle;' src='img/star.png'>"+
				"<img style='vertical-align:middle;' src='img/star.png'>"+
				"<img style='vertical-align:middle;' src='img/star.png'>"+
				" This is a nice plugin :^)",
		x: -1,
		y: -1,
		createRandomOffset: {x:200, y:150}
	});
}
function createRemoteSampleWindow() { // create a iframe window
	sampleWnd = $.window({
		title: "iPhone App: Gambling Memo",
		url: "http://itunes.apple.com/tw/app/id430593279?mt=8",
		x: -1,
		y: -1,
		createRandomOffset: {x:200, y:150}
	});
}
function changeSampleWindowTitle() { // trigger by Change Title button
	if( sampleWnd != null ) {
		sampleWnd.setTitle("New Title Here");
	}
}
function changeSampleWindowIcon() {
	if( sampleWnd != null ) {
		sampleWnd.setIcon("http://mail.google.com/favicon.ico");
	}
}
function changeSampleWindowContent() { // trigger by Change Content button
	if( sampleWnd != null ) {
		sampleWnd.setContent("<img style='float:left; margin:5px;' src='http://lh3.ggpht.com/_W-5oCUN3-sQ/TNUfl0dmtXI/AAAAAAAADwU/JcD0Gs-6VgY/s800/JavaScript%20%20-%20The%20Good%20Parts.jpg'>"+
			"The first version of this paper, written in 2003, had several shortcomings, not the least of which was that the techniques described were specific to Internet Explorer. I've updated and improved on the original, to document the current state of the art, especially in light of the extensive interest in <b>AJAX</b> technology and the increasing adoption of the FireFox browser.");
	}
}
function changeSampleWindowUrl() { // trigger by Change URL button
	if( sampleWnd != null ) {
		sampleWnd.setUrl("http://www.friendfeed.com/");
	}
}
function changeSampleWindowFooterContent() { // trigger by Change Footer Content button
	if( sampleWnd != null ) {
		sampleWnd.setFooterContent("New Footer Content...");
	}
}
function dock(direction) {
	$.window.prepare({
		dock: direction,      // change the dock direction: 'left', 'right', 'top', 'bottom'
		animationSpeed: 200,  // set animation speed
		minWinLong: 180       // set minimized window long dimension width in pixel
	});
}
function assignDockArea() {
	$.window.prepare({
		dock: 'bottom',       // change the dock direction: 'left', 'right', 'top', 'bottom'
		dockArea: $('#myDockArea'), // set the dock area
		animationSpeed: 200,  // set animation speed
		minWinLong: 180       // set minimized window long dimension width in pixel
	});
}

function moveWindow(bShift) {
	if( sampleWnd != null ) {
		if( bShift ) {
			sampleWnd.move(100, -50, true);
		} else {
			var y = $('#example11').offset().top + 50;
			sampleWnd.move(400, y);
		}
	}
}

function resizeWindow() {
	if( sampleWnd != null ) {
		sampleWnd.resize(200, 150);
	}
}

// testing function
function test() {
	var wnds = $.window.getAll();
	for( var i=0 ;i<wnds.length; i++ ) {
		var w = wnds[i];
		log( w.getWindowId()+': '+w.isSelected() );
	}
	var wnd = $.window.getSelectedWindow();
	info( wnd.getContainer() );
}