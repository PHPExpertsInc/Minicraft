<?php

class Controller {
  protected $name;
  protected $regex;
  protected $url;
  protected $bundle;
  
  public function __construct($name, $regex, $url, $bundle = 'minicraft') {
    $this->setName($name);
    $this->setRegex($regex);
    $this->setUrl($url);
    $this->setBundle($bundle);
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  public function getBundle() {
    return $this->bundle;
  }
  
  public function setBundle($bundle) {
    $this->bundle = $bundle;
  }
  
  public function getRegex() {
    return $this->regex;
  }
  
  public function setRegex($regex) {
    $this->regex = $regex;
  }
  
  public function getUrl() {
    return $this->url;
  }
  
  public function setUrl($url) {
    $this->url = $url;
  }
}
