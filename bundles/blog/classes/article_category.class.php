<?php

class ArticleCategory {
  protected $id;
  protected $name;
  protected $slug;
  protected $articles = array();
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^ac_#', $key)) {
          $key    = str_replace('ac_', '', $key);
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
  
  public function __toString() {
    return $this->name;
  }
  
  public function addArticle($article) {
    array_push($this->articles, $article);
  }
  
  public function hasArticles() {
    return count($this->articles) > 0;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  public function getSlug() {
    return $this->slug;
  }
  
  public function setSlug($slug) {
    $this->slug = $slug;
  }
  
  public function getArticles() {
    return $this->articles;
  }
}
