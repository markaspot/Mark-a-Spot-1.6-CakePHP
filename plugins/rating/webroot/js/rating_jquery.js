/**
 * jQuery javascript for the CakePHP AJAX star rating plugin.
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
 * @param config JSON encoded plugin configurations
 * @param options JSON encoded rating options
 * @param enabled Enable the rating for a user
 */
function ratingInit(element, data, config, options, enabled) {
  ratingSettings[element] = new Array();  
  
  ratingSettings[element]['data'] = eval('(' + data + ')');
  ratingSettings[element]['options'] = eval('(' + options + ')');
	ratingSettings[element]['config'] =  eval('(' + config + ')');
  ratingSettings[element]['enabled'] = enabled;
  
  for (var i = 1; i <= ratingSettings[element]['data']['%MAX%']; i++) {
    $('#' + element + '_' + i).bind('mouseenter', {i: i}, function(e) {
      // workaround against event after reload
      var target = e.relatedTarget || e.toElement;
      
      if (target && target.id != element + '_' + e.data.i) {
        if (ratingSettings[element]['enabled']) {
          ratingSet(element, e.data.i);
        }
        
        if (ratingSettings[element]['config']['showMouseOverMessages']) {
          ratingMessages(element, e.data.i);
        }
      }
    });
    
    if (ratingSettings[element]['enabled']) {
      $('#' + element + '_' + i).bind('click', {i: i}, function(e) {
        ratingSave(element, e.data.i);
      });
    }
  }

  $('#' + element).bind('mouseleave', function(e) {
    ratingReset(element)
  });
  
  $('#' + element + '_text').bind('mouseenter', function(e) {
    ratingReset(element);
    
    if (ratingSettings[element]['config']['showMouseOverMessages']) {
      ratingMessages(element);
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
    
    $('#' + element + '_' + i).attr({'src': ratingSettings[element]['config']['appRoot'] + starImg});
    
    // set user mark
    if (ratingSettings[element]['config']['showUserRatingMark'] && i <= ratingSettings[element]['data']['%RATING%']) {
      $('#' + element + '_' + i).attr({'class': 'rating-user'});
    } else {
      $('#' + element + '_' + i).attr({'class': 'rating'});
    }
    
    // disable stars
    if (!ratingSettings[element]['enabled'] && !$('#' + element + '_' + i).attr('class').match(/-disabled/)) {
      $('#' + element + '_' + i).attr({'class': $('#' + element + '_' + i).attr('class') + '-disabled'});
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
  
  $('#' + element + '_text').html(ratingSettings[element]['config']['statusText']);
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
    $.ajax({
      url: ratingSettings[element]['config']['appRoot'] + 'rating/ratings/save/' + data[0] + '/' + data[3] + '/' + value + '?' + Math.floor(Math.random() * 999999),
      async: true,
      data: ratingSettings[element]['options'],
      error: function() {
        //alert('AJAX error');
      },
      beforeSend: function() {
        //$('#loader').show();
      },
      complete: function(XMLHttpRequest) {
        //$('#loader').hide();
        $('#' + element).html(XMLHttpRequest.responseText);
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
      $('#' + element + '_text').html(ratingSettings[element]['config']['mouseOverMessages']['delete']);
    } else if (ratingSettings[element]['config']['mouseOverMessages'][value]) {
      $('#' + element + '_text').html(ratingSettings[element]['config']['mouseOverMessages'][value]);
    }
  } else if (!ratingSettings[element]['enabled']
      && !ratingSettings[element]['config']['disable']
      && ratingSettings[element]['data']['%RATING%'] == 0
      && ratingSettings[element]['config']['mouseOverMessages']['login']){
    $('#' + element + '_text').html(ratingSettings[element]['config']['mouseOverMessages']['login']);
  } else if (!ratingSettings[element]['enabled'] 
      && ratingSettings[element]['data']['%RATING%'] > 0
      && ratingSettings[element]['config']['mouseOverMessages']['rated']){
    $('#' + element + '_text').html(ratingSettings[element]['config']['mouseOverMessages']['rated']);
  } else {
    $('#' + element + '_text').html(ratingSettings[element]['config']['statusText']);
  }
}