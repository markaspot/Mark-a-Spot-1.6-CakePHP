$(document).ready(function(){
	//$('#flashMessage').fancybox().trigger('click');

	var confCommon = {
		masDir		:	'/',
		//masDir		:	'/markaspot/',
		searchLabelAddress : 'nach Ort suchen',
		searchLabelContent : 'in Hinweisen suchen',
		searchSubmitValueLoc : 'Ort suchen',
		searchSubmitValueMarker : 'Hinweis suchen',
		searchQValueMarker : 'Schlagloch',
		searchQValueLoc : 'Glockengasse',
		searchMap : 'karte',
		searchSearch : 'search',
		commentPublish : 'veröffentlichen',
		commentHide : 'sperren',
		commentDelete : 'löschen'
	};


	/**
	*  MODAL BOX
	*/
	// if the requested cookie does not have the value I am looking for show the modal box
	if ($('.flash_success_modal').html()) {
		var modalMessage = $('#flashMessage').html();
	
		// on page load show the modal box
		// more info about the options you can find on the fancybox site
		$.fancybox(
			modalMessage, {
				'width': 500,
				'height' : 500,
				'speedIn' : 60,
				'speedOut' : 200,
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
	
	$(".search").append('<div><label for="SearchWhereSearch">'+ confCommon.searchLabelContent +'<input type="radio" name="data[Search][where]" id="SearchWhereSearch" value="'+ confCommon.searchSearch +'"  /></label><label for="SearchWhereKarte">'+ confCommon.searchLabelAddress +'<input type="radio" name="data[Search][where]" id="SearchWhereKarte" value="'+ confCommon.searchMap +'" checked="checked" /></label></div>');

	$("#SearchIndexForm").attr("action", confCommon.masDir + confCommon.searchMap);
	$("#SearchIndexForm").attr("method", 'get');
	$("#SearchQ").val(confCommon.searchQValueLoc);
	$("#SearchIndexForm input[type='submit']").val(confCommon.searchSubmitValueLoc);
	$("#SearchIndexForm").attr("method", 'get');
	$("#SearchQ").focus(function(){
		$('#SearchQ').val(""); 
		return false;
	});
	
	$(".required > label").append("*");
	
	$('#SearchWhereKarte').click(function() { 
		$("#SearchIndexForm").attr("action",$(this).val());
		$("#SearchIndexForm").attr("method", 'get');
		$("input[type='submit']").val(confCommon.searchSubmitValueLoc);
		$("#SearchQ").val(confCommon.searchQValueLoc);
		$("#SearchIndexForm").attr("method", 'get');
	}); 
	
	$('#SearchWhereSearch').click(function() { 
		$("#SearchIndexForm").attr("action",$(this).val());
		$("#SearchIndexForm").attr("method", 'post');
		$("#SearchQ").val(confCommon.searchQValueMarker);
		$("input[type='submit']").val(confCommon.searchSubmitValueMarker);
	}); 
		 
    $('#addFormPersonalsDiv').hide(); 
    $('#addFormMediaDiv').hide(); 
    
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

	$('.toggletabList > a').click(function(e) { 
		e.preventDefault();
		 $("#tabAll").fadeIn('slow'); 
	});
	
	$('.toggletabMylist > a').click(function(e) { 
		e.preventDefault();
		$("#tabMy").fadeIn('slow'); 
	});
	
	$('#MarkerEventStart').datepicker();
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
				$('#publish_'+id).html(confCommon.commentHide);
				$('#comment_'+id).find("p").removeClass('c_hidden');
				$('#comment_'+id).find("p").addClass('c_publish');
			} else {   	
				$('#publish_'+id).html(confCommon.commentPublish);
				$('#comment_'+id).find("p").removeClass('c_publish');
				$('#comment_'+id).find("p").addClass('c_hidden');
			}
		});
	});
	$('a.comment_delete').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent().parent();
		$.get('/comments/delete/'+ parent.attr('title'), function(data){
			id=parent.attr('id');
			if (data == 1) {   	
				$('#comment_'+id).find("a.commentDelete").html(confCommon.commentDelete);
				parent.animate({'backgroundColor':'#fb6c6c'},1300);
				parent.slideUp(300,function() {
					parent.remove();
				});


			} else  {
			 	alert("failed");
			}
		});
	});

  	$('a.link_view').wrapInner(document.createElement("span"));
  	$('a.add').wrapInner(document.createElement("span"));
  	$('a.view').wrapInner(document.createElement("span"));

  	$('a.link_edit').wrapInner(document.createElement("span"));
  	$('a.link_delete').wrapInner(document.createElement("span"));
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
    $('#validateMessage').hide();
    if ($('#validateMessage').is(':hidden'))
    {
		$('#addFormMediaDiv').hide(); 
    };
    
	$("#navigation li").tipTip();
  	
});



