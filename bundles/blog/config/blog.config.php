<?php

$flash = new Flash;

if (!empty($action)) {
  $categories     = array();
  $all_categories = $ticraft->call('getAllArticleCategories');
  if (!empty($all_categories)) {
    foreach ($all_categories as $key => $value) {
      $categories[] = new ArticleCategory($value);
    }
  }
  
  if (preg_match('#^edit-article-(\d+)#', $action, $matches)) {
    $article = new Article($ticraft->call('getArticleInfosFromId', $matches[1]));
    
    // @todo Check if form was sent using a better method
    if (empty($_POST['article-title']) and empty($_POST['article-body']) and empty($_POST['article-category'])) {
      die($blog_twig->render('edit_article.twig', array(
        'article' => $article,
        'categories' => $categories,
        'pageTitle' => $translator->getTranslation($config->getLanguage(), 'EDIT_ARTICLE'),
        'user' => $user,
        'config' => $config,
        'flash' => $flash
      )));
    } else {
      $title    = trim($_POST['article-title']);
      $body     = trim(stripslashes($_POST['article-body']));
      $category = intval($_POST['article-category']);
      
      if (!empty($title) and $title != $article->getTitle()) {
        $success = $ticraft->call('updateArticleTitle', array(
          $article->getId(),
          $title
        ));
        
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_ARTICLE_TITLE'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_ARTICLE_TITLE'), 'warning');
        }
      }
      
      if (!empty($body) and $body != $article->getBody()) {
        $success = $ticraft->call('updateArticleBody', array(
          $article->getId(),
          $body
        ));
        
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_ARTICLE_BODY'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_CHANGE_ARTICLE_BODY'), 'warning');
        }
      }
      
      if (!empty($category) and $category != $article->getCategory()->getId()) {
        $success = $ticraft->call('updateArticleCategory', array(
          $article->getId(),
          $category
        ));
        
        if ($success) {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_ARTICLE_CATEGORY'), 'success');
        } else {
          $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_CHANGE_ARTICLE_CATEGORY'), 'warning');
        }
      }
      
      Helpers::redirect($router, 'manage', array(
        'blog'
      ));
      die();
    }
  } elseif (preg_match('#^write$#', $action)) {
    if (empty($_POST['article-title']) and empty($_POST['article-body']) and empty($_POST['article-category'])) {
      die($blog_twig->render('write_article.twig', array(
        'categories' => $categories,
        'pageTitle' => $translator->getTranslation($config->getLanguage(), 'WRITE_ARTICLE'),
        'user' => $user,
        'config' => $config,
        'flash' => $flash
      )));
    } else {
      $image_url  = trim(filter_var($_POST['article-image'], FILTER_SANITIZE_URL));
      $title      = trim($_POST['article-title']);
      $body       = trim($_POST['article-body']);
      $category   = intval($_POST['article-category']);
      $custom_cat = trim($_POST['article-new-category']);
      
      $imgur_id = $config->getImgurId();
      
      if (!empty($_FILES['article-image-upload']['name']) and empty($image_url) and !empty($imgur_id)) {
        $filename = $_FILES['article-image-upload']['tmp_name'];
        $handle   = fopen($filename, 'r');
        $data     = fread($handle, filesize($filename));
        $args     = array(
          'image' => base64_encode($data)
        );
        $ch       = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization: Client-ID ' . $imgur_id
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if (!empty($result['data']['link'])) {
          $image_url = $result['data']['link'];
        }
      }
      
      if (!empty($custom_cat)) {
        $result   = $ticraft->call('addArticleCategory', array(
          $custom_cat
        ));
        // 1 should be "No category" or similar
        $category = $result ? $result : 1;
      }
      
      $success = $ticraft->call('addArticle', array(
        $image_url,
        $title,
        $body,
        $user->getId(),
        $category
      ));
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_ADD_ARTICLE'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_ADD_ARTICLE'), 'warning');
      }
      
      Helpers::redirect($router, 'manage', array(
        'blog'
      ));
      die();
    }
  } else {
    Helpers::throw404($twig, $config, $user);
    die();
  }
} elseif (!empty($_POST['remove-article'])) {
  $id      = $_POST['remove-article'];
  $success = $ticraft->call('removeArticle', array(
    $id
  ));
  
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'SUCCESS_REMOVE_ARTICLE'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLanguage(), 'FAIL_REMOVE_ARTICLE'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'blog'
  ));
  die();
} else {
  die($blog_twig->render('admin.twig', array(
    'blog' => new Blog($ticraft->call('getAllArticlesAndAllArticleCategories')),
    'pageTitle' => $translator->getTranslation($config->getLanguage(), 'ADMIN_BLOG'),
    'user' => $user,
    'config' => $config,
    'flash' => $flash
  )));
}