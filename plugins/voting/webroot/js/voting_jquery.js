/**
 * Initializes the voting element.
 *
 * @param model Model name
 * @param id Model id
 * @param name Voting name
 * @param config Voting config
 * @param webroot The webroot of the application.
 */
function votingInit(model, id, name, config, webroot) {
	var element = model + '_voting_' + name + '_' + id;
	var options = $('#' + element + ' > div.option');
  
	options.each(function(i) {
		$(this).css({
		  cursor: 'pointer'
	  });
		
		$(this).bind('click', {i: i}, function(e) {
		  $.ajax({
		    url: webroot + 'voting/votings/vote/' + model + '/' + id + '/' + name + '/' + config + '/' + i + '/false/' + '?' + Math.floor(Math.random() * 999999),
		    async: true,
		    complete: function(XMLHttpRequest) {
		      $('#' + element).html(XMLHttpRequest.responseText);
		    }
		  });
		});
	});
}