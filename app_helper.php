<?php
/**
 * Thanks to http://teknoid.wordpress.com/2008/11/28/cakephp-url-based-language-switching-for-i18n-and-l10n-internationalization-and-localization/
 *
 */
class AppHelper extends Helper {
   function url($url = null, $full = false) {
        if(!isset($url['language']) && isset($this->params['language'])) {
          $url['language'] = $this->params['language'];
        }    
        return parent::url($url, $full);
   }
}
?>