/**
 * Prototype javascript for the CakePHP AJAX star rating plugin.
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://bakery.cakephp.org/articles/view/ajax-star-rating-plugin-1
 * @version 2.4
 */

/**
 * Holds the settings for all rating elements.
 */
var ratingSettings = new Array();

/**
 * Initializes the rating element.
 *
 * @param element Id of the rating element
 * @param data JSON encoded rating data
 * @param options JSON encoded rating options
 * @param config JSON encoded plugin configurations
 * @param enabled Enable the rating for a user
 */
function ratingInit(element, data, config, options, enabled) {
	ratingSettings[element] = new Array();
  
  ratingSettings[element]['data'] = eval('(' + data + ')');
  ratingSettings[element]['options'] = eval('(' + options + ')');
  ratingSettings[element]['config'] =  eval('(' + config + ')');
	ratingSettings[element]['enabled'] = enabled;

  for (var i = 1; i <= ratingSettings[element]['data']['%MAX%']; i++) {
    $(element + '_' + i).observe('mouseover', function(e) {
      var value = this.id.match(/[0-9]*$/);
      
      // workaround against event after reload
      var target = e.relatedTarget || e.toElement;
      
      if (target && target.id != element + '_' + value) {
        if (ratingSettings[element]['enabled']) {
          ratingSet(element, value);
        }
        
        if (ratingSettings[element]['config']['showMouseOverMessages']) {
          ratingMessages(element, value);
        }
      }      
    });
    
    $(element + '_' + i).observe('click', function(e) {
      var value = this.id.match(/[0-9]*$/);
      
      ratingSave(element, value);
    });
  }
  
  $(element).observe('mouseout', function(e) {
    // workaround against mouseout event on child elements like links
    var target = e.relatedTarget || e.toElement;

    if (target && target.parentNode && target.parentNode.id != null && !target.parentNode.id.match(element)) {
      ratingReset(element);
    }
  });
  
  $(element + '_text').observe('mouseover', function(e) {
    // workaround against mouseover event on child elements like links
    var target = e.relatedTarget || e.toElement;
    
    if (target && target.parentNode && target.parentNode.id != null && !target.parentNode.id.match(element)) {
      ratingReset(element);
      
      if (ratingSettings[element]['config']['showMouseOverMessages']) {
        ratingMessages(element);
      }
    }
  });
  
  ratingReset(element);
}

/**
 * Sets the rating element to a rating value.
 *
 * @param element Name of element
 * @param value Rating value 
 */
function ratingSet(element, value) {
  var starImg = ratingSettings[element]['config']['starEmptyImageLocation'];
  
  for (i = 1; i <= ratingSettings[element]['data']['%MAX%']; i++) {
    if (i <= Math.floor(value)) {
      starImg = ratingSettings[element]['config']['starFullImageLocation'];
    } else if (i == Math.floor(value) + 1 && value.toString().match(/[0-9]\.[5-9]/)) {
      starImg = ratingSettings[element]['config']['starHalfImageLocation'];
    } else {
      starImg = ratingSettings[element]['config']['starEmptyImageLocation'];
    }
    
    $(element + '_' + i).src = ratingSettings[element]['config']['appRoot'] + starImg;
    
    // set user mark
    if (ratingSettings[element]['config']['showUserRatingMark'] && i <= ratingSettings[element]['data']['%RATING%']) {
      $(element + '_' + i).className = 'rating-user';
    } else {
      $(element + '_' + i).className = 'rating';
    }
    
    // disable stars
    if (!ratingSettings[element]['enabled'] && !$(element + '_' + i).className.match(/-disabled/)) {
      $(element + '_' + i).className += '-disabled';
    }    
  }
}

/**
 * Resets the rating element.
 *
 * @param element Element id
 */
function ratingReset(element) {
  if (ratingSettings[element]['config']['showUserRatingStars']) {
    ratingSet(element, ratingSettings[element]['data']['%RATING%']);
  } else {
    ratingSet(element, ratingSettings[element]['data']['%AVG%']);
  }
  
  $(element + '_text').update(ratingSettings[element]['config']['statusText']);
}

/**
 * Does the AJAX call to save the rating and 
 * updates the rating element.
 *
 * @param element Name of element
 * @param value Rating value
 */
function ratingSave(element, value) {
  data = element.split('_');
  
  if (ratingSettings[element]['enabled']) {
    new Ajax.Updater(element, ratingSettings[element]['config']['appRoot'] + 'rating/ratings/save/' + data[0] + '/' + data[3] + '/' + value + '?' + Math.floor(Math.random() * 999999), {               
      asynchronous: true,
      evalScripts: true,
      method: 'get',
      parameters: ratingSettings[element]['options'],
      onFailure: function error() {
        //alert('AJAX error');
      },
      onLoading: function (request) {
        //Element.show('loader');
      },
      onComplete: function (request, json) {
        //Element.hide('loader');
      }
    });
  }
}

/**
 * Displays the mouseOverMessages.
 *
 * @param element Name of element
 * @param value Rating value
 */
function ratingMessages(element, value) {
  if (ratingSettings[element]['enabled'] && value > 0) {
    if (value == ratingSettings[element]['data']['%RATING%'] 
        && ratingSettings[element]['config']['allowDelete'] 
        && ratingSettings[element]['config']['mouseOverMessages']['delete']) {
      $(element + '_text').update(ratingSettings[element]['config']['mouseOverMessages']['delete']);
    } else if (ratingSettings[element]['config']['mouseOverMessages'][value]) {
      $(element + '_text').update(ratingSettings[element]['config']['mouseOverMessages'][value]);
    }
  } else if (!ratingSettings[element]['enabled']
	    && !ratingSettings[element]['config']['disable']
      && ratingSettings[element]['data']['%RATING%'] == 0
      && ratingSettings[element]['config']['mouseOverMessages']['login']){
    $(element + '_text').update(ratingSettings[element]['config']['mouseOverMessages']['login']);
  } else if (!ratingSettings[element]['enabled'] 
      && ratingSettings[element]['data']['%RATING%'] > 0
      && ratingSettings[element]['config']['mouseOverMessages']['rated']){
    $(element + '_text').update(ratingSettings[element]['config']['mouseOverMessages']['rated']);
  } else {
    $(element + '_text').update(ratingSettings[element]['config']['statusText']);
  }
}