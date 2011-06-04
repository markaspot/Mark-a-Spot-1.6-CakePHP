<?php
/**
 * Voting plugin for CakePHP 1.3
 *
 *
 * @author Michael Schneidt <michael.schneidt@arcor.de>
 * @copyright Copyright 2009, Michael Schneidt

 * @version 1.0
 */


/**
 * Disable the voting.
 */
$config['Voting.disable'] = false;

/**
 * Show errors and warnings that should help to setup the plugin.
 */
$config['Voting.showHelp'] = false;

/**
 * Show a flash message after voting.
 * 
 * (displays 'Voting.flashMessage')
 */
$config['Voting.flash'] = true;

/**
 * Message shown on flash.
 * 
 * (depends on 'Voting.flash')
 */
$config['Voting.flashMessage'] = __('Thank you for voting.', true);

/**
 * Enable fallback for disabled javascript.
 * 
 * (this inserts additional html code)
 */
$config['Voting.fallback'] = true;

/**
 * User id location in the session data.
 */
$config['Voting.sessionUserId'] = 'User.id';

/**
 * Enable Guest voting (ignores 'Voting.sessionUserId')
 */
$config['Voting.guest'] = true;

/**
 * Guest cookie duration time. (interpreted with strtotime())
 */
$config['Voting.guestDuration'] = '1 week';

/**
 * Voting options.
 * 
 * 'img' - link to an image
 * 'alt' - alt text for the image (optional)
 * 'title' - title of the option (optional)
 * 'wildcard' - wildcard for using the option votes in text (optional)
 */
$config['Voting.options'] = array(array('img' => '../voting/img/thumb-up.png',
                                        'alt' => __('Vote Yes', true),
                                        'title' => __('Yes', true),
                                        'wildcard' => 'YES_VOTES'),
                                  array('img' => '../voting/img/thumb-down.png',
                                        'alt' => __('Vote No', true),
                                        'title' => __('No', true),
                                        'wildcard' => 'NO_VOTES'),
                                  array('img' => '../voting/img/hand.png',
                                        'alt' => __('Abstain', true),
                                        'title' => __('Abstain', true),
                                        'wildcard' => 'ABSTAIN_VOTES'));

/**
 * Show the voting result. (after voting)
 */
$config['Voting.showResult'] = true;

/**
 * Show the result for each option. (after voting)
 */
$config['Voting.showOptionResults'] = true;

/**
 * Show the option titles defined in 'Voting.options'.
 */
$config['Voting.showOptionTitles'] = false;

/**
 * Voting result text.
 * 
 * The following wildcards can be used:
 *   #VOTES# - votes as number
 *   %VOTES% - votes as percentage
 * 
 * The option votes can be placed by using the wildcards defined in 'Voting.options' as follows:
 *   #WILDCARD# - option votes as number
 *   %WILDCARD% - option votes as percentage
 * 
 * (depends on 'Voting.showResult')
 */
//$config['Voting.resultText'] = __('We got #VOTES# vote(s): #YES_VOTES# Yes (%YES_VOTES%%), #NO_VOTES# No (%NO_VOTES%%), #ABSTAIN_VOTES# Abstain (%ABSTAIN_VOTES%%).', true);
$config['Voting.resultText'] = __('We got #VOTES# vote(s) for this Marker.', true);

/**
 * Option result text.
 * 
 * The following wildcards can be used:
 *   #VOTES# - option votes as number
 *   %VOTES% - option votes as percent
 * 
 * (depends on 'Voting.showOptionResults')
 */
//$config['Voting.optionResultText'] = __('#VOTES# vote(s) (%VOTES%%)', true);
$config['Voting.optionResultText'] = __('%VOTES%%', true);

/**
 * Save the average rating and vote count to the rated model.
 * 
 * This may speed up loading, because the values must not be
 * calculated from the ratings on every access. This is also 
 * helpful if you want to sort the model by rating data, e.g. 
 * using pagination sort.
 * 
 * This config only works, if you use no more than one rating 
 * element (name parameter) for each model id and no different 
 * config files (config parameter) with same field names set.
 * 
 * If set to true, you have to add the 'Rating.modelAverageField' 
 * and 'Rating.modelVotesField' to your rated models.
 */
$config['Voting.saveToModel'] = true;

/**
 * Field name in models for the average rating.
 * 
 * SQL: ALTER TABLE <model_table> ADD <Voting.modelProField> int(11) unsigned default '0';
 * 
 * (depends on 'Rating.saveToModel')
 */
$config['Voting.modelProField'] = 'voting_pro';

/**
 * Field name in models for the rating votes.
 * 
 * SQL: ALTER TABLE <model_table> ADD <Voting.modelConField> int(11) unsigned default '0';
 * 
 * (depends on 'Rating.saveToModel')
 */
$config['Voting.modelConField'] = 'voting_con';
/**
 * Field name in models for the rating votes.
 * 
 * SQL: ALTER TABLE <model_table> ADD <Voting.modelAbsField> int(11) unsigned default '0';
 * 
 * (depends on 'Rating.saveToModel')
 */
$config['Voting.modelAbsField'] = 'voting_abs';


?>