<?php

class StoreCommand {
  protected $id;
  protected $command;
  protected $description;
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^sc_#', $key)) {
          $key    = str_replace('sc_', '', $key);
          $method = 'set' . Helpers::camelCase($key);
          if (method_exists($this, $method)) {
            $this->$method($value);
          }
        }
      }
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function getDescription() {
    return $this->description;
  }
  
  public function setDescription($description) {
    $this->description = $description;
  }
  
  public function getCommand() {
    return $this->command;
  }
  
  public function setCommand($command) {
    $this->command = $command;
  }
}
