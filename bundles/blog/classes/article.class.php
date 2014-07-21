<?php

class Article {
  protected $id;
  protected $title;
  protected $slug;
  protected $body;
  protected $extract;
  protected $image;
  protected $publication_date;
  protected $author;
  protected $category;
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^a_#', $key)) {
          $key    = str_replace('a_', '', $key);
          $method = 'set' . Helpers::camelCase($key);
          if (method_exists($this, $method)) {
            $this->$method($value);
          }
        }
      }
      
      $this->setCategory(new ArticleCategory($infos));
      $this->setAuthor(new User($infos));
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function __toString() {
    return $this->title;
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function getTitle() {
    return $this->title;
  }
  
  public function setTitle($title) {
    $this->title = $title;
  }
  
  public function getSlug() {
    return $this->slug;
  }
  
  public function setSlug($slug) {
    $this->slug = $slug;
  }
  
  public function getBody() {
    return $this->body;
  }
  
  public function setBody($body) {
    $this->body = $body;
  }
  
  public function getExtract() {
    return $this->extract;
  }
  
  public function setExtract($extract) {
    $this->extract = $extract;
  }
  
  public function getImage() {
    return $this->image;
  }
  
  public function setImage($image) {
    $this->image = $image;
  }
  
  public function getPublicationDate() {
    return $this->publication_date;
  }
  
  public function setPublicationDate($publication_date) {
    $this->publication_date = $publication_date;
  }
  
  public function getAuthor() {
    return $this->author;
  }
  
  public function setAuthor($author) {
    $this->author = $author;
  }
  
  public function getCategory() {
    return $this->category;
  }
  
  public function setCategory($category) {
    $this->category = $category;
  }
}
