<?php
class Utils {
  static function getLocale(){
    $locales = array('en', 'de');
    $accepted_languages = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    foreach ($accepted_languages as $l) {
      if (substr($l, 0, 2) == 'de') {
        return 'de';
      } else if (substr($l, 0, 2) == 'en') {
        return 'en';
      }
    }
    return 'en';
  }
}