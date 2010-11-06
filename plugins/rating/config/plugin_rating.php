<?php
/**
 * Disable the user rating.
 */
$config['Rating.disable'] = false;

/**
 * Show errors and warnings that should help to setup the plugin.
 */
$config['Rating.showHelp'] = false;

/**
 * CakePHP app root.
 * 
 * If you access your app like http://yourdomain/mycake then /mycake/ is your app root.
 */
$config['Rating.appRoot'] = '/';

/**
 * Show a flash message after rating.
 * 
 * (displays 'Rating.flashMessage')
 */
$config['Rating.flash'] = false;

/**
 * Message shown on flash.
 * 
 * (depends on 'Rating.flash')
 */
$config['Rating.flashMessage'] = __('Your rating has been saved.', true);

/**
 * Enable fallback for disabled javascript.
 * 
 * (this inserts additional html code)
 */
$config['Rating.fallback'] = true;

/**
 * Show flash message on fallback save redirect.
 * 
 * (displays 'Rating.flashMessage')
 */
$config['Rating.fallbackFlash'] = true;

/**
 * User id location in the session data.
 */
$config['Rating.sessionUserId'] = 'User.id';

/**
 * Enable Guest rating. (ignores 'Rating.sessionUserId')
 * 
 * Guest access is stored in cookie to prevent multiple ratings (not secure!)
 */
$config['Rating.guest'] = true;

/**
 * Guest cookie duration time. (interpreted with strtotime())
 */
$config['Rating.guestDuration'] = '1 week';

/**
 * Maximum rating.
 */
$config['Rating.maxRating'] = 5;

/**
 * Location of the full star image.
 */
$config['Rating.starFullImageLocation'] = 'rating/img/star-full.png';

/**
 * Location of the empty star image.
 */
$config['Rating.starEmptyImageLocation'] = 'rating/img/star-empty.png';

/**
 * Location of the half star image.
 */
$config['Rating.starHalfImageLocation'] = 'rating/img/star-half.png';

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
$config['Rating.saveToModel'] = true;

/**
 * Field name in models for the average rating.
 * 
 * SQL: ALTER TABLE <model_table> ADD <Rating.modelAverageField> decimal(3,1) unsigned default '0.0';
 * 
 * (depends on 'Rating.saveToModel')
 */
$config['Rating.modelAverageField'] = 'rating';

/**
 * Field name in models for the rating votes.
 * 
 * SQL: ALTER TABLE <model_table> ADD <Rating.modelVotesField> int(11) unsigned default '0';
 * 
 * (depends on 'Rating.saveToModel')
 */
$config['Rating.modelVotesField'] = 'votes';

/**
 * Allow users to change their ratings.
 */
$config['Rating.allowChange'] = false;

/**
 * Allow users to delete their ratings by 
 * deselecting the current rating.
 * 
 * (depends on 'Rating.allowChange')
 */
$config['Rating.allowDelete'] = false;

/**
 * Display the user rating in stars instead of the average rating.
 */
$config['Rating.showUserRatingStars'] = false;

/**
 * Show a mark to indicate the user rating.
 *  
 * (change mark in /vendors/css/rating.css .rating-user)
 */
$config['Rating.showUserRatingMark'] = true;

/**
 * Define the text beside the stars.
 * 
 * %AVG% Average rating
 * %MAX% Maximum rating
 * %VOTES% Number of votes
 * %RATING% User rating
 */
$config['Rating.statusText'] = '%AVG% / %MAX%  (%VOTES%)';

/**
 * Show 'Rating.mouseOverMessages' on mouseover.
 */
$config['Rating.showMouseOverMessages'] = true;

/**
 * Messages that are showing on mouseover.
 *  
 * If you want to put links into the messages like for login, you have
 * to do that manually, because the CakePHP helpers don't work here yet.
 * 
 * 'login' this message appears if the user is not signed in.
 * 'rated' this message appears if the user rated already.
 * 'delete' this message appears if the user mouseovers his rating and 'Rating.allowDelete' is set true.
 * '1' to 'Rating.maxRating' represent the different rating values.
 * 
 * (depends on 'Rating.showMouseOverMessages')
 */
$config['Rating.mouseOverMessages'] = array('login' => __('Please log in first', true),
                                            'rated' => __('Thank you for voting', true),
                                            'delete' => __('Click to undo rating', true),
                                            '1' => __('Who cares!', true),
                                            '2' => __('Very unimportant', true),
                                            '3' => __('Relevant', true),
                                            '4' => __('Important', true),
                                            '5' => __('Hot spot!', true));

$config['Rating.options.title'] = __('Please rate this Marker',true);
?>