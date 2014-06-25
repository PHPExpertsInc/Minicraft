<?php

class Translator {
  protected $translations = array();
  
  public function __construct($languagedir = '') {
    foreach (glob($languagedir . '*.php') as $languagefile) {
      $basename = basename($languagefile);
      require_once($languagedir . $basename);
      $filename                      = preg_replace('#.php#', '', $basename);
      $this->translations[$filename] = new Translation($filename, $lang);
    }
  }
  
  public function getTranslation($language = 'en', $key, $markers = array()) {
    $translation = $this->translations[$language]->translate($key);
    
    if (empty($translation)) {
      $translation = $key;
    }
    
    for ($i = 0; $i < count($markers); $i++) {
      $translation = preg_replace('#%m' . ($i + 1) . '%#', $markers[$i], $translation);
    }
    
    return $translation;
  }
  
  // Short version of getTranslation
  public function getTrsl($language = 'en', $key, $markers = array()) {
    return $this->getTranslation($language, $key, $markers);
  }
  
  public function getTranslations() {
    return $this->translations;
  }
  
  public function getDefaultLanguage() {
    $default = array_values($this->translations);
    return $default[0]->getName();
  }
  
  public function getCountries($language = 'en') {
    $countries = !empty($this->translations[$language]) ? $this->translations[$language]->getCountries() : null;
    
    return $countries;
  }
  
  public function mergeWithTranslator($translator, $overwrite = false) {
    foreach ($translator->getTranslations() as $translation) {
      if (array_key_exists($translation->getName(), $this->translations)) {
        $this->translations[$translation->getName()]->mergeWithTranslation($translation, $overwrite);
      }
    }
  }
}