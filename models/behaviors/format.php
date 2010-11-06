<?php 
/**
 * CakePHP behaviour to format text entered by user.
 * Can be used to convert letters case, trim, etc.
 *
 * @filesource
 * @author Rostislav Palivoda
 * @link http://www.palivoda.eu
 * @version	$Revision$
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 * @package app
 * @subpackage app.models.behaviors
 */
class FormatBehavior extends ModelBehavior {
 
    var $settings = array(
    );
 
    function setup(&$model, &$config = array()) {
		$this->settings[$model->alias] = array_merge( $this->settings, $config );
    }
 
	function beforeValidate(&$model) {
 
		foreach (array('caseUpper', 'caseLower', 'caseTitle', 'caseSentence', 'noSpaces',
					'caseSentences', 'trim', 'html2text', 'normalSpacing', 'prefixUrl') as $section) {
			if (isset($this->settings[$model->alias][$section])) {
				foreach ($this->settings[$model->alias][$section] as $field) {
					if (isset($model->data[$model->alias][$field])) {
						$model->data[$model->alias][$field] = 
							$this->mb_format($model->data[$model->alias][$field], $section);
					}
				}
			}
		}
 
		return true;
	}
 
	function mb_format($string, $mode, $encoding = 'UTF-8') {
 
		if (in_array($mode, array('caseUpper', 'caseLower', 'caseTitle'))) {
			if ($mode == 'caseUpper') $mode = MB_CASE_UPPER;
			else if ($mode == 'caseLower') $mode = MB_CASE_LOWER;
			else if ($mode == 'caseTitle') $mode = MB_CASE_TITLE;
 
			return $this->mb_trimspaces(mb_convert_case($string, $mode, $encoding));
		}
		else if ($mode == 'caseSentence'){
			return $this->mb_ucfirst($string, $encoding);
		}
		else if ($mode == 'caseSentences') {
			return $this->sentence_case($string,  $encoding);
		}
		else if ($mode == 'html2text') {
			return $this->html2txt($string,  $encoding);
		}
		else if ($mode == 'trim') {
			return $this->mb_trimspaces($string);
		}
		else if ($mode == 'noSpaces') {
			return  preg_replace('/\s+/ui', '', $string);
		}
		else if ($mode == 'normalSpacing') {
			return $this->mb_normal_spacing($string,  $encoding);
		}
		else if ($mode == 'prefixUrl') {
			return $this->mb_prefix($string, array('www.', 'http://'), $encoding);
		}
		else return $string;
	}
 
	//Add prefix to string, if no prefix.
	function mb_prefix($string, $prefixes, $encoding) {
		foreach ($prefixes as $prefix) {
			if (mb_strpos($string, $prefix, 0, $encoding) === false) {
				$string = $prefix.$string;
			}
		}
		return $this->mb_trimspaces($string);
	}
 
    function mb_ucfirst($string, $encoding) {
		return $this->mb_trimspaces(mb_strtoupper(mb_substr($string, 0, 1, $encoding), $encoding).
			mb_substr($string, 1, mb_strlen($string), $encoding));
    }	
 
	function sentence_case($string, $encoding) {
		$sentences = preg_split('/([\.?!\n]+)/ui', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$new_string = '';
		foreach ($sentences as $key => $sentence) {
			$new_string .= ($key & 1) == 0?
				$this->mb_ucfirst(trim($sentence), $encoding) :
				$sentence.' '; 
		}
		return $this->mb_trimspaces($new_string);
	}
 
	//Remove spaces from start and end of the string and remove double spaces.
	//Transform "   aaa   bbb   " to "aaa bbb".
	function mb_trimspaces($string) {
		$retVal = $string;
		//debug('Before:"'.htmlspecialchars($string).'"');
		/*
foreach(array('/\r|\n|\r\n/ui' => '', '/\s\s+/ui' => ' ', 
			'/^\s+|\s+$/ui' => '', '//ui' => "\n", '/\n\s/' => "\n") as $pattern => $value) {
			$retVal = preg_replace($pattern, $value, $retVal);
		}
*/
		//debug('After:"'.htmlspecialchars($retVal).'"');
		return trim($retVal);
	}
 
	//Remove HTML tags.
	function html2txt($string){
		$search = array('@]*?>.*?@si',  // Strip out javascript
		               '@]*?>.*?@siU',    // Strip style tags properly
		               '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		               '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
		);
		$new_string = preg_replace($search, '', $string);
		return $this->mb_trimspaces($new_string);
	}
 
	//Transform "(aaa),bbb,(ccc)ddd,(eee)" to "(aaa), bbb, (ccc) ddd, (eee)".
	function mb_normal_spacing($string, $encoding) {
		//debug('"'.htmlspecialchars($string).'"');
 
		//put spaces after special characters, except last character
		$tokens = preg_split('/([\.?!,;:\)]){1}/u', mb_substr($string, 0, -1), -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$new_string = '';
		foreach ($tokens as $key => $token) {
			//debug('"'.mb_substr($new_string, -1, 1).'" - '.mb_strlen($token).' - "'.$token.'"');
			if (mb_strlen($token) == 1 && mb_substr($new_string, -1, 1) == " ") 
				$new_string = trim($new_string);
			$new_string .= mb_strlen($token) == 1 ? $token.' ' : $token; 
			//debug('"'.$new_string.'"');
		}
		$new_string .= mb_substr($string, -1, 1);
 
		//spaces before specila characters, except first character
		$tokens = preg_split('/([\(]){1}/u', mb_substr($new_string, 1), -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
		$new_string = mb_substr($new_string, 0, 1);
		foreach ($tokens as $key => $token) {
			//debug('"'.mb_substr($new_string, -1, 1).'" - '.mb_strlen($token).' - "'.$token.'"');
			if (mb_strlen($token) == 1 && mb_substr($new_string, -1, 1) == " ") 
				$new_string = trim($new_string);
			$new_string .= mb_strlen($token) == 1 ? ' '.$token : $token; 
			//debug('"'.$new_string.'"');
		}
 
		//debug('"'.htmlspecialchars($new_string).'"');
		return $this->mb_trimspaces($new_string);
	}
 
}
?>