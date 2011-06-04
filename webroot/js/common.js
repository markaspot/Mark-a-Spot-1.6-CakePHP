$(document).ready(function(){

	/**
	*  Modal Box on Success Adding Conntent
	*/
	// if the requested cookie does not have the value I am looking for show the modal box
	
	if ($('.flash_success_modal').html()) {
		var modalMessage = $('#flashMessage').html();
	
		// on page load show the modal box
		// more info about the options you can find on the fancybox site
		$.fancybox(
			modalMessage,
			{
				'autoDimensions' : false,
				'width' : 350,
				'height': 'auto',
				'transitionIn' : 'none',
				'transitionOut' : 'none'
			}
		);
		$('#modal_close').live('click', function(e) {
		e.preventDefault();
			$.fancybox.close()
		});
	}  


	//fadeout flash messages on click
	$('.cancel').click(function(){
		$(this).parent().fadeOut();
		return false;
	});

	/**
	*  Building the Search Box
	*/

	$(".search").append('<div><label for="SearchWhereSearch">'+ conf.Common.searchLabelContent +'<input type="radio" name="data[Search][where]" id="SearchWhereSearch" value="'+ conf.Common.searchSearch +'"  /></label><label for="SearchWhereKarte">'+ conf.Common.searchLabelAddress +'<input type="radio" name="data[Search][where]" id="SearchWhereKarte" value="'+ conf.Common.searchMap +'" checked="checked" /></label></div>');

	$("#SearchIndexForm").attr("action", conf.masDir + conf.Common.searchMap);
	$("#SearchIndexForm").attr("method", 'get');
	$("#SearchQ").val(conf.Common.searchQValueLoc);
	$("#SearchIndexForm input[type='submit']").val(conf.Common.searchSubmitValueLoc);
	$("#SearchIndexForm").attr("method", 'get');
	$("#SearchQ").focus(function(){
		$('#SearchQ').val(""); 
		return false;
	});
	
	$(".required > label").append("*");
	
	$('#SearchWhereKarte').click(function() { 
		$("#SearchIndexForm").attr("action",$(this).val());
		$("#SearchIndexForm").attr("method", 'get');
		$("input[type='submit']").val(conf.Common.searchSubmitValueLoc);
		$("#SearchQ").val(conf.Common.searchQValueLoc);
		$("#SearchIndexForm").attr("method", 'get');
	}); 
	
	$('#SearchWhereSearch').click(function() { 
		$("#SearchIndexForm").attr("action",$(this).val());
		$("#SearchIndexForm").attr("method", 'post');
		$("#SearchQ").val(conf.Common.searchQValueMarker);
		$("input[type='submit']").val(conf.Common.searchSubmitValueMarker);
	}); 
		 
	$('#addFormPersonalsDiv').hide(); 
	$('#addFormMediaDiv').hide(); 
	$('.tweetReact').hide(); 
	
	
	$('#addFormPersonals > a').click(function (e){
		e.preventDefault();
		$('#addFormPersonalsDiv').slideToggle('fast'); 
		$('#addFormPersonals > a').toggleClass('plus'); 
	
	});
	
	$('#addFormMedia > a').click(function (e){
		e.preventDefault();
		$('#addFormMediaDiv').slideToggle('fast'); 
		$('#addFormMedia a').toggleClass('plus'); 
	});
	
	$('a.showReact').click(function (e){
		//id = $(this).parent().attr('id');
		e.preventDefault();
		$(this).parent().next().slideToggle('fast'); 
		$(this).toggleClass('plus'); 
	});
	
	$('input.ignoreCheck').click(function(){
		$('.importCheck').attr('checked', false);
		$('div.twitterAdmin').hide();
	})
	
	$('input.importCheck ').click(function(){
		if($(this).attr("checked")) {
			$(this).parent().next('div.twitterAdmin').show();
			$('.ignoreCheck').attr('checked', false);
		} else{
			$(this).parent().next('div.twitterAdmin').hide();
		}
	});
	$('div.twitterAdmin').hide();

	$('.toggletabList > a').click(function(e) { 
		e.preventDefault();
		 $("#tabAll").fadeIn('slow'); 
	});
	
	$('.toggletabMylist > a').click(function(e) { 
		e.preventDefault();
		$("#tabMy").fadeIn('slow'); 
	});
	
	$('#tabMenu>a').click(function() { 
	 		    $("#tabAll").show('slow'); 
	});
	
	$('#MarkerSubject').css("color","#666");
	if ($('#MarkerSubject').val() == "z.B: Gullideckel fehlt") {
	 	$('#MarkerSubject').val(""); 
	};
	
	$('#MarkersAddForm').submit(function() {
	  if ($('#MarkerSubject').val() == "z.B: Gullideckel fehlt") {
	 	$('#MarkerSubject').val(""); 
	    return false;
	  }
	});
	

	$("a.lightbox").fancybox();
	
	$("#flashMessage").fancybox({
		'modal' : true,
		'overlayOpacity'	:	0.7,
		'overlayColor'		:	'#000'
	});
	
	$("a.zoom2").fancybox({
		'zoomSpeedIn'		:	500,
		'zoomSpeedOut'		:	500
	});
	


	$('a.comment_publish').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		
		$.get('/comments/free/'+ parent.attr('title'), function(data){
			id=parent.attr('title');
			if (data == 1) {   	
				$('#publish_'+id).html(conf.Common.commentHide);
				$('#comment_'+id).find("p").removeClass('comment_hidden');
				$('#comment_'+id).find("p").addClass('comment_publish');
			} else {   	
				$('#publish_'+id).html(conf.Common.commentPublish);
				$('#comment_'+id).find("p").removeClass('comment_publish');
				$('#comment_'+id).find("p").addClass('comment_hidden');
			}
		});
	});
	$('a.comment_delete').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		$.get('/comments/delete/'+ parent.attr('title'), function(data){
			id=parent.attr('id');
			if (data == 1) {   	
				$('#comment_'+id).find("a.commentDelete").html(conf.Common.commentDelete);
				parent.animate({'backgroundColor':'#fb6c6c'},1300);
				parent.slideUp(300,function() {
					parent.remove();
				});


			} else  {
			 	alert("failed");
			}
		});
	});
	
	
	$('a.transaction_delete').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		$.get('/transactions/delete/'+ parent.attr('title'), function(data){
			id=parent.attr('id');
			if (data == 1) {   	
				$('#transaction_'+id).find("a.transactionDelete").html(conf.Common.commentDelete);
				parent.animate({'backgroundColor':'#fb6c6c'},1300);
				parent.slideUp(300,function() {
					parent.remove();
				});
	
	
			} else  {
			 	alert("failed");
			}
		});
	});

	/*
  	$('a.link_view').wrapInner(document.createElement("span"));
  	$('a.add').wrapInner(document.createElement("span"));
  	$('a.view').wrapInner(document.createElement("span"));

  	$('a.link_edit').wrapInner(document.createElement("span"));
  	$('a.link').wrapInner(document.createElement("span"));
  	*/
  	$('a.link_rss').wrapInner(document.createElement("span"));
  	$('a.link_password').wrapInner(document.createElement("span"));
	$('#cycleNav').append('<div id="zurueck">&lt;&lt;</div><div id="weiter">&gt;&gt;</div>');
	
	$('#info').cycle({ 
		timeout:       5000,  // milliseconds between slide transitions (0 to disable auto advance) 
		speed:         1200,  // speed of the transition (any valid fx speed value) 
		next:          '#weiter',  // id of element to use as click trigger for next slide 
		prev:          '#zurueck',  // id of element to use as click trigger for previous slide 
		before:        null,  // transition callback (scope set to element to be shown) 
		after:         null,  // transition callback (scope set to element that was shown) 
		height:       'auto', // container height 
		sync:          1,     // true if in/out transitions should occur simultaneously 
		fit:           1,     // force slides to fit container 
		pause:         1,     // true to enable "pause on hover" 
		delay:         0,     // additional delay (in ms) for first transition (descr: can be negative) 
		slideExpr:     null   // expression for selecting slides (if something other than all children is required) 	
	});
	
	// fade out good flash messages after 3 seconds 
	$('.message').animate({opacity: 1.0}, 8000).fadeOut();  
	$('.flash_success').animate({opacity: 1.0}, 8000).fadeOut();  
	$('.flash_error').animate({opacity: 1.0}, 8000).fadeOut();
	
	//$("#navigation li").tipTip();
	

	$('.comment').editable('/comments/update', {
		id        : 'data[Comment][id]',
		name      : 'data[Comment][comment]',
		type      : 'textarea',
		width: '270px',
		height: '100px',
		submit: 'ok',
		tooltip   : 'Click to edit comment'
	});



});



