<?php

class Comment {
  protected $id;
  protected $content;
  protected $author;
  protected $has_replies;
  protected $replies = array();
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^com_#', $key)) {
          $key    = str_replace('com_', '', $key);
          $method = 'set' . Helpers::camelCase($key);
          if (method_exists($this, $method)) {
            $this->$method($value);
          }
        }
      }
      
      foreach ($infos['replies'] as $key => $value) {
        $this->addReply(new Comment($value));
      }
      
      $this->setAuthor(new User($infos));
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
  
  public function getContent() {
    return $this->content;
  }
  
  public function setContent($content) {
    $this->content = $content;
  }
  
  public function getReplies() {
    return $this->replies;
  }
  
  public function addReply($reply) {
    array_push($this->replies[$reply['com_id']], $reply);
  }
}
