<?php

class Blog {
  protected $articles = array();
  protected $categories = array();
  
  public function __construct($infos) {
    if (!empty($infos)) {
      $articles   = $infos[0];
      $categories = $infos[1];
      
      foreach ($categories as $category_infos) {
        $this->categories[$category_infos['c_id']] = new ArticleCategory($category_infos);
      }
      
      foreach ($articles as $article_infos) {
        $this->articles[$article_infos['a_id']] = new Article($article_infos);
      }
      
      foreach ($this->categories as $category) {
        foreach ($this->articles as $article) {
          if ($article->getCategory()->getId() == $category->getId()) {
            $category->addArticle($article);
          }
        }
      }
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function getArticles() {
    return $this->articles;
  }
  
  public function getCategories() {
    return $this->categories;
  }
  
  public function getArticle($id) {
    return $this->articles[$id];
  }
  
  public function getCategory($id) {
    return $this->categories[$id];
  }
}
