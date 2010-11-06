<?php
/**
 * Video Media File
 *
 * Copyright (c) 2007-2010 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @package    media
 * @subpackage media.libs.media
 * @copyright  2007-2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link       http://github.com/davidpersson/media
 */
App::import('Lib', 'Media.Media');

/**
 * Video Media Class
 *
 * @package    media
 * @subpackage media.libs.media
 */
class VideoMedia extends Media {

/**
 * Compatible adapters
 *
 * @var array
 */
	var $adapters = array('Getid3Video', 'FfmpegVideo');

/**
 * Title stored in media metadata
 *
 * @return mixed String if metadata info exists, else null
 */
	function title() {
		return $this->Adapters->dispatchMethod($this, 'title', null, array(
			'normalize' => true
		));
	}

/**
 * Year stored in media metadata
 *
 * @return mixed Integer if metadata info exists, else null
 */
	function year() {
		return $this->Adapters->dispatchMethod($this, 'year', null, array(
			'normalize' => true
		));
	}

/**
 * Duration in seconds
 *
 * @return integer
 */
	function duration() {
		return $this->Adapters->dispatchMethod($this, 'duration', null, array(
			'normalize' => true
		));
	}

/**
 * Current height of media
 *
 * @return integer
 */
	function height() {
		return $this->Adapters->dispatchMethod($this, 'height', null, array(
			'normalize' => true
		));
	}

/**
 * Current width of media
 *
 * @return integer
 */
	function width() {
		return $this->Adapters->dispatchMethod($this, 'width', null, array(
			'normalize' => true
		));
	}

/**
 * Current bit rate of media
 *
 * @url http://en.wikipedia.org/wiki/Bit_rate
 * @return integer
 */
	function bitRate() {
		return $this->Adapters->dispatchMethod($this, 'bitRate', null, array(
			'normalize' => true
		));
	}

/**
 * Determines the quality of the media by
 * taking definition and bit rate into account
 *
 * @return integer A number indicating quality between 1 (worst) and 5 (best)
 */
	function quality() {
		$definition = $this->width() * $this->height();
		$bitRate = $this->bitRate();

		if (empty($definition) || empty($bitRate)) {
			return;
		}

		/* Normalized between 1 and 5 where min = 19200 and max = 414720 */
		$definitionMax = 720 * 576;
		$definitionMin = 160 * 120;
		$qualityMax = 5;
		$qualityMin = 1;

		if ($definition >= $definitionMax) {
			$quality = $qualityMax;
		} elseif ($definition <= $definitionMin) {
			$quality = $qualityMin;
		} else {
			$quality =
				(($definition - $definitionMin) / ($definitionMax - $definitionMin))
				* ($qualityMax - $qualityMin)
				+ $qualityMin;
		}

		$bitRateCoef = 3;

		if ($bitRate <= 128000) {
			$quality = ($quality + $qualityMin * $bitRateCoef) / ($bitRateCoef + 1);
		} elseif ($bitRate <= 564000) {
			$quality = ($quality + $qualityMax * 2 / 5 * $bitRateCoef) / ($bitRateCoef + 1);
		} elseif ($bitRate <= 1152000) {
			$quality = ($quality + $qualityMax * 3 / 5 * $bitRateCoef) / ($bitRateCoef + 1);
		} elseif ($bitRate <= 2240000) {
			$quality = ($quality + $qualityMax * 4 / 5 * $bitRateCoef) / ($bitRateCoef + 1);
		} else {
			$quality = ($quality + $qualityMax * $bitRateCoef) / ($bitRateCoef + 1);
		}
		return (integer)round($quality);
	}

/**
 * Determines a (known) ratio of media
 *
 * @return mixed String if $known is true or float if false
 */
	function ratio($known = true) {
		$width = $this->width();
		$height = $this->height();

		if (empty($width) || empty($height)) {
			return;
		}

		if (!$known) {
			return $width / $height;
		}
		return $this->_knownRatio($width, $height);
	}
}
?>