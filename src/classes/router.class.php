<?php

class Router {
  protected $controllers = array();
  
  public function addController($controller) {
    $this->controllers[$controller->getName()] = $controller;
  }
  
  public function getControllers() {
    return $this->controllers;
  }
  
  public function getController($controller) {
    return $this->controllers[$controller];
  }
  
  public function mergeWithRouter($router) {
    foreach ($router->getControllers() as $controller) {
      $this->addController($controller);
    }
  }
}
