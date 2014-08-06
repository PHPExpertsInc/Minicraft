<?php

$flash = new Flash;

$categories     = array();
$all_categories = $ticraft->call('getAllArticleCategories');
if (!empty($all_categories)) {
  foreach ($all_categories as $key => $value) {
    array_push($categories, new ArticleCategory($value));
  }
}

if (!empty($action)) {
  if (preg_match('#^edit-article-(\d+)#', $action, $matches)) {
    $infos = $ticraft->call('getArticleInfosFromId', $matches[1]);
    if (!empty($infos)) {
      $article = new Article($infos);
    }
    
    if (is_object($article)) {
      if (empty($_POST)) {
        die($blog_twig->render('edit_article.twig', array(
          'article' => $article,
          'categories' => $categories,
          'pageTitle' => $translator->getTranslation($config->getLang(), 'EDIT_ARTICLE'),
          'user' => $user,
          'config' => $config,
          'flash' => $flash
        )));
      } else {
        $array = $_POST['edit-article'];
        $title    = trim($array['title']);
        $body     = trim(stripslashes($array['body']));
        $category = intval($array['category']);
          
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_ARTICLE_TITLE'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_ARTICLE_TITLE'), 'warning');
          }
        }
        
        if (!empty($title) and $title != $article->getTitle()) {
          $success = $ticraft->call('updateArticleTitle', array(
            $article->getId(),
            $title
          ));
          
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_ARTICLE_TITLE'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_ARTICLE_TITLE'), 'warning');
          }
        }
        
        if (!empty($body) and $body != $article->getBody()) {
          $success = $ticraft->call('updateArticleBody', array(
            $article->getId(),
            $body
          ));
          
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_ARTICLE_BODY'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_ARTICLE_BODY'), 'warning');
          }
        }
        
        if (!empty($category) and $category != $article->getCategory()->getId()) {
          $success = $ticraft->call('changeArticleCategory', array(
            $article->getId(),
            $category
          ));
          
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_ARTICLE_CATEGORY'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_ARTICLE_CATEGORY'), 'warning');
          }
        }
        
        Helpers::redirect($router, 'manage', array(
          'blog'
        ));
        die();
      }
    }
  } elseif (preg_match('#^edit-article-category-(\d+)#', $action, $matches)) {
    $infos = $ticraft->call('getArticleCategoryInfosFromId', $matches[1]);
    if (!empty($infos)) {
      $category = new ArticleCategory($infos);
    }
    
    if (is_object($category)) {
      if (empty($_POST)) {
        die($blog_twig->render('edit_article_category.twig', array(
          'category' => $category,
          'pageTitle' => $translator->getTranslation($config->getLang(), 'EDIT_ARTICLE_CATEGORY'),
          'user' => $user,
          'config' => $config,
          'flash' => $flash
        )));
      } else {
        $name = trim($_POST['name']);
        
        if (!empty($name) and $name != $category->getName()) {
          $success = $ticraft->call('updateArticleCategoryName', array(
            $category->getId(),
            $name
          ));
          
          if ($success) {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CHANGE_ARTICLE_CATEGORY_NAME'), 'success');
          } else {
            $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CHANGE_ARTICLE_CATEGORY_NAME'), 'warning');
          }
        }
                
        Helpers::redirect($router, 'manage', array(
          'blog'
        ));
        die();
      }
    }
  } elseif (preg_match('#^write$#', $action)) {
    if (empty($_POST)) {
      die($blog_twig->render('write_article.twig', array(
        'categories' => $categories,
        'pageTitle' => $translator->getTranslation($config->getLang(), 'WRITE_ARTICLE'),
        'user' => $user,
        'config' => $config,
        'flash' => $flash
      )));
    } else {
      $array = $_POST['write-article'];
      $image_url  = trim(filter_var($array['image'], FILTER_SANITIZE_URL));
      $title      = trim($array['title']);
      $body       = trim($array['body']);
      $category   = intval($array['category']);
      $custom_cat = trim($array['new-category']);
      
      $imgur_id = $config->getImgurId();
      
      if (empty($image_url) and !empty($_FILES['article-image-upload']['name']) and !empty($imgur_id)) {
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
        $result   = $ticraft->call('createArticleCategory', array(
          $custom_cat
        ));
        $category = $result ? $result : 1;
      }
      
      $success = $ticraft->call('createArticle', array(
        $image_url,
        $title,
        $body,
        $user->getId(),
        $category
      ));
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CREATE_ARTICLE'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CREATE_ARTICLE'), 'warning');
      }
      
      Helpers::redirect($router, 'manage', array(
        'blog'
      ));
      die();
    }
  }elseif (preg_match('#^create-article-category$#', $action)) {
    if (empty($_POST)) {
      die($blog_twig->render('create_article_category.twig', array(
        'pageTitle' => $translator->getTranslation($config->getLang(), 'CREATE_ARTICLE_CATEGORY'),
        'user' => $user,
        'config' => $config,
        'flash' => $flash
      )));
    } else {
      $name = trim($_POST['name']);
            
      if (!empty($name)) {
        $success = $ticraft->call('createArticleCategory', array(
          $name,
        ));
      }
      
      if ($success) {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_CREATE_ARTICLE_CATEGORY'), 'success');
      } else {
        $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_CREATE_ARTICLE_CATEGORY'), 'warning');
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
  $id      = intval($_POST['remove-article']);
  $success = $ticraft->call('removeArticle', array(
    $id
  ));
  
  if ($success) {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_REMOVE_ARTICLE'), 'success');
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_REMOVE_ARTICLE'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'blog'
  ));
  die();
} elseif (!empty($_POST['remove-article-category'])) {
  if (count($categories) > 1) {
    $id      = intval($_POST['remove-article-category']);
    $success = $ticraft->call('removeArticleCategory', array(
      $id
    ));
    
    if ($success) {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'SUCCESS_REMOVE_ARTICLE_CATEGORY'), 'success');
    } else {
      $flash->addFlash($translator->getTranslation($config->getLang(), 'FAIL_REMOVE_ARTICLE_CATEGORY'), 'warning');
    }
  } else {
    $flash->addFlash($translator->getTranslation($config->getLang(), 'CANT_REMOVE_UNIQUE_ARTICLE_CATEGORY'), 'warning');
  }
  
  Helpers::redirect($router, 'manage', array(
    'blog'
  ));
  die();
} else {
  die($blog_twig->render('admin.twig', array(
    'blog' => new Blog($ticraft->call('getAllArticlesAndAllArticleCategories')),
    'categories' => $categories,
    'pageTitle' => $translator->getTranslation($config->getLang(), 'ADMIN_BLOG'),
    'user' => $user,
    'config' => $config,
    'flash' => $flash
  )));
}