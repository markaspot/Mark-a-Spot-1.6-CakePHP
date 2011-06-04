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
  var options = $$('#' + element + ' > div.option');
  var i = 0;
	
  options.each(function(option) {
		option.style.cursor = 'pointer';
		
		i++;
		
		option.observe('click', function(e) {
	    params = element.split('_');
	      
	    new Ajax.Updater(element, webroot + 'voting/votings/vote/' + model + '/' + id + '/' + name + '/' + config + '/' + i + '/false/' + '?' + Math.floor(Math.random() * 999999), {               
	      asynchronous: true,
	      evalScripts: true,
	      method: 'get',
	    });
	  });
  });
}