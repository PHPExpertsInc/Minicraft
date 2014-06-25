<?php

class Translation {
  protected $name;
  protected $translations = array();
  
  public function __construct($name, $lang) {
    $this->name         = $name;
    $this->translations = $lang;
  }
  
  public function translate($key) {
    return $this->translations[$key];
  }
  
  public function getTranslations() {
    return $this->translations;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  public function getCountries() {
    $countries = $this->translations['COUNTRIES'];
    
    return $countries;
  }
  
  public function mergeWithTranslation($translation, $overwrite = false) {
    foreach ($translation->getTranslations() as $key => $value) {
      if (!array_key_exists($key, $this->translations) or $overwrite) {
        $this->translations[$key] = $value;
      }
    }
  }
}